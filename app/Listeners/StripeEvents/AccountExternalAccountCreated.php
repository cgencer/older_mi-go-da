<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class AccountExternalAccountCreated implements ShouldQueue
{
	public function __construct()
	{
	}

	public function handle(WebhookCall $wh)
	{
		StripeProccess::dispatch($wh);
		return 0;
	}
}

/*
{
  "created": 1326853478,
  "livemode": false,
  "id": "evt_00000000000000",
  "type": "account.external_account.created",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "ba_00000000000000",
	  "object": "bank_account",
	  "account": "acct_00000000000000",
	  "account_holder_name": "Jane Austen",
	  "account_holder_type": "individual",
	  "available_payout_methods": [
		"standard"
	  ],
	  "bank_name": "STRIPE TEST BANK",
	  "country": "US",
	  "currency": "eur",
	  "fingerprint": "1JWtPxqbdX5Gamtz",
	  "last4": "6789",
	  "metadata": {
	  },
	  "routing_number": "110000000",
	  "status": "new"
	}
  }
}
*/
