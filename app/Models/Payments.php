<?php

namespace App\Models;

use App\Models\ModelStates\PaymentProccessArchived;
use App\Models\ModelStates\PaymentProccessAuthorized;
use App\Models\ModelStates\PaymentProccessCancelled;
use App\Models\ModelStates\PaymentProccessCancelledGrace;
use App\Models\ModelStates\PaymentProccessCancelledHalf;
use App\Models\ModelStates\PaymentProccessCancelledRefunded;
use App\Models\ModelStates\PaymentProccessCharged;
use App\Models\ModelStates\PaymentProccessDoCharges;
use App\Models\ModelStates\PaymentProccessFailed;
use App\Models\ModelStates\PaymentProccessFees;
use App\Models\ModelStates\PaymentProccessHold;
use App\Models\ModelStates\PaymentProccessInvoiced;
use App\Models\ModelStates\PaymentProccessNoFees;
use App\Models\ModelStates\PaymentProccessPaid;
use App\Models\ModelStates\PaymentProccessPreflight;
use App\Models\ModelStates\PaymentProccessProccessed;
use App\Models\ModelStates\PaymentProccessRefunded;
use App\Models\ModelStates\PaymentProccessRequiresAction;
use App\Models\ModelStates\PaymentProccessState;
use App\Models\ModelStates\PaymentProccessStatitics;
use App\Models\ModelStates\PaymentProccessSub2;
use App\Models\ModelStates\PaymentProccessSub7;
use App\Models\Hotels, App\Models\Reservoir;
use Config;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\HasStates;
use Mpociot\VatCalculator\VatCalculator;

/**
 * @property PaymentProccessState $proccess_status
 * @property PaymentInvoiceState $invoice_status
 */
class Payments extends Model
{
    use Uuids, SoftDeletes, HasStates;

    protected $table = 'payments';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'stripe_data' => 'array',
        'packet' => 'array',
        'fees' => 'array'
    ];
    protected $appends = ['cancelLink', 'intent_sid', 'payout_sid', 'customer_sid'];

// Usage: $payment->proccess_status->transitionTo(ProccessAuthorized::class);

    protected function registerStates(): void
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

        try {
            $this->addState('proccess_status', PaymentProccessState::class)
                ->default(PaymentProccessPreflight::class)
                ->allowTransition(PaymentProccessPreflight::class, PaymentProccessHold::class)
                ->allowTransition(PaymentProccessHold::class, PaymentProccessHold::class)
                ->allowTransition(PaymentProccessHold::class, PaymentProccessAuthorized::class)

                ->allowTransition(PaymentProccessAuthorized::class, PaymentProccessSub2::class)
                ->allowTransition(PaymentProccessSub2::class, PaymentProccessDoCharges::class)
                ->allowTransition(PaymentProccessDoCharges::class, PaymentProccessCharged::class)
                ->allowTransition(PaymentProccessCharged::class, PaymentProccessPaid::class)
                ->allowTransition(PaymentProccessPaid::class, PaymentProccessProccessed::class)
                ->allowTransition(PaymentProccessProccessed::class, PaymentProccessStatitics::class)
                ->allowTransition(PaymentProccessStatitics::class, PaymentProccessArchived::class)
                ->allowTransition(PaymentProccessPaid::class, PaymentProccessRefunded::class)

                ->allowTransition(PaymentProccessAuthorized::class, PaymentProccessSub7::class)
                ->allowTransition(PaymentProccessSub7::class, PaymentProccessFees::class)
                ->allowTransition(PaymentProccessSub7::class, PaymentProccessNoFees::class)
                ->allowTransition(PaymentProccessNoFees::class, PaymentProccessDoCharges::class)
                ->allowTransition(PaymentProccesssFees::class, PaymentProccessDoCharges::class)
                ->allowTransition(PaymentProccessDoCharges::class, PaymentProccessCharged::class)
                ->allowTransition(PaymentProccessCharged::class, PaymentProccessPaid::class)
                ->allowTransition(PaymentProccessPaid::class, PaymentProccessProccessed::class)
                ->allowTransition(PaymentProccessProccessed::class, PaymentProccessStatitics::class)
                ->allowTransition(PaymentProccessStatitics::class, PaymentProccessArchived::class)
                ->allowTransition(PaymentProccessPaid::class, PaymentProccessRefunded::class)

                ->allowTransition([                             // allow cancellations at...
                        PaymentProccessPreflight::class,
                        PaymentProccessAuthorized::class,
                        PaymentProccessHold::class,
                        PaymentProccessCharged::class,
                        PaymentProccessProccessed::class,
                        PaymentProccessFees::class,
                        PaymentProccessNoFees::class,
                        PaymentProccessSub2::class,
                        PaymentProccessSub7::class,
                        PaymentProccessPaid::class,
                ], PaymentProccessCancelled::class)

                ->allowTransition([
                    PaymentProccessPreflight::class,
                    PaymentProccessArchived::class,
                    PaymentProccessAuthorized::class,
                    PaymentProccessCancelled::class,
                    PaymentProccessCancelledGrace::class,
                    PaymentProccessCancelledHalf::class,
                    PaymentProccessCancelledRefunded::class,
                    PaymentProccessCharged::class,
                    PaymentProccessDoCharges::class,
                    PaymentProccessFees::class,
                    PaymentProccessHold::class,
                    PaymentProccessInvoiced::class,
                    PaymentProccessNoFees::class,
                    PaymentProccessPaid::class,
                    PaymentProccessPreflight::class,
                    PaymentProccessProccessed::class,
                    PaymentProccessRefunded::class,
                    PaymentProccessRequiresAction::class,
                    PaymentProccessState::class,
                    PaymentProccessStatitics::class,
                    PaymentProccessSub2::class,
                    PaymentProccessSub7::class,
                ], PaymentProccessFailed::class)

                ->allowTransition(PaymentProccessHold::class, PaymentProccessRequiresAction::class)
                ->allowTransition(PaymentProccessCancelled::class, PaymentProccessRefunded::class)
                ->allowTransition(PaymentProccessRefunded::class, PaymentProccessStatitics::class);
        } catch (InvalidConfig $e) {
        }

    }

    public function addStripeId($tag, $id)
    {
        $this->stripe_data = ($this->stripe_data === null) ? [] : $this->stripe_data;
        $this->stripe_data = array_merge($this->stripe_data, [$tag => $id]);
        $this->save();
    }

    public function getCancelLinkAttribute()
    {
        if(in_array($this->proccess_status, ['authed', 'charged', 'proced', 'fees', 'nofees', 'sub2', 'sub7', 'paid'])){
            return config('app.url') . '/cancellation/' . $this->uuid;
        }else{
            return '';
        }
    }

    public function getInvoiceData()
    {
        $theResv = $this->reservation()->get()->first();
        $invoiceNo = getInvoiceNo($theResv->stripe_data['pay_sid']);
            if(in_array($this->proccess_status, ['paid', 'proced', 'stated', 'archived'])){
                return [
                    'invoice_no' => $invoiceNo,
                    'payout' => $theResv->checkin_date,
                    'checkin' => $theResv->checkin_date,
                    'checkout' => $theResv->checkout_date,
                    'hotel_id' => $theResv->hotel_id,                                                   // Hotel ID
                    'connected_id' => $this->hotel()->get()->first()->stripe_data['product_sid'],      // Stripe Connected Account ID
                    'account_id' => $this->stripe_data['account_sid'],
                    'reference_id' => $this->stripe_data['intent_sid'],  // Stripe Reference Number: intent / payout id
                    'hotel_name' => $this->hotel()->get()->first()->name,
                    'hotel_address' => $this->hotel()->get()->first()->address,
                    'hotel_zip' => $this->hotel()->get()->first()->zip,
                    'hotel_city' => $this->hotel()->get()->first()->getCityName(),
                    'hotel_country' => $this->hotel()->get()->first()->getCountryName(),
                    'fees' => $this->calcFees($theResv->price)
                ];
            }
        return false;
    }

    public function getInvoiceNo($pay_sid)
    {
        $no = Reservoir::where('vkey', 'invoice.'.$pay_sid)->get()->pluck('vval')->first();
        if($no !== null){
            return (String) $no;
        }
        return false;
    }

    public static function calcFees($val, $country='DE', $curr='eur', $penalty=false)
    {
        if($val > 0){
            $migodaCountry = 'DE';
            $multi = 100;
            $vat_perc = floatval(Config::get('services.stripe.commission_fixd')) % $multi;
            $penalty_real = 0.5;

            $vatCalculator = new VatCalculator();
            $vatCalculator->setBusinessCountryCode($migodaCountry);

            $hotelCountry = $country;

            $stripeCommissionValue = round(( ($val * 0.01) * floatval(Config::get('services.stripe.commission_rate'))) + floatval(Config::get('services.stripe.commission_fixd')), 2);
            $migodaCommissionValue = round(( ($val * 0.01) * floatval(Config::get('services.migoda.commission_rate'))), 2);

            $stripe_fee = ($hotelCountry === $migodaCountry) ?
                                    $stripeCommissionValue + ($stripeCommissionValue * $vat_perc) : $stripeCommissionValue;
            $migoda_fee = ($hotelCountry === $migodaCountry) ?
                                    $migodaCommissionValue + ($migodaCommissionValue * $vat_perc) : $migodaCommissionValue;

            return [
                'total'     => $val,

                'vat'       => (($hotelCountry === $migodaCountry) ? $migodaCommissionValue * $vat_perc : 0),
                'stripe'    => $stripe_fee,
                'migoda'    => $migoda_fee,
                'hotel'     => ($val - ($migoda_fee + $stripe_fee)),
                'penalty'   => ($penalty ? $total * 0.01 : 0),

                'vat_perc'  => ($vat_perc * $multi),
                'migoda_perc'=> Config::get('services.migoda.commission_rate'),
                'multiplier'=> $multi,

                'currency'  => $curr
            ];
        }
    }

    public function calcAndSaveFees($val, $country='DE', $curr='eur', $penalty=false)
    {
        $this->fees = $this->calcFees($val, $country, $curr, $penalty);
        $this->save();
    }

    public function getIntentSidAttribute()
    {
        return $this->stripe_data['intent_sid'] ?? null;
    }

    public function getPayoutSidAttribute()
    {
        return $this->stripe_data['payout_sid'] ?? null;
    }

    public function getCustomerSidAttribute()
    {
        return $this->stripe_data['customer_sid'] ?? null;
    }

    public function setIntentSidAttribute($sid)
    {
        $this->saveStripeData(['intent_sid' => $sid]);
    }

    public function setPayoutSidAttribute($sid)
    {
        $this->saveStripeData(['payout_sid' => $sid]);
    }

    public function setCustomerSidAttribute($sid)
    {
        $this->saveStripeData(['customer_sid' => $sid]);
    }

    public function reservation()
    {
        return $this->belongsTo('App\Models\Reservation', 'reservation_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers', 'customer_id', 'id');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotels', 'hotel_id', 'id');
    }

    public function payload()
    {
        return $this->belongsTo('App\Models\Payloads', 'webhook_id', 'id');
    }

    public function saveStripeData($in)
    {
        $merger = [];
        $evt_id = $this->payload['id'] ?? null;
        $obj_id = $this->payload['data']['object']['id'] ?? null;
        if($evt_id)
            $merger['event_sid'] = $evt_id;
        if($obj_id)
            $merger['object_sid'] = $obj_id;
        $this->stripe_data = array_merge($this->stripe_data ?? [], $in, $merger);
        $this->save();
    }

}
