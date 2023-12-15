<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class ProductCreated implements ShouldQueue
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
  "type": "product.created",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "prod_00000000000000",
	  "object": "product",
	  "active": true,
	  "attributes": [
		"size",
		"gender"
	  ],
	  "created": 1604574629,
	  "description": "Comfortable gray cotton t-shirt",
	  "images": [
	  ],
	  "livemode": false,
	  "metadata": {
	  },
	  "name": "T-shirt",
	  "statement_descriptor": null,
	  "unit_label": null,
	  "updated": 1604574629
	}
  }
}
*/
