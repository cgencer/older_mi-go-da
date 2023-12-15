<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command;
use Hash, Faker, Artisan, Carbon\Carbon, StripeChannel, App\Helpers;
use App\Models\Payments, App\Models\Hotels, App\Models\Customers;
use App\Models\Countries, App\Models\Reservation, App\Models\Reservoir;
use App\Models\ModelStates\PaymentProccessArchived, App\Models\ModelStates\PaymentProccessAuthorized;
use App\Models\ModelStates\PaymentProccessCancelled, App\Models\ModelStates\PaymentProccessCharged;
use App\Models\ModelStates\PaymentProccessHold, App\Models\ModelStates\PaymentProccessInvoiced;
use App\Models\ModelStates\PaymentProccessPaid, App\Models\ModelStates\PaymentProccessProccessed;
use App\Models\ModelStates\PaymentProccessRefunded, App\Models\ModelStates\PaymentProccessState;
use App\Models\ModelStates\PaymentProccessSub7, App\Models\ModelStates\PaymentProccessSub2;
use App\Models\ModelStates\PaymentProccessFees, App\Models\ModelStates\PaymentProccessNoFees;
use App\Models\ModelStates\PaymentProccessDoCharges, App\Models\ModelStates\PaymentProccessStatitics;

class createFakes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan stripper:create:fakes q=payments -n=100 country=de
     * php artisan stripper:create:fakes q=events -n=100 c=de,en
     * php artisan stripper:create:fakes w=p -n=100                        100 payments
     * php artisan stripper:create:fakes w=e -n=100                        100 events
     * php artisan stripper:create:fakes undo                              delete created customers and related content
     *
     * @var string
     */
    protected $signature = 'stripper:create:fakes {q=payments} {--n=} {--c=de} {--p=} {--s=}';
    protected $faker;
    protected $blocks = [
        'de_DE' => 64,
        'de_AT' => 16,
        'de_CH' => 20
    ];
    protected $homogene = [];
    protected $sampler = [];
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fake content for various tables...';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $qq = explode('=', $this->argument('q'));
        $q = $qq[1];

        if(in_array($this->option('p'), ['web', 'mobile', 'tablet'])){
            $option_p = $this->option('p');
        }
        if(in_array($this->option('s'), ['preflight', 'hold', 'authed', 'sub2', 'sub7', 'fees', 
                                         'nofees', 'docharges', 'charged', 'invoiced', 'paid', 
                                         'proced', 'stated', 'archived', 'cancelled', 'refunded'])){
            $option_s = $this->option('s');
        }

        if($q === 'events'){
/*
                $dt = new Carbon;
                $this->faker = Faker\Factory::create($locale);

                $timestamp = $dt->carbonize($this->faker->dateTimeThisMonth)->valueOf();
                $gender = 'male';
                $mail = $this->faker->email;

                while (Customers::where('email', $mail)->count()>0) {
                    $mail = $this->faker->email;
                }

                $adres = [
                    'city'          => $this->faker->city,
                    'country'       => $this->faker->countryCode,
                    'line1'         => $this->faker->streetAddress,
                    'line2'         => null,
                    'postal_code'   => $this->faker->postcode,
                    'state'         => isset($this->faker->state) ? $this->faker->state : null
                ];

                $dt = new Carbon;
                $created = $dt->carbonize($this->faker->dateTimeThisYear)->valueOf();

                $adults = (String) $this->faker->numberBetween(1, 3);
                $children = (String) $this->faker->numberBetween(0, 3);
                $daysStay = (String) $this->faker->numberBetween(2, 14);

                $dt = new Carbon;
                $daysofstay = $this->faker->numberBetween(1, 7);
                $checkin = !isset($checkout) ? 
                    $dt->carbonize($this->faker->dateTimeBetween('now', '+2 months'))->midDay() : 
                    $checkout->addDays($this->faker->numberBetween(3, 7))->midDay();
                $checkout = $checkin->addDays($daysofstay)->midDay();

                $hotel = Hotels::where('country_id', Countries::convert('id', ['code'=> substr($locale, -2)]))->inRandomOrder()->get()->first();

                $amount = $hotel->priceCents * ($adults + $children) * $daysofstay;

                $customer = new Customers;
                $customer->uuid = $this->faker->uuid;
                $customer->oldID = 9999999;
                $customer->name = $this->faker->firstName($gender);
                $customer->username = $this->faker->userName;
                $customer->email = $mail;
                $customer->email_verified_at = $timestamp;
                $customer->enabled = 1;
                $customer->password = Hash::make($this->faker->password);
                $customer->last_login = $timestamp;
                $customer->firstname = $customer->name;
                $customer->lastname = $this->faker->lastName;
                $customer->prefix = Countries::convert('prefix', ['code'=> substr($locale, 0, 2)]);
                $customer->country = Countries::convert('iso3', ['code'=> substr($locale, 0, 2)]);
                $customer->phone = $this->faker->phoneNumber;
                $customer->profile_image = $this->faker->imageUrl(640,480);
                $customer->date_of_birth = $this->faker->dateTimeThisCentury->format('Y-m-d');
                $customer->website = $this->faker->domainName;
                $customer->biography = $this->faker->realText();
                $customer->gender = $gender;
                $customer->locale = $locale;
                $customer->stripe_data = [
                    'customer_sid' => $samecustomer
                ];
                $customer->timezone = $this->faker->timezone;
                $customer->remember_token = $this->faker->sha256;
                $customer->created_at = $created;
                $customer->updated_at = $created;
                $customer->deleted_at = null;
                $customer->email_token = $this->faker->sha256;
                $customer->currency = 'eur';
                $customer->billing_address = $adres['line1'] . '; ' . $adres['city'] . ' - ' . $adres['state'] . ', ' . $adres['country'];
                $customer->save();

                $daysStay = (String) $this->faker->numberBetween(2, 14);
                $checkin = isset($checkout) ? 
                    $checkout->add($this->faker->numberBetween(1, 5) . ' days') : 
                    $dt->carbonize($this->faker->dateTimeBetween('now', '+2 months'));
                $checkout = $dt->carbonize($checkin)->add($daysStay . ' days');

                $reservation = new Reservation;
                $reservation->hotel_id = $hotel->id;
                $reservation->customer_id = $customer->id;
                $reservation->checkin_date = $checkin->toDateString();
                $reservation->checkout_date = $checkout->toDateString();
                $reservation->status = 1;
                $reservation->uuid = $this->faker->uuid;
                $reservation->guest_adult = $adults;
                $reservation->guest_child = $children;
                $reservation->comments = $this->faker->realText();
                $reservation->main_guest = $customer->firstname . ' ' . $customer->lastname;
                $reservation->email = $mail;
                $reservation->dob = $this->faker->dateTimeThisCentury->format('Y-m-d');
                $reservation->phone = $this->faker->phoneNumber;
                $reservation->reason_id = null;
                $reservation->other_reason  = null;
                $reservation->price = $amount;
                $reservation->gender = substr($gender, 0, 1);
                $reservation->stripe_data = [
                    'customer_sid' => $samecustomer
                ];
                $reservation->created_at = $timestamp;
                $reservation->updated_at = $timestamp;
                $reservation->deleted_at = null;
                $reservation->save();

            $evtid = $this->faker->randomNumber(7) . $this->faker->randomNumber(7);

            $event_orders = [
                'id'                => 'or_' . $evtid,
                'object'            => 'order',
                'amount'            => $hotel->priceCents,
                'amount_returned'   => null,
                'application'       => null,
                'application_fee'   => $fees['stripe'],
                'charge'            => $fees['total'],
                'created'           => $timestamp,
                'currency'          => 'eur',
                'customer'          => $samecustomer,
                'email'             => $customer->email,
                'items'             => [
                    [
                        'object'            => 'order_item',
                        'amount'            => $hotel->priceCents,
                        'currency'          => 'eur',
                        'description'       => $daysStay . ' meals for ' . ($adults+$children) . ' guests at ' . $hotel->name,
                        'parent'            => '',
                        'quantity'          => $daysStay * ($adults+$children),
                        'type'              => 'sku'
                    ]
                ],
                'livemode'          => false,
                'metadata'          => [
                    'fees'              => $fees,
                    'hotel_id'          => $hotel->id,
                    'customer_id'       => $customer->id,
                    'country_id'        => $hotel->country_id,
                    'reservation_id'    => $reservation->id,
                    'checkin'           => $checkin->toDateString(),
                    'reservation_uuid'  => $reservation->uuid,
                    'duration'          => $daysStay,
                    'adults'            => $adults,
                    'children'          => $children
                ],
                'returns' => [
                    'object'                    => 'list',
                    'data'                      => [],
                    'has_more'                  => false,
                    'url'                       => '/v1/order_returns?order=or_' . $this->faker->md5
                ],
                'selected_shipping_method'  => null,
                'shipping'                  => [
                    'address'                   => $adres,
                    'carrier'                   => null,
                    'name'                      => $customer->firstname . ' ' . $customer->lastname,
                    'phone'                     => $this->faker->e164PhoneNumber,
                    'tracking_number'           => null
                ],
                'shipping_methods'          => null,
                'status'                    => 'created',
                'status_transitions'        =>  [
                    'canceled'                  => null,
                    'fulfiled'                  => null,
                    'paid'                      => null,
                    'returned'                  => null,
                ],
                'updated'                   => $timestamp
            ];

            $event_charges = [
                "id"                        => "pi_" . $evtid,
                "object"                    => 'payment_intent',
                "amount"                    => $amount,
                "amount_capturable"         => 0,
                "amount_received"           => 0,
                "application"               => null,
                "application_fee_amount"    => null,
                "canceled_at"               => null,
                "cancellation_reason"       => null,
                "capture_method"            => 'automatic',
                "charges" => [
                    "object"                    => "list",
                    "data"                      => [],
                    "has_more"                  => false,
                    "total_count"               => 0,
                    "url"                       => '\/v1\/charges?payment_intent=pi_' . $evtid
                ],
                "client_secret"             => 'pi_' . $evtid . '_secret_tNdC9nRG067wWtkFOy9QOg12G',
                "confirmation_method"       => 'automatic',
                "created"                   => $timestamp,
                "currency"                  => 'usd',
                "customer"                  => null,
                "description"               => "(created by Stripe CLI)",
                "invoice"                   => null,
                "last_payment_error"        => null,
                "livemode"                  => false,
                "metadata"                  => [],
                "next_action"               => null,
                "on_behalf_of"              => null,
                "payment_method"            => null,
                "payment_method_options"    => [
                    "card" => [
                        "installments"              => null,
                        "network"                   => null,
                        "request_three_d_secure"    => 'automatic'
                    ]
                ],
                "payment_method_types"      => ['card'],
                "receipt_email"             => null,
                "review"                    => null,
                "setup_future_usage"        => null,
                "shipping"                  => null,
                "source"                    => null,
                "statement_descriptor"      => null,
                "statement_descriptor_suffix" => null,
                "status"                    => 'requires_payment_method',
                "transfer_data"             => null,
                "transfer_group"            => null
            ];

            $event_payouts = [
                "id"                        => 'po_' . $evtid,
                "object"                    => 'payout',
                "amount"                    => $amount,
                "arrival_date"              => $timestamp,
                "automatic"                 => true,
                "balance_transaction"       => 'txn_00000000000000',
                "created"                   => $timestamp,
                "currency"                  => 'eur',
                "description"               => "STRIPE PAYOUT",
                "destination"               => 'ba_1Hk6Q2CpynlDkhsMNH3wiVdy',
                "failure_balance_transaction" => null,
                "failure_code"              => null,
                "failure_message"           => null,
                "livemode"                  => false,
                "metadata" => [],
                "method"                    => 'standard',
                "original_payout"           => null,
                "reversed_by"               => null,
                "source_type"               => 'card',
                "statement_descriptor"      => null,
                "status"                    => 'in_transit',
                "type"                      => 'bank_account'
            ];

            $event_transfers = [
                "id"                        => 'tr_' . $evtid,
                "object"                    => 'transfer',
                "amount"                    => $amount,
                "amount_reversed"           => 0,
                "balance_transaction"       => 'txn_00000000000000',
                "created"                   => $timestamp,
                "currency"                  => 'eur',
                "description"               => null,
                "destination"               => 'acct_1H3FdiCpynlDkhsM',
                "destination_payment"       => 'py_IKltHqV47gsQsP',
                "livemode"                  => false,
                "metadata" => [],
                "reversals" => [
                    "object"                    => 'list',
                    "data"                      => [],
                    "has_more"                  => false,
                    "url"                       => '/v1/transfers/tr_'.$evtid.'/reversals'
                ],
                "reversed"                  => false,
                "source_transaction"        => null,
                "source_type"               => 'card',
                "transfer_group"            => null
            ];

            $eventNames = [
                'order.payment_succeeded', 'order.payment_failed',
                'charge.dispute_created', 'charge.expired', 'charge.failed',
                'charge.pending', 'charge.refunded', 'charge.succeeded',
                'payout.created', 'payout.failed', 'payout.paid',
                'transfer.created', 'transfer.paid'
            ];

            $pay = new Payments;
            $eventid = $this->faker->randomNumber(7) . $this->faker->randomNumber(7);
            $pay->packet = [
                'created'           => $created,
                'livemode'          => true,
                'id'                => 'evt_' . $eventid,
                'type'              => 'order.payment_succeeded',
                'object'            => 'event',
                'request'           => null,
                'pending_webhooks'  => 1,
                'api_version'       => '2020-08-27',
                'account'           => 'acct_' . $this->faker->randomNumber(7) . $this->faker->randomNumber(7),
                'data'              => [
                    'object'            => $event
                ]
            ];
            $pay->uuid = $reservation->uuid;
            $pay->hotel_id = $hotel->id;
            $pay->customer_id = $customer->id;
            $pay->country_id = $hotel->country_id;
            $pay->reservation_id  = $reservation->id;
            $pay->checkin  = $checkin->toDateString();
            $pay->amount          = (integer) $amount;
            $pay->application_fee = $fees['migoda'];
            $pay->created_at      = $timestamp;
            $pay->currency        = 'eur';
            $pay->stripe_data     = [
              'event_sid'   =>  'evt_' . $eventid,
              'order_sid'   =>  'or_' . $orderid,
            ]; 
            $pay->save();









*/
        }else if($q === 'payments'){

            $numEntries = $this->option('n');
            foreach ($this->blocks as $key => $val) {
                for ($i=0; $i < $val; $i++) { 
                    $this->sampler[] = $key;
                    shuffle($this->sampler);
                }
            }

            if($numEntries<100){
                $this->homogene = array_slice($this->sampler, 0, $numEntries);
            }else{
                for ($y=1; $y < $numEntries/100; $y++) {
                    $this->homogene[] = $this->sampler;
                }
                shuffle($this->sampler);
                $this->homogene[] = array_slice($this->sampler, 0, $numEntries%100);
                $this->homogene = Helpers::array_flatten($this->homogene);
            }

            $this->bar = $this->output->createProgressBar($numEntries);

            foreach ($this->homogene as $locale) {

                $this->faker = Faker\Factory::create($locale);
                $dtm = $this->faker->dateTimeThisMonth;         //DateTime object
                $dt = new Carbon($dtm);

                $timestamp = $dt->carbonize($this->faker->dateTimeThisMonth)->timestamp;

                $gender = 'male';
                $mail = $this->faker->email;

                while (Customers::where('email', $mail)->count()>0) {
                    $mail = $this->faker->email;
                }

                $adres = [
                    'city'          => $this->faker->city,
                    'country'       => $this->faker->countryCode,
                    'line1'         => $this->faker->streetAddress,
                    'line2'         => null,
                    'postal_code'   => $this->faker->postcode,
                    'state'         => isset($this->faker->state) ? $this->faker->state : null
                ];

                $dt = new Carbon;
                $created = $dt->carbonize($this->faker->dateTimeThisYear)->valueOf();

                $adults   = rand(1, 3);
                $children = rand(0, 3);
                $daysStay = rand(0, 7) + 2;

                $dt = new Carbon;
                $checkin = !isset($checkout) ? 
                    $dt->carbonize($this->faker->dateTimeBetween('now', '+2 months'))->midDay() : 
                    $checkout->addDays($this->faker->numberBetween(3, 7))->midDay();
                $checkout = $checkin->addDays($daysStay)->midDay();

                $hotel = Hotels::where('country_id', Countries::convert('id', [
                    'code'=> substr($locale, -2)]))->inRandomOrder()->get()->first();

                $amount = $hotel->priceCents * ($adults + $children) * $daysStay;

//                $this->warn('registration details:::    hotelid: '.$hotel->id.'   price: '.$hotel->priceCents.' / total: '.$amount.'   adults: '.$adults.'   children: '.$children.'   days: '.$daysofstay);
//                $fees = $this->stripeAPI->calcFee((integer) $amount, $hotel->comission_rate, 'eur');
  //              var_dump($fees);

                $samecustomer = 'cus_'.substr($this->faker->md5, 0, 14);

                $customer = new Customers;
                $customer->uuid = $this->faker->uuid;
                $customer->oldID = 9999999;
                $customer->name = $this->faker->firstName($gender);
                $customer->username = $this->faker->userName;
                $customer->email = $mail;
                $customer->email_verified_at = $timestamp;
                $customer->enabled = 1;
                $customer->password = Hash::make($this->faker->password);
                $customer->last_login = $timestamp;
                $customer->firstname = $customer->name;
                $customer->lastname = $this->faker->lastName;
                $customer->prefix = Countries::convert('prefix', ['code'=> substr($locale, 0, 2)]);
                $customer->country = Countries::convert('iso3', ['code'=> substr($locale, 0, 2)]);
                $customer->phone = $this->faker->phoneNumber;
                $customer->profile_image = $this->faker->imageUrl(640,480);
                $customer->date_of_birth = $this->faker->dateTimeThisCentury->format('Y-m-d');
                $customer->website = $this->faker->domainName;
                $customer->biography = $this->faker->realText();
                $customer->gender = $gender;
                $customer->locale = $locale;
                $customer->stripe_data = [
                    'customer_sid' => $samecustomer
                ];
                $customer->timezone = $this->faker->timezone;
                $customer->remember_token = $this->faker->sha256;
                $customer->created_at = $created;
                $customer->updated_at = $created;
                $customer->deleted_at = null;
                $customer->email_token = $this->faker->sha256;
                $customer->currency = 'eur';
                $customer->billing_address = $adres['line1'] . '; ' . $adres['city'] . ' - ' . $adres['state'] . ', ' . $adres['country'];
                $customer->save();

                $daysStay = (String) $this->faker->numberBetween(2, 14);
                $checkin = isset($checkout) ? 
                    $checkout->add($this->faker->numberBetween(1, 5) . ' days') : 
                    $dt->carbonize($this->faker->dateTimeBetween('now', '+2 months'));
                $checkout = $dt->carbonize($checkin)->add($daysStay . ' days');

                $reservation = new Reservation;
                $reservation->hotel_id = $hotel->id;
                $reservation->customer_id = $customer->id;
                $reservation->checkin_date = $checkin->toDateString();
                $reservation->checkout_date = $checkout->toDateString();
                $reservation->status = 1;
                $reservation->uuid = $this->faker->uuid;
                $reservation->guest_adult = $adults;
                $reservation->guest_child = $children;
                $reservation->comments = $this->faker->realText();
                $reservation->main_guest = $customer->firstname . ' ' . $customer->lastname;
                $reservation->email = $mail;
                $reservation->dob = $this->faker->dateTimeThisCentury->format('Y-m-d');
                $reservation->phone = $this->faker->phoneNumber;
                $reservation->reason_id = 9999999;
                $reservation->other_reason  = null;
                $reservation->price = $amount;
                $reservation->gender = substr($gender, 0, 1);
                $reservation->stripe_data = [
                    'customer_sid' => $samecustomer
                ];
                $reservation->created_at = $timestamp;
                $reservation->updated_at = $timestamp;
                $reservation->deleted_at = null;
                $reservation->save();

                $couponsNeededPerDay = ceil(($adults + $children) / 2);
                $perPersonPerDay = ($daysStay * ($$adults + $children));
                $price = $hotel->priceCents * $perPersonPerDay;
                $couponsNeeded = $couponsNeededPerDay * $daysStay;

                $num = rand(1, 15);
                Artisan::call('migoda:create:coupon', [
                    '--num' => $couponsNeeded + rand(1, 4),
                    '--pre' => 'IO',
                    '--suf' => 'MC',
                    '--name'=> 'osx', 
                    '--from'=> '2021-04-23',
                    '--to'  => '2021-06-01',
                    '--addTo'=> $customer->id
                ]);
                $num = rand(round($num/2), $num);
                $coupons = $customer->getCustomerCoupons();
                $couponsValid = count($coupons['valid']);

                // at reservation:
                for ($i = 0; $i < $couponsNeeded; $i++) {
                    $coupon = CouponCode::where('code', str_replace('-', '', $coupons['valid'][$i]))->get()->first();
                    if ($coupon) {
                        $reservation->addCouponCode($coupon);
                    }
                }

                $checkout = null;
                $customerReturns = 6 - $this->faker->biasedNumberBetween(1, 5, 'sqrt');
                $biasedStatus = 4 - $this->faker->biasedNumberBetween(0, 4, 'sqrt');
                $cvcindex = $this->faker->biasedNumberBetween(0, 2, 'sqrt');
                for ($i=0; $i < $customerReturns; $i++) { 


                    $this->faker = Faker\Factory::create($locale);

                    $pay = new Payments;
                    $pay->calcFees($amount, $this->option('c') ?? 'DE');

                    $pay->stripe_data = [
                        "account_sid" => 'acct_' . substr($this->faker->md5, 0, 16),
                        "intent_sid" => 'pi_' . substr($this->faker->md5, 0, 24),
                        "customer_sid" => $samecustomer,
                        "customer_id" => $customer->id
                    ];

                    $theid = substr($this->faker->md5, 0, 24);
                    $chargeid = substr($this->faker->md5, 0, 24);
                    $fixedaccid = '1Ht8oj2RBzhAR7oQ';
                    $orderid = $this->faker->randomNumber(7) . $this->faker->randomNumber(7);
                    $statuses = ['requires_confirmation', 'requires_action', 'requires_capture', 'processing', 'canceled'];
                    $cvcs = ['fail', 'unavailable', 'unchecked'];
                    $types = ['order.payment_succeeded', 'order.payment_failed', 'order.payment_succeeded'];

                    $pay->packet = [
                        "id" => 'pi_' . $theid,
                        "object" => 'payment_intent',
                        "type" => $types[$cvcindex],
                        "amount" => $amount,
                        "amount_capturable" => $pay->fees['hotel'],
                        "amount_received" => 0,
                        "application" => 'acct_' . $fixedaccid,         // $hotel->stripe_data['connected_sid'],
                        "application_fee_amount" => $pay->fees['migoda'],
                        "canceled_at" => null,
                        "cancellation_reason" => null,
                        "capture_method" => 'manual',
                        "charges" => [
                            "object" => 'list',
                            "data" => [

                                "id" => 'ch_' . $chargeid,
                                "object" => "charge",
                                "amount" => $amount,
                                "amount_captured" => $pay->fees['hotel'],
                                "amount_refunded" => 0,
                                "application" => 'acct_' . $fixedaccid,
                                "application_fee" => $pay->fees['migoda'],
                                "application_fee_amount" => $pay->fees['migoda'],
                                "balance_transaction" => 'txn_' . substr($this->faker->md5, 0, 24),
                                "billing_details" => [
                                    "address" => $adres,
                                    "email" => $customer->email,
                                    "name" => $customer->firstname . $customer->lastname,
                                    "phone" => $customer->phone
                                ],
                                "calculated_statement_descriptor" => $this->faker->realText(),
                                "captured" => true,                                                // !!!!!!!!
                                "created" => $timestamp,
                                "currency" => 'eur',
                                "customer" => $samecustomer,
                                "description" => 'Meal charges at '.$hotel->name.' for '.$reservation->main_guest,
                                "disputed" => false,
                                "failure_code" => null,
                                "failure_message" => null,
                                "fraud_details" => [],
                                "invoice" => null,
                                "livemode" => true,
                                "metadata" => [],
                                "on_behalf_of" => null,
                                "order" => null,
                                "outcome" => null,
                                "paid" => true,
                                "payment_intent" => 'pi_' . $theid,
                                "payment_method" => 'card_' . substr($this->faker->md5, 0, 24),
                                "payment_method_details" => [
                                    "card" => [
                                        "brand" => 'visa',
                                        "checks" => [
                                            "address_line1_check" => null,
                                            "address_postal_code_check" => null,
                                            "cvc_check" => (($biasedStatus === 1) ? $cvcs[$cvcindex] : 'pass')
                                        ],
                                        "country" => substr($locale, -2),
                                        "exp_month" => $this->faker->numberBetween(1, 12),
                                        "exp_year" => $this->faker->numberBetween(2021, 2026),
                                        "fingerprint" => substr($this->faker->md5, 0, 16),
                                        "funding" => 'credit',
                                        "installments" => null,
                                        "last4" => substr($this->faker->creditCardNumber, -4),
                                        "network" => 'visa',
                                        "three_d_secure" => null,
                                        "wallet" => null
                                    ],
                                    "type" => 'card'
                                ],
                                "receipt_email" => $customer->email,
                                "receipt_number" => $this->faker->swiftBicNumber,
                                "receipt_url" => 'https://pay.stripe.com/receipts/acct_'.$fixedaccid.'/ch_'.$chargeid.'/rcpt_'.substr($this->faker->md5, 0, 24),
                                "refunded" => false,
                                "refunds" => [
                                    "object" => 'list',
                                    "data" => [],
                                    "has_more" => false,
                                    "url" => '/v1/charges/ch_'.$chargeid.'/refunds'
                                ],
                                "review" => null,
                                "shipping" => null,
                                "source_transfer" => null,
                                "statement_descriptor" => null,
                                "statement_descriptor_suffix" => null,
                                "status" => $statuses[$biasedStatus],                                    // !!!!!!!!!
            // requires_payment_method, requires_confirmation, requires_action, processing, requires_capture, canceled, or succeeded
                                "transfer_data" => null,
                                "transfer_group" => null
                            ],
                            "has_more" => false,
                            "url" => '/v1/charges?payment_intent=pi_' . $theid
                        ],
                        "client_secret" => 'pi_' . $theid . '_secret_' . substr($this->faker->md5, 0, 24),
                        "confirmation_method" => 'automatic',
                        "created" => $timestamp,
                        "currency" => 'eur',
                        "customer" => $samecustomer,
                        "description" => 'Meal charges at '.$hotel->name.' for '.$reservation->main_guest,
                        "invoice" => null,
                        "last_payment_error" => null,
                        "livemode" => true,
                        "metadata" => [
                            'platform'          => 'web',        // mobile | tablet
                            'brand'             => 'safari',     // android | ios
                            'fees'              => $pay->fees,
                            'hotel_id'          => $hotel->id,
                            'customer_id'       => $customer->id,
                            'country_id'        => $hotel->country_id,
                            'reservation_id'    => $reservation->id,
                            'checkin'           => $checkin->toDateString(),
                            'reservation_uuid'  => $reservation->uuid,
                            'duration'          => $daysStay,
                            'adults'            => $adults,
                            'children'          => $children
                        ],
                        "next_action" => null,
                        "on_behalf_of" => null,
                        "payment_method" => null,
                        "payment_method_options" => [
                            "card" => [
                                "installments" => null,
                                "network" => null,
                                "request_three_d_secure" => 'automatic'
                            ]
                        ],
                        "payment_method_types" => [
                            'card'
                        ],
                        "receipt_email" => $customer->email,
                        "review" => null,
                        "setup_future_usage" => null,
                        "shipping" => null,
                        "statement_descriptor" => null,
                        "statement_descriptor_suffix" => null,
                        "status" => 'requires_payment_method',
                        "transfer_data" => null,
                        "transfer_group" => null
                    ];
                    $pay->uuid = $reservation->uuid;
                    $pay->hotel_id = $hotel->id;
                    $pay->customer_id = $customer->id;
                    $pay->country_id = $hotel->country_id;
                    $pay->reservation_id  = $reservation->id;
                    $pay->checkin  = $checkin->toDateString();
                    $pay->amount = (integer) $amount;
                    $pay->application_fee = $pay->fees['migoda'];
                    $pay->created_at = $timestamp;
                    $pay->currency = 'eur';
                    $pay->platform = $option_p ?? 'web';
                    $pay->proccess_status->transitionTo(PaymentProccessHold::class);

                        switch ($option_s) {
                            case 'authed':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                break;
                            case 'sub7':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub7::class);
                                break;
                            case 'sub2':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                break;
                            case 'fees':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub7::class);
                                $pay->proccess_status->transitionTo(PaymentProccessFees::class);
                                break;
                            case 'nofees':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub7::class);
                                $pay->proccess_status->transitionTo(PaymentProccessNoFees::class);
                                break;
                            case 'docharges':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                break;
                            case 'charged':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                $pay->proccess_status->transitionTo(PaymentProccessCharged::class);
                                break;
                            case 'paid':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                $pay->proccess_status->transitionTo(PaymentProccessCharged::class);
                                $pay->proccess_status->transitionTo(PaymentProccessPaid::class);
                                break;
                            case 'proced':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                $pay->proccess_status->transitionTo(PaymentProccessCharged::class);
                                $pay->proccess_status->transitionTo(PaymentProccessPaid::class);
                                $pay->proccess_status->transitionTo(PaymentProccessProccessed::class);
                                break;
                            case 'stated':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                $pay->proccess_status->transitionTo(PaymentProccessCharged::class);
                                $pay->proccess_status->transitionTo(PaymentProccessPaid::class);
                                $pay->proccess_status->transitionTo(PaymentProccessProccessed::class);
                                $pay->proccess_status->transitionTo(PaymentProccessStatitics::class);
                                break;
                            case 'arced':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                $pay->proccess_status->transitionTo(PaymentProccessCharged::class);
                                $pay->proccess_status->transitionTo(PaymentProccessPaid::class);
                                $pay->proccess_status->transitionTo(PaymentProccessProccessed::class);
                                $pay->proccess_status->transitionTo(PaymentProccessStatitics::class);
                                $pay->proccess_status->transitionTo(PaymentProccessArchived::class);
                                break;
                            case 'refund':
                                $pay->proccess_status->transitionTo(PaymentProccessAuthorized::class);
                                $pay->proccess_status->transitionTo(PaymentProccessSub2::class);
                                $pay->proccess_status->transitionTo(PaymentProccessDoCharges::class);
                                $pay->proccess_status->transitionTo(PaymentProccessCharged::class);
                                $pay->proccess_status->transitionTo(PaymentProccessPaid::class);
                                $pay->proccess_status->transitionTo(PaymentProccessRefunded::class);                            
                                break;
                        }
                    $pay->save();
                    $this->bar->advance();

                }
            }
        }
        $this->bar->finish();
        return 0;
    }
}
