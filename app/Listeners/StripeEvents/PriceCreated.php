<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class PriceCreated implements ShouldQueue
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
  "type": "price.created",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "price_00000000000000",
	  "object": "price",
	  "active": true,
	  "billing_scheme": "per_unit",
	  "created": 1604574798,
	  "currency": "eur",
	  "livemode": false,
	  "lookup_key": null,
	  "metadata": {
	  },
	  "nickname": null,
	  "product": "prod_00000000000000",
	  "recurring": {
		"aggregate_usage": null,
		"interval": "month",
		"interval_count": 1,
		"usage_type": "licensed"
	  },
	  "tiers_mode": null,
	  "transform_quantity": null,
	  "type": "recurring",
	  "unit_amount": 2000,
	  "unit_amount_decimal": "2000"
	}
  }
}
*/
