<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class PaymentIntentSucceeded implements ShouldQueue
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
  "type": "payment_intent.succeeded",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "pi_00000000000000",
	  "object": "payment_intent",
	  "amount": 1099,
	  "amount_capturable": 0,
	  "amount_received": 1099,
	  "application": null,
	  "application_fee_amount": null,
	  "canceled_at": null,
	  "cancellation_reason": null,
	  "capture_method": "automatic",
	  "charges": {
		"object": "list",
		"data": [
		  {
			"id": "ch_00000000000000",
			"object": "charge",
			"amount": 1099,
			"amount_captured": 1099,
			"amount_refunded": 0,
			"application": null,
			"application_fee": null,
			"application_fee_amount": null,
			"balance_transaction": null,
			"billing_details": {
			  "address": {
				"city": null,
				"country": null,
				"line1": null,
				"line2": null,
				"postal_code": null,
				"state": null
			  },
			  "email": null,
			  "name": null,
			  "phone": null
			},
			"calculated_statement_descriptor": null,
			"captured": true,
			"created": 1556603164,
			"currency": "eur",
			"customer": null,
			"description": "My First Test Charge (created for API docs)",
			"disputed": false,
			"failure_code": null,
			"failure_message": null,
			"fraud_details": {
			},
			"invoice": null,
			"livemode": false,
			"metadata": {
			},
			"on_behalf_of": null,
			"order": null,
			"outcome": null,
			"paid": true,
			"payment_intent": "pi_00000000000000",
			"payment_method": "pm_00000000000000",
			"payment_method_details": {
			  "card": {
				"brand": "visa",
				"checks": {
				  "address_line1_check": null,
				  "address_postal_code_check": null,
				  "cvc_check": null
				},
				"country": "US",
				"exp_month": 8,
				"exp_year": 2020,
				"fingerprint": "9OyiQNfcCMaD1b7P",
				"funding": "credit",
				"installments": null,
				"last4": "4242",
				"network": "visa",
				"three_d_secure": null,
				"wallet": null
			  },
			  "type": "card"
			},
			"receipt_email": null,
			"receipt_number": "1290-2602",
			"receipt_url": "https://pay.stripe.com/receipts/acct_103f2E2Tb35ankTn/ch_1EUon22Tb35ankTnDCm1ZVV6/rcpt_EymLhZvasItpC61BqRKq1f6js8q2a6c",
			"refunded": false,
			"refunds": {
			  "object": "list",
			  "data": [
			  ],
			  "has_more": false,
			  "url": "/v1/charges/ch_1EUon22Tb35ankTnDCm1ZVV6/refunds"
			},
			"review": null,
			"shipping": null,
			"source_transfer": null,
			"statement_descriptor": null,
			"statement_descriptor_suffix": null,
			"status": "succeeded",
			"transfer_data": null,
			"transfer_group": null
		  }
		],
		"has_more": false,
		"url": "/v1/charges?payment_intent=pi_1EUon22Tb35ankTnu2YPQRcM"
	  },
	  "client_secret": "pi_1EUon22Tb35ankTnu2YPQRcM_secret_duH1nF5bRllBNaXCvAWwDulW1",
	  "confirmation_method": "automatic",
	  "created": 1556603164,
	  "currency": "eur",
	  "customer": null,
	  "description": null,
	  "invoice": null,
	  "last_payment_error": null,
	  "livemode": false,
	  "metadata": {
	  },
	  "next_action": null,
	  "on_behalf_of": null,
	  "payment_method": "pm_00000000000000",
	  "payment_method_options": {
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
	  "status": "succeeded",
	  "transfer_data": null,
	  "transfer_group": null
	}
  }
}
*/
