<?php

namespace App\Models\Stripe;

use StripeChannel, DiscordRoom, Artisan;

Trait StripeCustomer
{
	protected $stripe;
	protected $customer;
	protected $payMethods;
	protected $billing;
	protected $cards;
	protected $retrieved = false;
	protected $customerSid;

	public function findOrCreateCustomer($email)
	{
		$this->stripe = new StripeChannel;
		$lostAndFound = $this->stripe->listCustomers(1, $email);

		if(!is_array($lostAndFound) || count($lostAndFound)===0){
			Artisan::call('stripper:create:customer', 
				['q' => $customer->id,'--email' => $customer->email, '--conn' => null]);
			$ao = Artisan::output();
			if($ao != ''){
				$matches = [];
				preg_match_all('/\\[(cus_[a-zA-Z0-9]*)\\]/', $ao, $matches, 0);
				if(is_array($matches[1])){
					$customer_sid = $matches[1][0];
				}else if(is_string($matches[1])){
					$customer_sid = $matches[1];
				}
				return $customer_sid;
			}
		}
		return false;
	}


//
// Customer:
//
/*{
  "id": "cus_IapRPo4Q3xoXac",
  "object": "customer",
  "address": null,
  "balance": 0,
  "created": 1608278057,
  "currency": "eur",
  "default_source": null,
  "delinquent": false,
  "description": null,
  "discount": null,
  "email": null,
  "invoice_prefix": "4DB1F2E",
  "invoice_settings": {
	"custom_fields": null,
	"default_payment_method": null,
	"footer": null
  },
  "livemode": false,
  "metadata": {},
  "name": null,
  "next_invoice_sequence": 1,
  "phone": null,
  "preferred_locales": [],
  "shipping": null,
  "tax_exempt": "none"
}*/
//
// Cards:
//
/*{
  "object": "list",
  "url": "/v1/customers/cus_IbFg7wsvEUkgKk/sources",
  "has_more": false,
  "data": [
	{
	  "id": "card_1I03BHCpynlDkhsMaxjBt0eG",
	  "object": "card",
	  "address_city": null,
	  "address_country": null,
	  "address_line1": null,
	  "address_line1_check": null,
	  "address_line2": null,
	  "address_state": null,
	  "address_zip": null,
	  "address_zip_check": null,
	  "brand": "Visa",
	  "country": "US",
	  "customer": "cus_IbFg7wsvEUkgKk",
	  "cvc_check": "pass",
	  "dynamic_last4": null,
	  "exp_month": 8,
	  "exp_year": 2021,
	  "fingerprint": "k69JcdSgHRoa0s5e",
	  "funding": "credit",
	  "last4": "4242",
	  "metadata": {},
	  "name": null,
	  "tokenization_method": null
	},
	{...},
	{...}
  ]
}*/




/*

			$favCard = $payMethods[0]->id;
			foreach ($payMethods as $m) {
				$allCards[$m->id] = $m->card->last4;
				if($m->networks->preferred){
					$favCard = $m->id;
				}
			}
*/

}
