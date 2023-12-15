<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\CouponCode, App\Models\Customers, App\Models\Hotels;
use App\Models\Countries, App\Models\Payments, App\Models\Reservation;
use Illuminate\Http\Request;
use Auth, Illuminate\Support\Facades\Redirect, Artisan, Config, Helpers;
use StripeChannel, DiscordRoom, niklasravnsborg\LaravelPdf\Facades\Pdf;
use App\Traits\DiscordTrait;
use App\Events\AlertMessages, App\Events\StripeGenerator;
use App\Notifications\IncomingBookingRequest;
use App\Notifications\RequestSent;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{

//*******************************************************************************************************************
//                                           -> ROUTE:/book              (ReservationController@book)              ->
//                                                                       VIEW: front.book
//*******************************************************************************************************************
// VIEW: book                                -> ROUTE:/f.bookAction      (ReservationController@bookAction)        ->
//                                                                       VIEW: front.book-complete
//*******************************************************************************************************************
// VIEW: waiting-confirmation//button:CHANGE -> ROUTE:/f.changeStatus    (ReservationController@changeReservation) ->
//                                                                       VIEW: waiting-confirmation
//*******************************************************************************************************************
// VIEW: waiting-confirmation//button:PAY    -> ROUTE:/payment   POST    (ReservationController@prepareForPayment) ->
// VIEW: payment//->STRIPE                   -> ROUTE:/payment-complete  (ReservationController@postPayment)       ->
//                                                                       VIEW: front.payment-complete
//*******************************************************************************************************************
// VIEW: front.auth.waiting-confirmation/LIST-> ROUTE:/reservation/{uuid} (ReservationController@getReservation)   ->
//                                                                       VIEW: front.reservation
//*******************************************************************************************************************

    protected $stripe, $discord, $disco;
    protected $user, $reservation, $hotel;
    use DiscordTrait;

    public function __construct()
    {
//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
        $this->stripe = new StripeChannel;
    }

    public function book(Request $request)
    {


        $auth = Auth::guard('customer')->user();
        $user = Customers::find($auth->id);

        $token = $request->get('_token', null);
        if ($token == null) {
            return Redirect::route('f.destinations');
        }

        $date_checkin = $request->get('date_checkin', null);
        $date_checkout = $request->get('date_checkout', null);

        $guests_adult = (int)$request->get('guests_adult', 0);
        $guests_child = (int)$request->get('guests_child', 0);

        $uuid = $request->get('hotel', null);

        if (
            null === $uuid ||
            null === $date_checkin ||
            null === $date_checkout ||
            ($guests_adult === 0 && $guests_child === 0)
        ) {
            return Redirect::route('f.destinations');
        }

        $date_checkin = \DateTime::createFromFormat('Y-m-d', $date_checkin);
        $date_checkout = \DateTime::createFromFormat('Y-m-d', $date_checkout);

        $interval = (int)$date_checkout->diff($date_checkin)->format('%a');

        if ($interval <= 0) {
            return Redirect::route('f.destinations');
        }

        $hotel = Hotels::where('uuid', $uuid)->get();
        if (!$hotel->count()) {
            return Redirect::route('f.destinations');
        }
        $hotel = $hotel->first();

        $coupons = $user->getCustomerCoupons();

        $couponsNeededPerDay = ceil(($guests_adult + $guests_child) / 2);
        $perPersonPerDay = ($interval * ($guests_adult + $guests_child));
        $price = $hotel->price * $perPersonPerDay;
        $coupons_needed = $couponsNeededPerDay * $interval;
        $coupons_valid = count($coupons['valid']);
        $date_tomorrow = new \DateTime('tomorrow');

        return view('front.book', compact('date_checkin', 'date_checkout', 'guests_adult', 'guests_child', 'hotel', 'coupons_needed', 'coupons_valid', 'price', 'date_tomorrow',));
    }

    public function bookAction(Request $request)
    {
        $auth = Auth::guard('customer')->user();
        $user = Customers::find($auth->id);


        $mainGuest = $request->main_guest;
        $email = $user->email;
        $dob = $request->year . '-' . $request->month . '-' . $request->day;
        $phone = $request->phone;
        $dateCheckin = $request->checkinDate;
        $dateCheckout = $request->checkoutDate;
        $gender = $request->gender;
        $guestAdult = (int)$request->guest_adult;
        $guestChild = (int)$request->guest_child;
        $uuid = $request->hotel;

        if (
            null === $uuid ||
            null === $dateCheckin ||
            null === $dateCheckout ||
            null === $mainGuest ||
            null === $email ||
            null === $dob ||
            null === $phone ||
            ($guestAdult === 0 && $guestChild === 0)
        ) {
            //return Redirect::route('f.destinations');
            return back()
                ->withErrors(['message'=> trans("txt.popup_coupon_empty")])
                ->withInput();
        }
        $dateCheckin = \DateTime::createFromFormat('Y-m-d', $dateCheckin);
        $dateCheckout = \DateTime::createFromFormat('Y-m-d', $dateCheckout);

        $interval = (int)$dateCheckout->diff($dateCheckin)->format('%a');

        if ($interval <= 0) {
            return Redirect::route('f.destinations');
        }

        $hotel = Hotels::where('uuid', $uuid)->get();
        if (!$hotel->count()) {
            return Redirect::route('f.destinations');
        }
        $hotel = $hotel->first();

        $checkReservation = Reservation::where('hotel_id', $hotel->id)
            ->where('customer_id', $user->id)
            ->where('checkin_date', $dateCheckin->format('Y-m-d'))
            ->where('checkout_date', $dateCheckout->format('Y-m-d'))->get();
        if ($checkReservation->count() > 0) {
            return Redirect::route('f.destinations');
        }

        $coupons = $user->getCustomerCoupons();
        $couponsValid = count($coupons['valid']);

        $couponsNeededPerDay = ceil(($guestAdult + $guestChild) / 2);
        $perPersonPerDay = ($interval * ($guestAdult + $guestChild));
        $price = $hotel->priceCents * $perPersonPerDay;
        $couponsNeeded = $couponsNeededPerDay * $interval;

        if ($couponsValid < $couponsNeeded) {
            return Redirect::route('f.destinations'); //To-Do Mevcut sayfaya kupon eksik uyarısı dönecek
        }

        $reservation = new Reservation();
        $reservation->customer_id = $user->id;
        $reservation->hotel_id = $hotel->id;
        $reservation->guest_adult = $guestAdult;
        $reservation->guest_child = $guestChild;
        $reservation->checkin_date = $dateCheckin->format('Y-m-d');
        $reservation->checkout_date = $dateCheckout->format('Y-m-d');
        $reservation->status = 0;
        $reservation->main_guest = $mainGuest;
        $reservation->email = $email;
        $reservation->phone = $phone;
        $reservation->gender = $gender;
        $reservation->dob = \DateTime::createFromFormat('Y-m-d', $dob)->format('Y-m-d');
        $reservation->price = $price;               // Helpers::localizedCurrency($price, false, false, false);
        $reservation->save();

        for ($i = 0; $i < $couponsNeeded; $i++) {
            $coupon = CouponCode::where('code', str_replace('-', '', $coupons['valid'][$i]))->get()->first();
            if ($coupon) {
                $reservation->addCouponCode($coupon);
            }
        }

        $user->date_of_birth = $dob;
        $user->prefix = $request->prefix;
        $user->phone = $request->phone;
        $user->save();

        /*  Send reservation mail */

        //Mixed data for 2 emails.

        $data = [
            'name' => $mainGuest,
            'hotel_name' => $hotel->name,
            'checkin' => $dateCheckin->format('M d, Y'),
            'checkout' => $dateCheckout->format('M d, Y'),
            'checkin_customer' => $dateCheckin->format('d M Y'),
            'checkout_customer' => $dateCheckout->format('d M Y'),
            'day_named_date' => \Carbon\Carbon::now()->format('l, d M Y'),
            'person' =>  $guestAdult,
            'children' =>  $guestChild,
            'code' =>  $reservation->id,
            'price' => \App\Helpers::localizedCurrency($hotel->price),
            'price_total' => \App\Helpers::localizedCurrency($price),
            'route' => route('hotel_admin.reservations.show', $reservation->id),
            'route_customer' => route('auth.reservation-status'),
        ];

        Notification::send($hotel->hotel_user, new IncomingBookingRequest($data)); //To Hotel
        Notification::send($user, new RequestSent($data)); //To Customer

         /*  Send reservation mail */

        return view('front.book-complete', [
            'hotel' => $hotel,
            'date_checkin' => $dateCheckin,
            'date_checkout' => $dateCheckout,
            'guests_adult' => $guestAdult,
            'guests_child' => $guestChild,
            'coupons_valid' => $couponsValid,
            'coupons_needed' => $couponsNeeded,
            'price' => $price,
            'date_tomorrow' => new \DateTime('tomorrow'),
        ]);

    }

    public function getPayment($uuid)
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        $reservation = Reservation::where('uuid', $uuid)->where('customer_id', $user->id)->get();
        if ($reservation->count() == 0) {
            return Redirect::route('f.destinations');
        }
        $reservation = $reservation->first();
        return view('front.payment', compact('user', 'reservation'));
    }


    public function getReservationDetails($uuid)
    {
        $this->user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        $reservation = Reservation::where('uuid', $uuid)->where('customer_id', $this->user->id)->get();
        if ($reservation->count() === 0) return Redirect::route(self::CANCEL_ROUTE);

        $reservation = $reservation->first();

        if (!$reservation) return Redirect::route(self::CANCEL_ROUTE);
        if ($reservation->customer_id !== $this->user->id) return Redirect::route(self::CANCEL_ROUTE);

        $this->reservation = $reservation;
        $hotel = $reservation->hotel()->get();

        if ($hotel->count() == 0) return Redirect::route(self::CANCEL_ROUTE);
        $hotel = $hotel->first();
        $this->hotel = $hotel;
    }

    public function prepareForPayment(Request $request)
    {
        $this->getReservationDetails($request->uuid);

        $hotel = $this->hotel;
        $reservation = $this->reservation;
        $user = $this->user;
        $connAccountId = $hotel->hotel_user()->get()->first()->stripeAccountId;

        if ($hotel->stripe_data === null) {
            // call creation of hotel
            Artisan::call('stripper:create:products q=' . $hotel->id);
            $hotel = $reservation->hotel()->get();
        }
        $sd = $hotel->stripe_data;
        $priceId = $sd['price_sid'] ?? null;

        // retrieve the customer from stripe, if exists
        $customer = Auth::guard('customer')->user();
        $csid = $customer->customerSid;

//        $this->discordMsg('waiting your command...' . $csid);

        if(!is_null($csid) && is_string($csid) && substr($csid, 0, 4) === 'cus_'){

            $customerSid = $customer->customerSid;
        }else{
            // create an alert!!!
            event(new AlertMessages('Your account on Stripe Platform is being created.', $customer));
            // create a customer
            event(new StripeGenerator('customer', ['uid' => $user->id , 'email' => $user->email]));
        }

        $adrset = $customer->billing_address;
        $adrset = ($customer->billing_address) ? $customer->billing_address : ['name' => '', 'line1' => '', 'line2' => '', 'city' => '', 'postal_code' => '', 'state' => '', 'country' => ''];

        $guests_adult = $reservation->guest_adult;
        $guests_child = $reservation->guest_child;

        $dateCheckin = Carbon::createFromDate(substr($reservation->checkin_date, 0, 4),
            substr($reservation->checkin_date, 5, 2), substr($reservation->checkin_date, 8, 2));
        $dateCheckout = Carbon::createFromDate(substr($reservation->checkout_date, 0, 4),
            substr($reservation->checkout_date, 5, 2), substr($reservation->checkout_date, 8, 2));

        $interval = (int) ($dateCheckout->diffInDays($dateCheckin) - 1);
        if ($interval <= 0) {
            return Redirect::route('f.destinations');
        }
        $can_cancel_free = false;
        $can_cancel_nonfree = false;

        $hoursToCheckin = $reservation->remainingHoursFromNow;      //$dateCheckin->diffInHours($now);

        if ($hoursToCheckin > 0) {
            if ($hoursToCheckin > 48) {
                $can_cancel_free = true;
            } elseif ($hoursToCheckin > 24) {
                $can_cancel_nonfree = true;
            }
        }
        $coupons = $customer->getCustomerCoupons();

        $couponsNeededPerDay = ceil(($guests_adult + $guests_child) / 2);
        $perPersonPerDay = ($interval * ($guests_adult + $guests_child));
        $price = $hotel->priceCents * $perPersonPerDay;

        $currency = $customer->currency;
        $coupons_needed = $couponsNeededPerDay * $interval;
        $coupons_valid = count($coupons['valid']);

        $info = 'Accomodation reservation for ' . $guests_adult . ' (+ ' . $guests_child . ' children) guests at ' . $hotel->name . ' for ' . $interval . ' nights.';

        $reservation->saveStripeData([
            'customer_id'   => $customer->id,
            'customer_sid'  => $customerSid,
            'account_sid'   => $connAccountId,
            'hotel_id'      => $hotel->id,
            'checkin'       => $dateCheckin->format('Y-M-d'),
            'fees'          => Payments::calcFees($price, Countries::convert('code', ['id' => $hotel->country_id])),
            'country_id'    => $hotel->country_id,
            'country'       => Countries::convert('code', ['id' => $hotel->country_id]),
        ]);

        $dtIn = $dateCheckin->format('M d, Y');
        $dtOu = $dateCheckout->format('M d, Y');
        $checkin = $dateCheckin->timestamp;
        $stripper = $reservation->stripe_data;

        // check for 7+ days, if so, use SetupIntent
        // if <7 days, use checkbox to decide on SetupIntent or PaymentIntent

        $intent = $this->stripe->saveIntentForLater($customerSid, $reservation->stripe_data);
        $intentSecret = $intent->client_secret;
        $intentid = $intent->id;

        $apiKey = config('services.stripe.public');
        $price /= 100;
        return view('front.payment', compact('customer', 'reservation', 'stripper', 'hotel', 'connAccountId',
            'price', 'currency', 'adrset', 'dtIn', 'dtOu', 'checkin', 'intentid', 'intentSecret', 'apiKey'));
    }

    public function paymentOnHold(Request $request)                            // STEP-02: save as payments
    {
        $json_obj = json_decode($request->getContent());
        $uuid = '';
        if (isset($json_obj->payment_method_id)) {
        }
        $this->generateResponse($intent, $json_obj->uuid, [$json_obj->amount_hotel, $json_obj->amount_migoda]);
    }

    public function charge(Request $request)                            // STEP-02: save as payments
    {
        $json_obj = json_decode($request->getContent());
        $uuid = '';
        if (isset($json_obj->setup_intent_id)) {
        }
/*
            $paid = new Payments;
            $paid->customer_id = $json_obj->customer_id;
            $paid->reservation_id = $json_obj->reservation_id;
            $paid->country_id = $json_obj->country_id;
            $paid->hotel_id = $json_obj->hotel_id;
            $paid->amount = $json_obj->amount_total;
            $paid->application_fee = $json_obj->amount_migoda;
            $paid->currency = $json_obj->currency;

            $hotelCountry = Countries::convert('code', ['id' => $json_obj->country_id]);
            $paid->fees = Payments::calcFees($json_obj->amount_total, $hotelCountry, $json_obj->currency);
            $paid->checkin = Carbon::createFromTimestamp($json_obj->checkin)->format('Y-m-d');
            $paid->save();
            $paid->proccess_status->transitionTo(ProccessPreflight::class);

            $intent = $this->stripe->intention(                                            // STEP-03: >:intention
                $json_obj->connAccountId, $json_obj->payment_method_id, $json_obj->uuid,
                $json_obj->amount_hotel, $json_obj->amount_migoda, $json_obj->currency,
                '', '', $json_obj->customer_sid);

            $paid->saveStripeData([
                'uuid'          => $json_obj->uuid,
                'account_sid'   => $json_obj->connAccountId,
                'intent_sid'    => $intent->id,
                'customer_id'   => $json_obj->customer_id,
                'customer_sid'  => $json_obj->customer_sid,
                'clientsecret'  => $intent->client_secret,
            ]);

            // STEP-04: >generateResponse()
//            return redirect()->route('f.success', ['uuid' => $json_obj->uuid]);
        }
        if (isset($json_obj->payment_intent_id)) {

            $intent = $this->stripe->attention($json_obj->payment_intent_id);
            $uuid = $json_obj->uuid;
            $paid = Payments::where('reservation_id', $json_obj->reservation_id)->get()->first()->saveStripeData([
                'intent_sid' => $intent_id,
                'account_sid' => $json_obj->connected_id,
                'customer_sid' => $json_obj->customer_id
            ]);
            $paid->proccess_status->transitionTo(PaymentProccessAuthorized::class);

        }
*/
        $this->generateResponse($intent, $json_obj->uuid, [$json_obj->amount_hotel, $json_obj->amount_migoda]);
    }

    public function cancellable($uuid)
    {
        $pay = Payments::where('uuid', $uuid)->get()->first();
        $link = $pay->cancelLink;
        return ($link !== '') ? $link : false;
    }

    public function doCancel($uuid)
    {
        $pay = Payments::where('uuid', $uuid)->get()->first();
        $res = Reservation::where('uuid', $uuid)->get()->first();

        $ret = $this->stripe->cancellation($pay->packet['id']);

        if($ret){
            $pay->pack = $ret;
            $pay->intent_sid = $ret->id;    // it does the save

            $pay->proccess_status->transitionTo(PaymentProccessCancelled::class);

            return true;
        }else{
            return false;
        }

        // Burada admin reservations controller'a instance vererek iptal işlemini o kısımdan tetikliyorum.

    }

    public function generateResponse($intent, $uuid, $amounts)
    {
        if ($intent->status == 'requires_action' && $intent->next_action->type == 'use_stripe_sdk') {
            echo json_encode([
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret
            ]);


        } else if ($intent->status == 'requires_confirmation') {                            // STEP-05: provisioning

/*
            $this->discordMsg('php artisan tst:it ' . $intent->id . ' ' . $intent->client_secret . ' ' .
                $amounts[0] . ' ' . $amounts[1]);
*/
            echo json_encode([
                'payment_intent_client_secret' => $intent->client_secret,
                'return_url' => route('f.success', ['uuid' => $uuid]),
                'success' => true
            ]);


        } else if ($intent->status == 'succeeded') {
            echo json_encode([
                'success' => true
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Invalid PaymentIntent status: ' . $intent->status]);
        }
    }

    /*
            if ($type == 'payment_intent.amount_capturable_updated') {
                // To cancel a payment before capturing use .cancel() (https://stripe.com/docs/api/payment_intents/cancel)
                $intent = \Stripe\PaymentIntent::retrieve($object->id);
                $logger->info('❗ Charging the card for: ' . $intent->amount_capturable);
                $intent->capture();
            } else if ($type == 'payment_intent.succeeded') {
                // Fulfill any orders, e-mail receipts, etc
                // To cancel the payment after capture you will need to issue a Refund (https://stripe.com/docs/api/refunds)
                $logger->info('💰 Payment received! ');
            } else if ($type == 'payment_intent.payment_failed') {
                $logger->info('❌ Payment failed.');
            }
    */
    /*
            $validatedData = $request->validate([
                'reservation_uuid' => 'required|max:64',
                'country' => 'required|max:32',
                'city' => 'required|max:64',
                'state' => 'required|max:64',
                'title' => 'required|max:64',
                'street_line1' => 'required|max:96',
                'zip_code' => 'postal_code:NL,DE,FR,TR,GB',
                'billing_email' => 'required|max:96|email:rfc,dns'
            ]);

            $this->stripe->PaymentIntent::update(
                $request->intent_id, [
                    'receipt_email' => $request->billing_email,
                    'metadata' => $request->reservation_uuid,
                    'customer_id' => $request->customer_id,
                    'hotel_id' => $request->hotel_id,
                    'reservation_id' => $request->reservation_id,
                ]
            );
    */

    public function success(Request $request)
    {
        $segments = request()->segments();
        $uuid = end($segments);

        $customer = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        $reservation = Reservation::where('uuid', $uuid)->get();
        if ($reservation->count() == 0) {
            return Redirect::route('f.destinations');
        }
        $reservation = $reservation->first();
        $reservation->setStatus(Reservation::STATUS_PAID);

        $paid = Payments::where('reservation_id', $reservation->id)
            ->update(['proccess_status' => 'authed']);

        $portal = $this->stripe->createBillingPortal($customer->stripe_data['customer_sid']);
        $invoice_url = route('f.invoice', ['uuid' => $uuid]);

        return view('front.success', compact('customer', 'reservation', 'invoice_url', 'uuid', 'portal'));
    }

    public function postPayment(Request $request)
    {
        $name = $request->get('name', null);
        $country = $request->get('country', null);
        $uuid = $request->get('reservation', null);
        if (
            null === $uuid ||
            null === $country
        ) {
            return Redirect::back()->withErrors(['Lütfen tüm zorunlu alanları doldurunuz.']); //!TODO Dil değişkeni eklenecek
        }
        if ($reservation->count() == 0) {
            return Redirect::route('f.destinations');
        }
        $reservation = $reservation->first();

        if (!$this->makePayment()) {
            return Redirect::route('f.payment', ['uuid' => $reservation->uuid])->withErrors(['Payment failed!']); //!TODO Dil değişkeni eklenecek
        }

//        $mailHelper->sendPaymentSuccessEmail($payment); !TODO add payment mail

        return view('front.payment-complete');

    }

    public function generate_invoice(Request $request)
    {
        $segments = request()->segments();
        $uuid = end($segments);

        $customer = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        $reservation = Reservation::where('uuid', $uuid)->get();

        if ($reservation->count() == 0) {
            return Redirect::route('f.destinations');
        }
        $reservation = $reservation->first();
        $hotel = $reservation->hotel()->get();
        $hotel = $hotel->first();

        $interval = $reservation->getLength();
        $hoursToCheckin = $reservation->remainingHoursFromNow;
        $couponsNeededPerDay = ceil(($reservation->guest_adult + $reservation->guest_child) / 2);
        $perPersonPerDay = ($interval * ($reservation->guest_adult + $reservation->guest_child));
        $price = $hotel->price * $perPersonPerDay;
        $coupons_needed = $couponsNeededPerDay * $interval;

        $dateCheckin = Carbon::createFromDate(substr($reservation->checkin_date, 0, 4),
            substr($reservation->checkin_date, 5, 2), substr($reservation->checkin_date, 8, 2));
        $dateCheckout = Carbon::createFromDate(substr($reservation->checkout_date, 0, 4),
            substr($reservation->checkout_date, 5, 2), substr($reservation->checkout_date, 8, 2));

        $data = [
            'uuid' => 'test',
            'reservation' => $reservation,
            'hotel' => $hotel,
            'price' => $price,
            'dates' => $dateCheckin->format('M d') . ' - ' . $dateCheckout->format('M d, Y'),
            'interval' => $interval,
            'pppDay' => $perPersonPerDay
        ];
        //  public function loadView($view, $data = [], $mergeData = [], $config = [])
        $pdf = PDF::loadView('invoice.template', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('invoice.pdf');
    }

    public function customerPortal(Request $request)
    {
        $customer = Auth::guard('customer')->user();
    }

    public function returnFromCustomerPortal(Request $request)
    {
        return Redirect::route(self::CANCEL_ROUTE);
    }

    public function makePayment()
    {
        //!TODO: Make payment and log to payment log
        //!TODO: Process currency

        return true;
    }

    public function getReservation($uuid)
    {
        $customer = Auth::guard('customer')->user();
        $reservation = Reservation::where('uuid', $uuid)->where('customer_id', $customer->id)->get();
        if ($reservation->count() == 0) {
            return Redirect::route('f.destinations');
        }

        $reservation = $reservation->first();


        if (!$reservation) {
            return Redirect::route('f.destinations');
        }

        if ($reservation->status !== Reservation::STATUS_PAID) {
            return Redirect::route('f.destinations');
        }

        if ($reservation->customer_id !== $customer->id) {
            return Redirect::route('f.destinations');
        }

        $hotel = $reservation->hotel()->get();
        if ($hotel->count() == 0) {
            return Redirect::route('f.destinations');
        }
        $hotel = $hotel->first();

        /*
        $date_checkin = $reservation->checkin_date;
        $date_checkout = $reservation->checkout_date;
        $guests_adult = $reservation->guest_adult;
        $guests_child = $reservation->guest_child;

        $interval = (int)\DateTime::createFromFormat('Y-m-d', $date_checkout)->diff(\DateTime::createFromFormat('Y-m-d', $date_checkin))->format('%a');

        $can_cancel_free = false;
        $can_cancel_nonfree = false;
        $now = new \DateTime();

        $dateDifference = \DateTime::createFromFormat('Y-m-d', $date_checkin)->diff($now);
        $hours = $dateDifference->h;
        $hoursToCheckin = $hours + ($dateDifference->days * 24);

        if (\DateTime::createFromFormat('Y-m-d', $date_checkin) > $now) {
            if ($hoursToCheckin > 48) {
                $can_cancel_free = true;
            } elseif ($hoursToCheckin > 24) {
                $can_cancel_nonfree = true;
            }
        }
        */
        $interval = $reservation->getLength();
        $hoursToCheckin = $reservation->remainingHoursFromNow;
        $couponsNeededPerDay = ceil(($reservation->guest_adult + $reservation->guest_child) / 2);
        $perPersonPerDay = ($interval * ($reservation->guest_adult + $reservation->guest_child));
        $price = $hotel->price * $perPersonPerDay;
        $coupons_needed = $couponsNeededPerDay * $interval;

        return view('front.reservation', compact('reservation', 'hotel', 'coupons_needed', 'price'));
        //, 'can_cancel_free', 'can_cancel_nonfree' ));
    }

    public function changeReservation(Request $req)
    {
        $user = Auth::guard('customer')->user();
        $reservation = Reservation::where('uuid', $req->uuid)
                                  ->where('customer_id', $user->id)->get();
        if ($reservation) {
            $reservation = $reservation->first();
            $reservation->setStatus($req->status);
        }
        return Redirect::route('auth.hotel-confirmation');
    }
}
