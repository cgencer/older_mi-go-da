<?php

namespace App\Models\Stripe;

use StripeChannel, DiscordRoom, Artisan;

Trait StripeProduct
{
    protected $stripe;

	public function findOrCreateProduct($hotel)
	{
		$this->stripe = new StripeChannel;

		Artisan::call('stripper:create:products',
			['q' => $hotel->id, 'country' => $hotel->getCountryName()]);

		$ao = Artisan::output();
		if($ao != ''){
			$matches = [];
			preg_match_all('/\\[(prod_[a-zA-Z0-9]*)\\]/', $ao, $matches, 0);
			if(is_array($matches[1])){
				$customer_sid = $matches[1][0];
			}else if(is_string($matches[1])){
				$customer_sid = $matches[1];
			}
			return $customer_sid;
		}else{
			return false;
		}
	}
}
