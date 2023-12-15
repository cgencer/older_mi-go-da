<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class PaymentIntentCreated implements ShouldQueue
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
  "type": "payment_intent.created",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "pi_00000000000000",
	  "object": "payment_intent",
	  "amount": 1000,
	  "amount_capturable": 0,
	  "amount_received": 0,
	  "application": null,
	  "application_fee_amount": null,
	  "canceled_at": null,
	  "cancellation_reason": null,
	  "capture_method": "automatic",
	  "charges": {
		"object": "list",
		"data": [
		],
		"has_more": false,
		"url": "/v1/charges?payment_intent=pi_1H7LKQCpynlDkhsMOfMQ35vU"
	  },
	  "client_secret": "pi_1H7LKQCpynlDkhsMOfMQ35vU_secret_o18ajbC10507yZuBNkpA3DojI",
	  "confirmation_method": "automatic",
	  "created": 1595337378,
	  "currency": "usd",
	  "customer": null,
	  "description": "Created by stripe.com/docs demo",
	  "invoice": null,
	  "last_payment_error": null,
	  "livemode": false,
	  "metadata": {
	  },
	  "next_action": null,
	  "on_behalf_of": null,
	  "payment_method": null,
	  "payment_method_options": {
		"card": {
		  "installments": null,
		  "network": null,
		  "request_three_d_secure": "automatic"
		}
	  },
	  "payment_method_types": [
		"card"
	  ],
	  "receipt_email": null,
	  "review": null,
	  "setup_future_usage": null,
	  "shipping": null,
	  "statement_descriptor": null,
	  "statement_descriptor_suffix": null,
	  "status": "requires_payment_method",
	  "transfer_data": null,
	  "transfer_group": null
	}
  }
}
*/
