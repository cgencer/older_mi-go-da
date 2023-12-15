<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class OrderPaymentSucceeded implements ShouldQueue
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
  "type": "order.payment_succeeded",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "or_00000000000000",
	  "object": "order",
	  "amount": 1500,
	  "amount_returned": null,
	  "application": null,
	  "application_fee": null,
	  "charge": null,
	  "created": 1604574931,
	  "currency": "eur",
	  "customer": null,
	  "email": null,
	  "items": [
		{
		  "object": "order_item",
		  "amount": 1500,
		  "currency": "eur",
		  "description": "T-shirt",
		  "parent": "sk_1H4jkRCpynlDkhsMnFibFrC5",
		  "quantity": null,
		  "type": "sku"
		}
	  ],
	  "livemode": false,
	  "metadata": {
	  },
	  "returns": {
		"object": "list",
		"data": [
		],
		"has_more": false,
		"url": "/v1/order_returns?order=or_1Hk6RDCpynlDkhsMtsnCs6PP"
	  },
	  "selected_shipping_method": null,
	  "shipping": {
		"address": {
		  "city": "San Francisco",
		  "country": "US",
		  "line1": "1234 Fake Street",
		  "line2": null,
		  "postal_code": "94102",
		  "state": null
		},
		"carrier": null,
		"name": "Jenny Rosen",
		"phone": null,
		"tracking_number": null
	  },
	  "shipping_methods": null,
	  "status": "created",
	  "status_transitions": {
		"canceled": null,
		"fulfiled": null,
		"paid": null,
		"returned": null
	  },
	  "updated": 1604574931
	}
  }
}
*/
