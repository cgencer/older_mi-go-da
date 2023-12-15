<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Config, App\Helpers, DiscordRoom, App\Traits\DiscordTrait;
use App\Models\Payments, App\Models\Payloads, App\Models\Customers;
use App\Events\AlertMessages;
use App\Models\ModelStates\PaymentProccessArchived, App\Models\ModelStates\PaymentProccessAuthorized;
use App\Models\ModelStates\PaymentProccessCancelled, App\Models\ModelStates\PaymentProccessCharged;
use App\Models\ModelStates\PaymentProccessCancelledGrace, App\Models\ModelStates\PaymentProccessCancelledHalf;
use App\Models\ModelStates\PaymentProccessCancelledRefunded;
use App\Models\ModelStates\PaymentProccessHold, App\Models\ModelStates\PaymentProccessInvoiced;
use App\Models\ModelStates\PaymentProccessPaid, App\Models\ModelStates\PaymentProccessProccessed;
use App\Models\ModelStates\PaymentProccessRefunded, App\Models\ModelStates\PaymentProccessState;
use App\Models\ModelStates\PaymentProccessSub7, App\Models\ModelStates\PaymentProccessSub2;
use App\Models\ModelStates\PaymentProccessFees, App\Models\ModelStates\PaymentProccessNoFees;
use App\Models\ModelStates\PaymentProccessFailed, App\Models\ModelStates\PaymentProccessRequiresAction;
use App\Models\ModelStates\PaymentProccessDoCharges, App\Models\ModelStates\PaymentProccessStatitics;
use App\Events\UserUpdated, App\Events\HotelUpdated;
use App\Listeners\UserListener, App\Listeners\HotelListener;

class StripeProccess implements ShouldQueue
{
//    use DiscordTrait;

    protected $payload;
    protected $events;

    // Stripe -> receive webhook @Listeners/StripeWebhookListener -> save to Payments
    // queue proccess with @Jobs/StripeProccess


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct($package)
    {
//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
        $this->events = config('services.stripe.hooks');
        $this->payload = $package;

//        $this->discordMsg(implode(',', $this->events));

        if(in_array($this->payload['type'], $this->events)){
            $hook = explode('.', $this->payload['type']);

//            $this->discordMsg('calling ' . $hook[0]);
            $typ = explode('_', str_replace('.', '_', str_replace('_', '', $this->payload['type'])));
            $this->{$hook[0].'s'}(end($typ), $this->payload['data']['object']['id']);
        }

    }

    public function handle()
    {
//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
//        $this->discordMsg('booting up... ( @handle() )');
    }

    public function accounts($hookType, $hookId)
    {
    }

    public function customers($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', $this->payload['type']));
        $id = $this->payload['data']['object']['id'];
        event( new UserUpdated($hookType, $id) );
    }

    public function charges($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', $this->payload['type']));
        switch (end($typ)) {
            case 'created':
                break;
            case 'failed':
                break;
            case 'succeeded':
                break;
            case 'pending':
                break;
            case 'refunded':
                break;
            case 'expired':
                break;
        }
    }

    public function external_accounts($hookType, $hookId)
    {
    }

    public function payouts($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', $this->payload['type']));
        $amo = ($this->payload['data']['object']['amount'] / 100) . ' ' . $this->payload['data']['object']['currency'];
        switch (end($typ)) {
            case 'canceled':
                break;
            case 'created':
                break;
            case 'failed':
                break;
            case 'paid':
                break;
            case 'updated':
                break;
        }

    }

    public function products($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', $this->payload['type']));
        $id = $this->payload['data']['object']['id'];
        $meta = $this->payload['data']['object']['metadata'];
        $meta = is_string($meta) ? json_decode($meta) : $meta;
//        $hotel = Hotels::find($meta['hotel_id']);
        $hotel = Hotels::whereJsonContains('stripe_data->product_sid', $id)->get()->first();
        switch (end($typ)) {
            case 'created':
                $hotel->stripePriceId = $id;
                $hotel->is_enabled = 1;
                $hotel->save();
                break;
            case 'updated':
                $hotel->stripePriceId = $id;
                $hotel->is_enabled = 1;
                $hotel->save();
                break;
            case 'deleted':
                $hotel->is_enabled = 0;
                $hotel->save();
                event(new AlertMessages('The Stripe-copy for your hotel was deleted on Stripe Platform', 
                    $hotel->hotel_user()->get()->first()));
                break;
        }
    }

    public function prices($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', $this->payload['type']));
        $id = $this->payload['data']['object']['id'];
        $prodSid = $this->payload['data']['object']['product'];
        $hotel = Hotels::whereJsonContains('stripe_data->product_sid', $prodSid)->get()->first();
        switch (end($typ)) {
            case 'created':
                $hotel->is_enabled = 1;
                $hotel->stripePriceId = $id;
                $hotel->save();
                break;
            case 'updated':
                $hotel->is_enabled = 1;
                $hotel->stripePriceId = $id;
                $hotel->save();
                break;
            case 'deleted':
                $hotel->is_enabled = 0;
                $hotel->save();
                event(new AlertMessages('The pricetag for your hotel was deleted on Stripe', 
                    $hotel->hotel_user()->get()->first()));
                break;
        }
    }

    public function setup_intents($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', str_replace('_', '', $this->payload['type'])));
        switch (end($typ)) {
            case 'setupfailed':
                $pay = Payments::whereJsonContains('packet->data->object->id', $hookId)->get()->first();
                if($pay){
                    $pay->proccess_status->transitionTo(PaymentProccessFailed::class);
                    event(new AlertMessages('The future payment intent has been rejected for different reasons.', 
                        Customers::find($pay->customer_id)));
                }
                break;
            case 'requiresaction':
                break;
            case 'created':

                $pay = new Payments;
                $pay->event_id        = $hookId;
                $pay->created_at      = $this->payload['data']['object']['created'];
                $pay->event           = $this->payload['type'];
                $pay->packet          = $this->payload['data']['object'];

                $pay->amount          = $this->payload['data']['object']['amount'] ?? null;
                $pay->application_fee = $this->payload['data']['object']['application_fee'] ?? null;
                $pay->currency        = $this->payload['data']['object']['currency'] ?? 'eur';

                $meta = $this->payload['data']['object']['metadata'] ?? [];
                $pay->webhook_id = isset($meta['reservation_uuid']) ? Payloads::whereJsonContains('packet->data->object->metadata->reservation_uuid', $meta['reservation_uuid'])->get()->first()->id : null;

                if(count($meta)>0){
                    $pay->uuid =            in_array('reservation_uuid', $meta) ?       $meta['reservation_uuid'] : '';
                    $pay->hotel_id =        in_array('hotel_id', $meta) ?               $meta['hotel_id'] : null;
                    $pay->customer_id =     in_array('customer_id', $meta) ?            $meta['customer_id'] : null;
                    $pay->country_id =      in_array('country_id', $meta) ?             $meta['country_id'] : null;
                    $pay->reservation_id  = in_array('reservation_id', $meta) ?         $meta['reservation_id'] : null;
                    $pay->checkin  =        in_array('checkin', $meta) ?                $meta['checkin'] : null;
                }
                
                if(isset($this->payload['data']['object']['metadata']['fees'])){
                    $f = Helpers::reformatMeta($this->payload['data']['object']['metadata']['fees']);
                    $pay->fees = Payments::calcFees(
                        (integer) $f->total, 
                        Countries::convert('code', ['id' => $meta['country_id']]),
                        Countries::convert('currency', ['id' => $meta['country_id']])
                    );
                }

                if(isset($this->payload['data']['object']['returns']['url'])){
                    $pay->saveStripeData(['return_url' => $this->payload['data']['object']['returns']['url']]);
                }
                $pay->save();

                $typ = explode('_', str_replace('.', '_', $this->payload['type']));

                break;
            case 'succeeded':
                $pay = Payments::whereJsonContains('packet->data->object->id', $hookId)->get()->first();
                if($pay) $pay->proccess_status->transitionTo(PaymentProccessHold::class);
                break;
            case 'canceled':
                $pay = Payments::whereJsonContains('packet->data->object->id', $hookId)->get()->first();
                if($pay) {
                    $pay->proccess_status->transitionTo(PaymentProccessCancelled::class);
                    event(new AlertMessages('The future payment intent has been cancelled for various reasons.', 
                        Customers::find($pay->customer_id)));
                }
                break;
        }
    }

    public function paymentintents($hookType, $hookId)
    {
        $typ = explode('_', str_replace('.', '_', str_replace('_', '', $this->payload['type'])));
        switch (end($typ)) {
            case 'created':
                $this->setup_intents($hookType, $hookId);
                break;
            case 'canceled':
                $this->setup_intents($hookType, $hookId);
                break;
            case 'succeeded':
                $this->setup_intents($hookType, $hookId);
                break;
            case 'requiresaction':
                $this->setup_intents($hookType, $hookId);
                break;


            case 'paymentfailed':
                break;
            case 'processing':
                break;
            case 'amountcapturableupdated':
                break;
        }
    }

    public function transfers($hookType, $hookId)
    {
    }

    public function orders($hookType, $hookId)
    {
/*
        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
        $this->discordMsg('...booting up... ( @orders() )');

        $pay = new Payments;
        $pay->created_at      = $this->payload['data']['object']['created'];
        $pay->event           = $this->payload['type'];
        $pay->packet          = $this->payload['data']['object'];
        $itsId                = $this->payload['data']['object'];

        if(isset($this->payload['data']['object']['amount']))
            $pay->amount          = (integer) $this->payload['data']['object']['amount'];
        if(isset($this->payload['data']['object']['application_fee']))
            $pay->application_fee = (integer) $this->payload['data']['object']['application_fee'];
        if(isset($this->payload['data']['object']['currency']))
            $pay->currency        = (string) $this->payload['data']['object']['currency'];

        $strippa = [
          'event_sid'   =>  $this->payload['id'],
          'object_sid'  =>  $this->payload['data']['object']['id']
        ];
        if(isset($this->payload['data']['object']['returns']['url']))
            $strippa['return_url'] = $this->payload['data']['object']['returns']['url'];

        $meta = (array) $this->payload['data']['object']['metadata'];
        if(count($meta)>0){
            $pay->uuid =            in_array('reservation_uuid', $meta) ?       $meta['reservation_uuid'] : '';
            $pay->hotel_id =        in_array('hotel_id', $meta) ?               $meta['hotel_id'] : null;
            $pay->customer_id =     in_array('customer_id', $meta) ?            $meta['customer_id'] : null;
            $pay->country_id =      in_array('country_id', $meta) ?             $meta['country_id'] : null;
            $pay->reservation_id  = in_array('reservation_id', $meta) ?         $meta['reservation_id'] : null;
            $pay->checkin  =        in_array('checkin', $meta) ?                $meta['checkin'] : null;
        }

        $pay->stripe_data = array_merge($strippa, $meta);

        $pay->fees = $pay->calcFees(
            (integer) ($this->payload['data']['object']['amount'] ?? 0), 
            Countries::convert('code', ['id' => $meta['country_id']]),
            Countries::convert('currency', ['id' => $meta['country_id']])
        );

        $typ = explode('_', str_replace('.', '_', $this->payload['type']));
        $pay->webhook_id = Payloads::select('id')->where('payload', 'LIKE', '%'.$itsId.'%')->get()->first();
        $pay->save();
        $pay->proccess_status->transitionTo(PaymentProccessHold::class);

*/
    }
}
