<?php
namespace App\Util;

use Stripe\Stripe;
use App\Models\CouponCode;
use App\Models\Customers;
use App\Models\Hotels;
use App\Models\Countries;
use App\Models\Payments;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StripeAPI
{
/**************************************************************************************************************
/*  Creates a simple one-time payment solution; doesnt solve refunds and divident transfers to participants.
/**************************************************************************************************************
*/
	const URL_PAYCOMPLETE 	= '/payment-complete';
	const URL_PAYCANCEL 	= '/cancel';
	const URL_CUSTPORTENT 	= '/customerPortalEntered';

	protected $client;
	protected $product;
	protected $customer;
	protected $session;

	public function __construct()
	{
        Stripe::setApiKey($this->app['config']['services.stripe.secret']);
		$this->client 	= new \Stripe\StripeClient($this->app['config']['services.stripe.secret']);
        $this->user 	= \Illuminate\Support\Facades\Auth::guard('customer')->user();
		return $this->client;
	}

	public function createProduct($gallery, $uuid, $hotel)
	{
		// StripeAPI only accepts 8 images on their product-images
		$trimmed_gallery = [];	
		for($i=0; $i<count($gallery); $i++){
			if($i<8)
				$trimmed_gallery[$i] = $gallery[$i];
		}
		$product = \Stripe\Product::create([
			'name' => $hotel->name,
			'active' => true,
			'description' 		=> $hotel->name.' ('.$hotel->getCityName().', '.$hotel->getCountryName().') Accomodation services trough Migoda.com',
			'images' 			=> $trimmed_gallery,
			'metadata' => [
				'country_id' 	=> Countries::select('iso3')->where('id', $hotel->country_id)->get()->first()->iso3,
				'country' 		=> $hotel->getCountryName(),
				'city' 			=> $hotel->getCityName(),
				'verified' 		=> $hotel->getIsVerified()
            ],
            'type' => 'service',
            'unit_label' => 'nights'
        ]);

		$hotel->stripe_data = [
			'product_sid' => $product->id
		];
		$hotel->save();

		return $product;
	}

	public function updateCustomer($adr, $name, $phone)
	{
		$customer = \Stripe\Customer::update($customerId, [
			'name' => $name,
			'phone' => $phone,
			'address' => $adr,
		]);
	}

	public function createPrice($productId, $amount)
	{
		$price = \Stripe\Price::create([
			'product' => $productId,
			'unit_amount' => $amount * 100,
			'currency' => 'eur'
		]);
		return $price;
	}

	public function createCustomer()
	{
		$customer = \Stripe\Customer::create([
			'email' => $this->user->email,
			'payment_method' => 'pm_card_visa',
			'invoice_settings' => [
				'default_payment_method' => 'pm_card_visa',
			],
        ]);
		if($customer){
			$this->user->stripe_data = ['customer_sid' => $customer->id];
			$this->user->save();
		}
		return $customer;
	}

	public function chekoutSession($uuid, $customerId, $priceId, $perPersonPerDay, $info)
	{
        $this->user 	= \Illuminate\Support\Facades\Auth::guard('customer')->user();
		$this->session = \Stripe\Checkout\Session::create([
			'mode' => 'payment',
			'locale' => strtolower(Countries::select('code')->where('iso3', $this->user->country)->get()->first()->code),
			'success_url'           => config('services.stripe.url.pay_complete') . '/{CHECKOUT_SESSION_ID}/' . $uuid,
			'cancel_url'            => config('services.stripe.url.pay_cancel')   . '/{CHECKOUT_SESSION_ID}/' . $uuid,
			'customer'              => $customerId,
			'payment_method_types'  => ['card'],
			'metadata' 				=> ['info' => $info],
			'line_items' 			=> [[
				'price' 	=> $priceId,
				'quantity' 	=> $perPersonPerDay,
			]],
		]);
		return $this->session;
	}

	public function createBillingPortal($customerId, $uuid)
	{
		$session = \Stripe\BillingPortal\Session::create([
			'customer' => $customerId,
			'return_url' => config('services.stripe.url.customer_portal')
		]);
		return Redirect::to($session->url);
	}
}
