<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class TransferPaid implements ShouldQueue
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
  "type": "transfer.paid",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "tr_00000000000000",
	  "object": "transfer",
	  "amount": 1100,
	  "amount_reversed": 0,
	  "balance_transaction": "txn_00000000000000",
	  "created": 1604574577,
	  "currency": "eur",
	  "description": null,
	  "destination": "acct_1H3FdiCpynlDkhsM",
	  "destination_payment": "py_IKltaJT0Wij3Ii",
	  "livemode": false,
	  "metadata": {
	  },
	  "reversals": {
		"object": "list",
		"data": [
		],
		"has_more": false,
		"url": "/v1/transfers/tr_1Hk6LVCpynlDkhsMexNDwx83/reversals"
	  },
	  "reversed": false,
	  "source_transaction": null,
	  "source_type": "card",
	  "transfer_group": null
	}
  }
}
*/
		// you can access the payload of the webhook call with `$webhookCall->payload`
