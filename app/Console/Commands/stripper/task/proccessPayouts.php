<?php

namespace App\Console\Commands\stripper\task;

use Illuminate\Console\Command;
use App\Models\Customers, App\Models\Hotels, App\Models\Countries, 
    App\Models\Payments, App\Models\Reservation, App\Models\Reservoir;
use App\Models\ModelStates\PaymentProccessArchived, App\Models\ModelStates\PaymentProccessAuthorized;
use App\Models\ModelStates\PaymentProccessCancelled, App\Models\ModelStates\PaymentProccessCharged;
use App\Models\ModelStates\PaymentProccessHold, App\Models\ModelStates\PaymentProccessInvoiced;
use App\Models\ModelStates\PaymentProccessPaid, App\Models\ModelStates\PaymentProccessProccessed;
use App\Models\ModelStates\PaymentProccessRefunded, App\Models\ModelStates\PaymentProccessState;
use App\Models\ModelStates\PaymentProccessSub7, App\Models\ModelStates\PaymentProccessSub2;
use App\Models\ModelStates\PaymentProccessFees, App\Models\ModelStates\PaymentProccessNoFees;
use App\Models\ModelStates\PaymentProccessDoCharges, App\Models\ModelStates\PaymentProccessStatitics;
use App\Models\ModelStates\PaymentProccessCancelledHalf, App\Models\ModelStates\PaymentProccessCancelledGrace;
use App\Models\ModelStates\PaymentProccessCancelledRefunded;
use App\Jobs\ProccessStripePayouts, DB, StripeChannel;
use App\Jobs\StatusSync;

class proccessPayouts extends Command
{
    protected $signature = 'proccess:payments';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
    }

    public function handle()
    {
        //==========================================================
        //                                  /- REFUNDED
        // HOLDED -> AUTHED -> CHARGED -> PAID -> PROCED -> STATED -> ARCHIVED
        //         \- CANCELLED            \
        //                                  \- CANCEL
        //                                      \________ CANCEL-GRACE
        //                                       \_______ CANCEL-HALFPAY
        //==========================================================
        //
        //                   /-> FEES -------> DOCHARGES -\
        //  AUTHED -> SUB7 -|                              \
        //         \         \-> NOFEES -----> DOCHARGES ---+------------------------+--> CHARGED
        //          \                                                               /
        //           \---------------------------------------- SUB2 --> DOCHARGES -/
        //
        //==========================================================
        //  the base SQL, calc'ing the time differences in advance
        //==========================================================
        $main_query = "id, checkin, proccess_status, " .
                "FLOOR((UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(payments.checkin, ' 12:00 PM'), '%Y-%m-%d  %h:%i %p')) - UNIX_TIMESTAMP(NOW()))/3600) as hours, ".
                "FLOOR((UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(payments.checkin, ' 12:00 PM'), '%Y-%m-%d  %h:%i %p')) - UNIX_TIMESTAMP(NOW()))/3600/24) as days, ".
                "FLOOR((UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(payments.checkin, ' 12:00 PM'), '%Y-%m-%d  %h:%i %p')) - UNIX_TIMESTAMP(NOW()))/3600%24) as remaining_hours ";
//        DB::enableQueryLog();

        //==========================================================
        //  HOURS > 7 days
        //----------------------------------------------------------
        //
        //                                      preflight -> hold
        //==========================================================

        $payFar = DB::table('payments')->selectRaw($main_query)
                                        ->where('proccess_status', 'preflight')
                                        ->having('hours', '>=', 24*7)->get();
//dd(DB::getQueryLog());
        $this->warn('proccessing ' . $payFar->count() . ' payment requests with > 7 days');
        $this->bar = $this->output->createProgressBar($payFar->count());

        foreach ($payFar as $item) {
            // proccess later...
//            $this->warn($item->id);
            $singular = Payments::find($item->id)->get()->first();
//            $this->warn($singular->proccess_status);
            $this->syncFlags($$singular, PaymentProccessHold::class);
//            $this->warn($singular->proccess_status);
//            $singular->save();
            $this->bar->advance();
        }
        $this->bar->finish();
        $this->warn('done...');

        //==========================================================
        //  2 days < HOURS < 7 days
        //----------------------------------------------------------
        //  modify penalty according the credit-card type,
        //  set state to AUTHORIZED
        //                                hold -> sub7 -> (no-)fees
        //==========================================================

        $payMid = DB::table('payments')->selectRaw($main_query)
                                        ->where('proccess_status', 'hold')
                                        ->having('hours', '>=', 24*2)
                                        ->having('hours', '<', 24*7)->get();
        $this->warn('proccessing ' . $payMid->count() . ' payment requests with > 2 days < 7 days');
        $this->bar = $this->output->createProgressBar($payFar->count());
        $set = [];
        foreach ($payMid as $item) {
            $set[] = $item->id;
        }
        $this->warn('>7 days: ['.implode(', ', $set).']');
        foreach ($payMid as $item) {
            // charge instamtly...
            $singular = Payments::find($item->id)->get()->first();
            $singularPacket = $singular->packet;

            $this->syncFlags($$singular, ProccessAuthorized::class);
            $this->syncFlags($$singular, PaymentProccessSub7::class);

            $this->warn($singular->customer()->get()->first()->name . ' registered at ' . 
                $singular->hotel()->get()->first()->name . ' on ' . 
                $singular->reservation()->get()->first()->checkin_date);

            $this->bar->advance();

            $cardType = (isset($singularPacket['charges']['data']['payment_method_details']['card']['brand'])) ?
                $singularPacket['charges']['data']['payment_method_details']['card']['brand'] : 'not set';

            if(in_array($cardType, ['visa', 'mastercard', 'master'])){
                $this->syncFlags($$singular, PaymentProccessNoFees::class);
                $singular->fees['penalty'] = 0;
            }else{
                $this->syncFlags($$singular, PaymentProccessFees::class);
                $singular->fees['penalty'] = (integer) $singularPacket['metadata']['fees']['total'] * 0.01;
            }
            $singular->packet['metadata']['fees'] = $singular->fees;
            $this->syncFlags($$singular, PaymentProccessDoCharges::class);
            $singular->save();
        }
        $this->bar->finish();
        $this->warn('done...');

        //==========================================================
        //  HOURS < 48
        //----------------------------------------------------------
        //
        //                                hold -> sub2 -> docharges
        //==========================================================

        $payNear = DB::table('payments')->selectRaw($main_query)
                                        ->where('proccess_status', 'hold')
                                        ->having('hours', '<', 24*2)->get();
        $this->warn('proccessing ' . $payNear->count() . ' payment requests with < 2 days');
        $this->bar = $this->output->createProgressBar($payFar->count());
        $set = [];
        foreach ($payNear as $item) {
            $set[] = $item->id;
        }
        $this->warn('>2 days: ['.implode(', ', $set).']');
        foreach ($payNear as $item) {
            // charge instamtly...
            $singular = Payments::find($item->id)->get()->first();
            $this->syncFlags($$singular, PaymentProccessSub2::class);

            // these are cancellable states (check first):
            // PaymentProccessAuthorized | PaymentProccessCharged | PaymentProccessProccessed
            $this->syncFlags($$singular, PaymentProccessDoCharges::class);
            $this->bar->advance();
            $singular->save();
        }
        $this->bar->finish();
        $this->warn('done...');

        //==========================================================
        //  HOURS = 0
        //----------------------------------------------------------
        //  fire off to the queue to handle the payment,
        //  then move the payment to PAID state
        //                                     docharges -> charged
        //==========================================================

        $payNow = DB::table('payments')->selectRaw($main_query)
                                        ->where('proccess_status', 'docharges')
                                        ->having('hours', '<', 1)
                                        ->get();
        $this->warn('proccessing ' . $payNow->count() . ' payment requests with 0 hours');
        $this->bar = $this->output->createProgressBar($payFar->count());
        $set = [];
        foreach ($payNow as $item) {
            $set[] = $item->id;
        }
        $this->warn('<2 days: ['.implode(', ', $set).']');
        foreach ($payNow as $item) {
            $singular = Payments::find($item->id)->get()->first();
//            dispatch(new ProccessStripePayouts($item));
            $this->syncFlags($$singular, PaymentProccessCharged::class);
//            $singular->proccess_status->transitionTo(PaymentProccessPaid::class);
            $this->bar->advance();
            $singular->save();
        }
        $this->bar->finish();
        $this->warn('done...');






/*
        $i = $this->stripeAPI->attention($this->argument('id'));
        var_dump($i->status);
        $j = $this->stripeAPI->realization($i->id, $this->argument('oh'), $this->argument('ah'), $this->argument('am'));
        var_dump($j->status);
*/ 
        return 0;
    }

    public function syncFlags($singular, $status)
    {
        $this->tag_events($singular);
        $singular->proccess_status->transitionTo($status);
        event(new StatusSync(['uuid' => $singular->uuid, 'status' => $status]));
    }

    public function tag_events(&$singular)
    {
        $singularPacket = $singular->packet;
        if(!isset($singular['marked'])){
            switch ($singular->event) {
                case 'order.payment_failed':
                case 'order.payment_succeeded':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('order_sid', $singularPacket['id']);
                    if(isset($singularPacket['items'][0]['parent']))
                        $singular->addStripeId('item_sku', $singularPacket['items'][0]['parent']);
                    break;

                case 'charge.expired':
                case 'charge.failed':
                case 'charge.pending':
                case 'charge.refunded':
                    if(isset($singularPacket['refunds']['data'][0]['id']))
                        $singular->addStripeId('refund_sid', $singularPacket['refunds']['data'][0]['id']);
                    if(isset($singularPacket['refunds']['data'][0]['balance_transaction']))
                        $singular->addStripeId('refund_transaction_sid', $singularPacket['refunds']['data'][0]['balance_transaction']);
                    if(isset($singularPacket['refunds']['data'][0]['charge']))
                        $singular->addStripeId('refund_charge_sid', $singularPacket['refunds']['data'][0]['charge']);
                    if(isset($singularPacket['refunds']['data'][0]['payment_intent']))
                        $singular->addStripeId('refund_intent_sid', $singularPacket['refunds']['data'][0]['payment_intent']);
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('charge_sid', $singularPacket['id']);
                    if(isset($singularPacket['balance_transaction']))
                        $singular->addStripeId('transaction_sid', $singularPacket['balance_transaction']);
                    if(isset($singularPacket['payment_method']))
                        $singular->addStripeId('paymethod_sid', $singularPacket['payment_method']);
                    if(isset($singularPacket['receipt_url']))
                        $singular->addStripeId('receipt_url', $singularPacket['receipt_url']);
                    if(isset($singularPacket['refunds']['url']))
                        $singular->addStripeId('refund_url', $singularPacket['refunds']['url']);
                    break;
                case 'charge.failed':
                case 'charge.succeeded':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('charge_sid', $singularPacket['id']);
                    if(isset($singularPacket['balance_transaction']))
                        $singular->addStripeId('transaction_sid', $singularPacket['balance_transaction']);
                    if(isset($singularPacket['payment_method']))
                        $singular->addStripeId('paymethod_sid', $singularPacket['payment_method']);
                    if(isset($singularPacket['receipt_url']))
                        $singular->addStripeId('receipt_url', $singularPacket['receipt_url']);
                    if(isset($singularPacket['refunds']['url']))
                        $singular->addStripeId('refund_url', $singularPacket['refunds']['url']);
                    break;

                case 'payment_intent.created':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('intent_sid', $singularPacket['id']);
                    if(isset($singularPacket['charges']['url']))
                        $singular->addStripeId('charge_url', $singularPacket['charges']['url']);
                    if(isset($singularPacket['client_secret']))
                        $singular->addStripeId('client_secret', $singularPacket['client_secret']);
                    break;
                case 'payment_intent.succeeded':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('intent_sid', $singularPacket['id']);
                    if(isset($singularPacket['charges']['url']))
                        $singular->addStripeId('charge_url', $singularPacket['charges']['url']);
                    if(isset($singularPacket['client_secret']))
                        $singular->addStripeId('client_secret', $singularPacket['client_secret']);
                    if(isset($singularPacket['charges']['data'][0]['id']))
                        $singular->addStripeId('charge_sid', $singularPacket['charges']['data'][0]['id']);
                    if(isset($singularPacket['charges']['data'][0]['balance_transaction']))
                        $singular->addStripeId('transaction_sid', $singularPacket['charges']['data'][0]['balance_transaction']);
                    if(isset($singularPacket['charges']['data'][0]['customer']))
                        $singular->addStripeId('customer_sid', $singularPacket['charges']['data'][0]['customer']);
                    if(isset($singularPacket['charges']['data'][0]['receipt_url']))
                        $singular->addStripeId('receipt_url', $singularPacket['charges']['data'][0]['receipt_url']);
                    if(isset($singularPacket['charges']['data'][0]['payment_intent']))
                        $singular->addStripeId('intent_sid', $singularPacket['charges']['data'][0]['payment_intent']);
                    if(isset($singularPacket['charges']['data'][0]['payment_method']))
                        $singular->addStripeId('paymethod_sid', $singularPacket['charges']['data'][0]['payment_method']);
                    break;

                case 'order.payment_failed':
                case 'order.payment_succeeded':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('order_sid', $singularPacket['id']);
                    if(isset($singularPacket['items'][0]['parent']))
                        $singular->addStripeId('parent_sid', $singularPacket['items'][0]['parent']);
                    if(isset($singularPacket['returns']['url']))
                        $singular->addStripeId('return_url', $singularPacket['returns']['url']);
                    break;

                case 'payout.created':
                case 'payout.failed':
                case 'payout.paid':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('payout_sid', $singularPacket['id']);
                    if(isset($singularPacket['balance_transaction']))
                        $singular->addStripeId('transaction_sid', $singularPacket['balance_transaction']);
                    if(isset($singularPacket['destination']))
                        $singular->addStripeId('destination_sid', $singularPacket['destination']);
                    break;

                case 'transfer.created':
                case 'transfer.paid':
                    if(isset($singularPacket['id']))
                        $singular->addStripeId('payout_sid', $singularPacket['id']);
                    if(isset($singularPacket['balance_transaction']))
                        $singular->addStripeId('transaction_sid', $singularPacket['balance_transaction']);
                    if(isset($singularPacket['destination']))
                        $singular->addStripeId('transfer_destination_sid', $singularPacket['destination']);
                    if(isset($singularPacket['destination_payment']))
                        $singular->addStripeId('destination_payment_sid', $singularPacket['destination_payment']);
                    if(isset($singularPacket['reversals']['url']))
                        $singular->addStripeId('reversal_url', $singularPacket['reversals']['url']);
                    break;
            }
            $singular['marked'] = true;
        }
    }

}
