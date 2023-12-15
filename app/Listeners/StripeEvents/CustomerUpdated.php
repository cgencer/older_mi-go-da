<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class CustomerUpdated implements ShouldQueue
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
  "type": "customer.updated",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "cus_00000000000000",
	  "object": "customer",
	  "address": null,
	  "balance": 0,
	  "created": 1604575051,
	  "currency": "eur",
	  "default_source": null,
	  "delinquent": false,
	  "description": null,
	  "discount": null,
	  "email": null,
	  "invoice_prefix": "5DE1F3D",
	  "invoice_settings": {
		"custom_fields": null,
		"default_payment_method": null,
		"footer": null
	  },
	  "livemode": false,
	  "metadata": {
	  },
	  "name": null,
	  "next_invoice_sequence": 1,
	  "phone": null,
	  "preferred_locales": [
	  ],
	  "shipping": null,
	  "tax_exempt": "none"
	},
	"previous_attributes": {
	  "description": "Old description"
	}
  }
}
*/
