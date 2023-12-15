<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class PayoutCreated implements ShouldQueue
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
  "type": "payout.created",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "po_00000000000000",
	  "object": "payout",
	  "amount": 1100,
	  "arrival_date": 1604574858,
	  "automatic": true,
	  "balance_transaction": "txn_00000000000000",
	  "created": 1604574858,
	  "currency": "eur",
	  "description": "STRIPE PAYOUT",
	  "destination": "ba_1Hk6Q2CpynlDkhsMNH3wiVdy",
	  "failure_balance_transaction": null,
	  "failure_code": null,
	  "failure_message": null,
	  "livemode": false,
	  "metadata": {
	  },
	  "method": "standard",
	  "original_payout": null,
	  "reversed_by": null,
	  "source_type": "card",
	  "statement_descriptor": null,
	  "status": "in_transit",
	  "type": "bank_account"
	}
  }
}
*/
