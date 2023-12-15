<?php

namespace App\Listeners\StripeEvents;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Jobs\StripeProccess;

class AccountUpdated implements ShouldQueue
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
  "type": "account.updated",
  "object": "event",
  "request": null,
  "pending_webhooks": 1,
  "api_version": "2020-08-27",
  "account": "acct_00000000000000",
  "data": {
	"object": {
	  "id": "acct_00000000000000",
	  "object": "account",
	  "business_profile": {
		"mcc": "7011",
		"name": "Migoda Services GmbH",
		"product_description": "Enduser purchases a food package from www.migoda.com at the hotel he/she prefers by the help of a coupon provided in retails. Food package purchase allows her/him to stay at the hotel without accomodation cost.",
		"support_address": null,
		"support_email": null,
		"support_phone": "+4940228200160",
		"support_url": null,
		"url": "www.migoda.com"
	  },
	  "business_type": "company",
	  "capabilities": {
		"card_payments": "active",
		"transfers": "active"
	  },
	  "charges_enabled": true,
	  "company": {
		"address": {
		  "city": "Hamburg",
		  "country": "DE",
		  "line1": "Neuer Wall 38",
		  "line2": null,
		  "postal_code": "20354",
		  "state": null
		},
		"directors_provided": true,
		"executives_provided": true,
		"name": "Migoda Services GmbH",
		"owners_provided": true,
		"phone": "+4940228200166",
		"tax_id_provided": true,
		"tax_id_registrar": "Homburg",
		"vat_id_provided": true,
		"verification": {
		  "document": {
			"back": null,
			"details": null,
			"details_code": null,
			"front": "file_1H3GkOCpynlDkhsMoVxBuJod"
		  }
		}
	  },
	  "country": "DE",
	  "created": 1594362198,
	  "default_currency": "eur",
	  "details_submitted": true,
	  "email": "test@stripe.com",
	  "external_accounts": {
		"object": "list",
		"data": [
		  {
			"id": "ba_00000000000000",
			"object": "bank_account",
			"account": "acct_00000000000000",
			"account_holder_name": null,
			"account_holder_type": null,
			"available_payout_methods": [
			  "standard"
			],
			"bank_name": "HAMBURGER SPARKASSE AG",
			"country": "DE",
			"currency": "eur",
			"default_for_currency": true,
			"fingerprint": "Uo5Rx15ZxhzXZa47",
			"last4": "4946",
			"metadata": {
			},
			"routing_number": "HASPDEHH",
			"status": "new"
		  }
		],
		"has_more": false,
		"url": "/v1/accounts/acct_1H3FdiCpynlDkhsM/external_accounts"
	  },
	  "metadata": {
	  },
	  "payouts_enabled": true,
	  "requirements": {
		"current_deadline": null,
		"currently_due": [
		],
		"disabled_reason": null,
		"errors": [
		],
		"eventually_due": [
		],
		"past_due": [
		],
		"pending_verification": [
		]
	  },
	  "settings": {
		"bacs_debit_payments": {
		},
		"branding": {
		  "icon": null,
		  "logo": null,
		  "primary_color": null,
		  "secondary_color": null
		},
		"card_payments": {
		  "decline_on": {
			"avs_failure": false,
			"cvc_failure": true
		  },
		  "statement_descriptor_prefix": null
		},
		"dashboard": {
		  "display_name": "Migoda",
		  "timezone": "Asia/Istanbul"
		},
		"payments": {
		  "statement_descriptor": "WWW.MIGODA.COM",
		  "statement_descriptor_kana": null,
		  "statement_descriptor_kanji": null
		},
		"payouts": {
		  "debit_negative_balances": true,
		  "schedule": {
			"delay_days": 7,
			"interval": "daily"
		  },
		  "statement_descriptor": null
		}
	  },
	  "tos_acceptance": {
		"date": 1594363789,
		"ip": "94.54.173.53",
		"user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0"
	  },
	  "type": "standard",
	  "statement_descriptor": "TEST"
	},
	"previous_attributes": {
	  "verification": {
		"fields_needed": [
		],
		"due_by": null
	  }
	}
  }
}
*/