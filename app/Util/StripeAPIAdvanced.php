<?php
namespace App\Util;

use Stripe\Stripe;
use App\Models\CouponCode, App\Models\Customers, App\Models\Hotels, App\Models\Countries,
	App\Models\Payments, App\Models\Reservation, App\Models\Reservoir;
use Auth, Redirect, Config, Hash, App\Helpers;
use StripeChannel, DiscordRoom;

class StripeAPIAdvanced
{
/**************************************************************************************************************
/* As from: https://stripe.com/docs/connect/charges#direct-charges
/* 			https://stripe.com/docs/connect/direct-charges
/**************************************************************************************************************
/* Direct charges:
/* - You create a charge on your user’s account so the payment appears as a charge on the connected account,
/*   not in your account balance.
/* - The connected account’s balance increases with every charge.
/* - Your account balance increases with application fees from every charge.
/* - The connected account’s balance will be debited for the cost of Stripe fees, refunds, and chargebacks
/**************************************************************************************************************
/* Destination charges:
/* - You create a charge on your platform’s account so the payment appears as a charge on your account.
/*   Then, you determine whether some or all of those funds are transferred to the connected account.
/* - Your account balance will be debited for the cost of the Stripe fees, refunds, and chargebacks.
/**************************************************************************************************************
/* Separate charges and transfers:
/* - You create a charge on your platform’s account and also transfer funds to your user’s account.
/*   The payment appears as a charge on your account and there’s also a transfer to a connected account
/*   (amount determined by you), which is withdrawn from your account balance.
/* - You can transfer funds to multiple connected accounts.
/* - Your account balance will be debited for the cost of the Stripe fees, refunds, and chargebacks.
/**************************************************************************************************************
*/
	protected $client;
	protected $product;
	protected $customer;
	protected $user;
	protected $session;
	protected $for_real;
	protected $staticCustomer = 'cus_IwOmaV6rTWPsTs';
	protected $allPaymentMethods = ['alipay', 'au_becs_debit', 'bacs_debit', 'bancontact', 'card', 
	'card_present', 'eps', 'giropay', 'ideal', 'interac_present', 'p24', 'sepa_debit', 'sofort'];
	protected $hardOne = 'sk_test_51H3FdiCpynlDkhsMSNbLD863DYS7CAXCS9KKxeJMWJWdj8' .
							'jAZZBlQAm5f8i4Z5kFeLXNzsNWLSP6Tr2p8EaiGclt00TGGmxBag';

	public function __construct($forreal = false)
	{
        $this->for_real	= $forreal;
		$this->client = new \Stripe\StripeClient($this->hardOne);
	}

	public function endPoints()
	{
		$webhooks = [];
        $endPoints = $this->client->webhookEndpoints->all(['limit' => 299]);
        $endPointSet = $endPoints->data;
        foreach ($endPointSet as $set) {
            $parts = explode('.', $set->url);
            if(substr($parts[0], strpos($parts[0], '//') + 2) === 'beta2' && $set->status === 'enabled'){
                $webhooks = $set->enabled_events;
            }
        }
        return $webhooks;
	}

	public function productsExists($sid)
	{
		$products = $this->client->prices->all(['product' => $sid, 'active' => true]);
		return (count($products)>0) ? true : false;
	}

	public function deleteProduct($hotel)
	{
		$ret = $this->client->products->delete($hotel->stripeProductId, []);
		return $ret->deleted ?? false;
	}

	public function saveProduct($hotel)
	{
		$set = [
			'name' 				=> $hotel->name,
			'description' 		=> $hotel->name.' ('.$hotel->getCityName().', '.
				$hotel->getCountryName().') Accomodation services trough Migoda.com',
			'metadata' => Helpers::reformatMeta([
				'country_code' 	=> Countries::convert('iso3', ['id'=>$hotel->country_id]),
				'country_id' 	=> $hotel->country_id,
				'country_name' 	=> $hotel->getCountryName(),
				'city' 			=> $hotel->getCityName(),
				'hotel_id' 		=> $hotel->id,
				'sku'	 		=> $hotel->sku,
				'verified' 		=> $hotel->getIsVerified()
			]),
			'active' 			=> true,
			'unit_label'		=> 'nights',
			'images' 			=> array_slice($hotel->getGalleryImagesForStripe(), 0, 8)
		];
		$theProduct = isset($hotel->stripeProductId) ? 
			$this->client->products->update($hotel->stripeProductId, $set) :
			$this->client->products->create($set);
		return ($theProduct) ? $theProduct->id : null;
	}

	public function checkConnected($connId)
	{
		$cb = json_encode($this->client->accounts->retrieve($connId, []));
		dd($cb);
		if($cb){
			return array_filter(json_decode($cb, true), function($elm){
				return in_array($elm,[
					'capabilities', 'tos_acceptance', 'type', 'details_submitted', 'charges_enabled'
				]);
			}, ARRAY_FILTER_USE_KEY);
		}
	}

	public function createPrice($productId, $amount, $curr)
	{
		$price = [];
		if($curr && $amount && $productId){

			// forced deactivation the previous one as cant update the price trough update
			$prevPrices = $this->client->prices->all(['product' => $productId, 'active' => true]);
			foreach ($prevPrices['data'] as $price) {
				if($price['active'] && $price['unit_amount'] <> $amount){
					$this->client->prices->update($price['id'], ['active' => false]);
				}
			}
			$price = $this->client->prices->create([
				'active'		=> true,
				'product' 		=> $productId,
				'unit_amount' 	=> $amount * 100,
				'currency' 		=> strtolower($curr)
			]);
			return $price;
		}
	}

    public function calcFee($val, $migodaCommissionPerc=12.5, $curr)
    {
		// amountTotal 13300 amountStripe 200 amountHotel 11700 amountMigoda 1400
    	$multi = 100;

//OLD:	$comission = round((($val / 100) * 2.9) + 0.3, 2);
		$stripeCommissionPerc = Config::get('services.stripe.commission_rate');		// 1.5
		$stripeCommissionValue = ($val / $multi) * floatval($stripeCommissionPerc);
		$migodaCommissionValue = ($val / $multi) * floatval($migodaCommissionPerc);
    	return [
    		'stripe'	=> (int) $stripeCommissionValue,
    		'migoda'	=> (int) $migodaCommissionValue,
    		'hotel'		=> (int) $val - ($migodaCommissionValue + $stripeCommissionValue), 
    		'total'		=> (int) $val,
    		'multiplier'=> $multi,
    		'currency'	=> $curr
    	];
    }

	public function createCustomer($email, $connId)
	{
		$customer = $this->client->customers->create([
			'email' 			=> $email,
			'payment_method' 	=> 'pm_card_visa',
			'invoice_settings' 	=> [
				'default_payment_method' => 'pm_card_visa',
			],
        ], $connId ? ['stripe_account' => $connId] : null);
		return $customer->id;
	}

	public function updateCustomer($customerId, $adr, $name, $phone)
	{
		$customer = $this->client->customers->update($customerId, [
			'name' => $name,
			'phone' => $phone,
			'address' => $adr,
		]);
	}

	public function retrieveCustomer($cid)
	{
		return $this->client->customers->retrieve($cid, []);
	}

	public function listCustomers($limit=10, $email=null)
	{
		$cs = $this->client->customers->all( is_string($email) ? [
				'limit' => $limit,
				'email' => $email
			] : ['limit' => $limit]);
		if(is_array($cs->data) && count($cs->data)>0){

			foreach ($cs->data as $index => $cobj) {
				$cs->data[$index]['paymethods'] = $this->listPayMethods($cobj->id);
			}

			return $cs->data;
		}
		return null;
	}

	public function setupIntent($cid)
	{
		return $this->client->setupIntents->create([
			'customer' => $cid
		]);	
	}

	public function customerCards($cid)
	{
		return $this->client->customers->allSources($cid,
			['object' => 'card', 'limit' => 10]
		);
	}

	public function updateCard($cid, $card, $fields = [])
	{
		$allowed = ['address_city', 'address_country', 'address_line1', 'address_line2', 
		'address_state', 'address_zip', 'exp_month', 'exp_year', 'metadata', 'name'];
		$flag = true;

		if(is_array($fields)){
			foreach ($fields as $key => $value) {
				if(!in_array($key, $allowed)){
					$flag = false;
				}
			}
			if($flag){
				return $this->client->customers->updateSource($cid, $card, $fields);
			}
		}
	}

	public function listPayMethods($cid)
	{
		$pms = $this->client->paymentMethods->all([
			'customer' => $cid,
			'type' => 'card',
		]);
		if(is_array($pms->data) && count($pms->data)>0){
			return $pms->data;
		}else{
			// create a payment method
		}
		return null;
	}

	public function customersInvoices($cid, $status=null)
	{
		$allowed = ['draft', 'open', 'paid', 'uncollectible', 'void'];
		$opts = ['customer'=> $cid, 'limit' => 10];
		if(in_array($status, $allowed)){
			$opts = array_merge($opts, ['status' => $status]);
		}
		return $this->client->invoices->all($opts);
	}

	public function saveIntentForLater($customerId, $meta){
        return $this->client->setupIntents->create([
        	'confirm' 				=> false,
            'customer' 				=> $this->for_real ? $this->staticCustomer : $customerId,
            'usage' 				=> 'off_session',
            'payment_method_types' 	=> ['card'],
            'payment_method_options'=> ['card' => ['request_three_d_secure' => 'any']],
            'metadata' 				=> Helpers::reformatMeta($meta),
        ]);
	}

	public function intention($customerId, $meta, $payId){

		$pm = $this->client->paymentMethods->all([
			'customer' 				=> $customerId,
			'type' 					=> 'card',
		]);
		$item = ((count($pm->data)>1) ? end($pm->data) : $pm->data);

		if($item){
			return $this->client->paymentIntents->create([
				'amount' 				=> 1099,
				'currency' 				=> 'eur',
				'customer' 				=> $customerId,
				'payment_method' 		=> $item->id,
				'off_session' 			=> true,
				'confirm' 				=> true,
            	'metadata' 				=> Helpers::reformatMeta($meta),
			]);
		}
		return false;
	}

/*
	public function intention($connectedId, $methodId, $uuid, $amount, $appFee, $curr, $url='', $description='', $customer)
	{
		// confirm has to bee in attention() to postpone the payment thus return_url wont work either
		return $this->client->paymentIntents->create([
			'payment_method'		=> $methodId,
			'amount' 				=> $amount,
			'application_fee_amount'=> $appFee,
			'currency' 				=> $curr,
			'capture_method' 		=> 'manual',
			'payment_method_types' 	=> ['card'],
			'confirm'				=> false,
//			'return_url'			=> $url,
			'on_behalf_of'			=> ((!$this->for_real) ? Config::get('services.stripe.test_account') : $connectedId),
			'transfer_data' 		=> [
			'destination' 			=> ((!$this->for_real) ? Config::get('services.stripe.test_account') : $connectedId)],
			'description'			=> $description,
			'metadata'				=> ['uuid' => $uuid]
		]);
	}
*/

	public function cancellation($sid)
	{
        return $this->client->paymentIntents->cancel($sid, [
        	'cancellation_reason' => 'requested_by_customer']);
	}

	public function attention($id)
	{
		$ret = $this->client->paymentIntents->retrieve($id);
		$ret->confirm();
		return $ret;
//		return $this->client->paymentIntents->confirm($ret->id);
	}

	public function realization($id, $secret, $cap, $fees)
	{
        return $this->client->paymentIntents->capture($id, [
        	'amount_to_capture'			=> $cap,
        	'application_fee_amount'	=> $fees,
        ]);
	}

	public function checkoutSession($uuid, $customerId, $priceId, $perPersonPerDay, $info)
	{
        $this->user 	= \Illuminate\Support\Facades\Auth::guard('customer')->user();
		$this->session 	= \Stripe\Checkout\Session::create([
			'mode' 					=> 'payment',
			'locale' 				=> Countries::convert('code', ['iso3'=>$this->user->country]),
			'success_url'           => config('app.url') . Config::get('services.stripe.url.pay_complete') .
										'/{CHECKOUT_SESSION_ID}/' . $uuid,
			'cancel_url'            => config('app.url') . Config::get('services.stripe.url.pay_cancel') .
										'/{CHECKOUT_SESSION_ID}/' . $uuid,
			'customer'              => $customerId,
			'payment_method_types'  => ['card'],
			'metadata' 				=> Helpers::reformatMeta(['info' => $info]),
			'line_items' 			=> [
				[
					'price' 	=> $priceId,
					'quantity' 	=> $perPersonPerDay,
				],
			],
		]);
		return $this->session->id;
	}

	public function createBillingPortal($customerId)
	{
		$session = $this->client->billingPortal->sessions->create([
			'customer' => $customerId,
			'return_url' => env('APP_URL') . Config::get('services.stripe.url.customer_portal_entered')
		]);
		return Redirect::to($session->url);
	}

	public function createHotelAccount($country, $email)
	{
		if(!$this->for_real){
			return ['acc' => Config::get('services.stripe.test_account'), 'link' => '', 'reality_check' => $this->for_real];
		}

		$user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

		$account = $this->client->accounts->create([
			'type' 			=> 'express',
			'country' 		=> $country,
			'email' 		=> $email,
			'capabilities' 	=> [
				'card_payments' => ['requested' => true],
				'transfers' 	=> ['requested' => true],
			],
//			'collect' 		=> 'currently_due',		// =incremental onboarding
			'business_type' => 'company'
		]);

		$account_link = \Stripe\AccountLink::create([
			'account' 		=> $account->id,
			'refresh_url' 	=> 'http://migoda.dev/reauth',
			'return_url' 	=> 'http://migoda.dev/return',
			'type' 			=> 'account_onboarding',
		]);
/*{
  "object": "account_link",
  "created": 1601633140,
  "expires_at": 1601633440,
  "url": "https://connect.stripe.com/setup/s/VQAOU5C3BDQ7"
}*/
		return ['acc' => $account->id,'link' => $account_link->url];
	}

	public function payDay($amount, $curr, $meta, $desc, $statement)
	{
        $stripe->payouts->create([
            'amount' => $amount,
            'currency' => $curr,
            'metadata' => Helpers::reformatMeta($meta),
            'description' => $desc,
            'statement_descriptor' => $statement
        ]);
	}

	public function retrieveCountrySpecs($iso)
	{
		// default_currency
		// supported_bank_account_currencies
		// supported_payment_currencies
		// supported_payment_methods
		// supported_transfer_countries
		// verification_fields

		return $this->client->countrySpecs->retrieve($iso, []);
	}

	public function createTaxRate($session)
	{
		$this->client->taxRates->create([
			'display_name' => 'VAT',
			'description' => 'VAT Germany',
			'jurisdiction' => 'DE',
			'percentage' => 19,
			'inclusive' => false,
		]);
	}

	public function createRefund($session)
	{
		$this->client->refunds->create([
			'charge' => 'ch_1HL6eL2eZvKYlo2CxRG1oa8H',
		]);
		return $price;
	}
}
