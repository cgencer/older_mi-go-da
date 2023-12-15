<?php

namespace App\Models\Stripe;

use StripeChannel, DiscordRoom, Artisan;

Trait StripeAccount
{
    protected $stripe;

	public function findOrCreateAccount($hotelId)
	{
		$this->stripe = new StripeChannel;

		Artisan::call('stripper:create:connected', 
			['id' => $hotelId, '--force' => '']);

		$ao = Artisan::output();
		if($ao != ''){
			$matches = [];
			preg_match_all('/\\[(acct_[a-zA-Z0-9]*)\\]/', $ao, $matches, 0);
			if(is_array($matches[1])){
				$matches[1][0];
			}else if(is_string($matches[1])){
				$account_sid = $matches[1];
			}
			return $account_sid;
		}else{
			return false;
		}
	}
}
