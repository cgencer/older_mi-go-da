<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

    'google' => [
        'client_id' => '337719520689-1eummsv6f9nqbg4i9s8ant39mb0ea0b9.apps.googleusercontent.com',
        'client_secret' => 'FOQxab2B3-OB-HCFbPou6d4d',
        'redirect' => 'https://beta.migoda.com/oAuthed',
        'sheets' => [
            'sheet_id' => '1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0',
            'google_application_name' => 'Migoda-Sheets-Integration',
            'client_id' => '337719520689-1eummsv6f9nqbg4i9s8ant39mb0ea0b9.apps.googleusercontent.com',
            'sheet_id' => '1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0',
            'client_secret' => 'FOQxab2B3-OB-HCFbPou6d4d',
            'redirect' => 'https://beta.migoda.com/oAuthed',
            'developer_key' => 'AIzaSyDwchL_N_kSOYHR_-0iDBo1aOEp27RmNVI',
            'service_enabled' => true,
            'service_account_json_location' => 'storage/credentials-real.json',
            'service_account_mail' => 'datasync-for-migoda-com@all-migoda-hotels-sheets-sync.iam.gserviceaccount.com',
            'post_spreadsheet_id' => '1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0',
            'post_sheet_id' => 1,
            'langs' => ['en', 'de', 'fr', 'tr', 'nl'],
            'sync_status' => ['LIVE', 'ON-HOLD', 'NOT-ON-DB', 'REVIEW', 'NOT-FOUND', 'ERROR'],
            'sheet_countries' => [
                'Germany', 'Austria', 'Switzerland'
//                'Germany', 'Austria', 'Switzerland', 'Netherlands', 'Ireland', 'UK', 'Italy', 'Spain', 'France', 
//                'Belgium', 'Turkey', 'Andorra', 'Portugal', 'Czech Republic', 'Greece', 'Poland', 'Luxembourg', 
//                'Bosnia', 'Hungary', 'Slovakia', 'Bulgaria', 'Croatia', 'Cyprus', 'United Arab Emirates', 'India', 
//                'Mexico', 'Mauritius', 'Thailand', 'Sri Lanka', 'Cambodia', 'Costa Rica', 'Argentina', 'Brazil', 
//                'Malaysia', 'Ecuador', 'El Salvador', 'Guatemala', 'Honduras', 'Cuba', 'Venezuela', 'Indonesia'
            ],
        ] 
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'discord' => [
        'token' => 'NzczMDk1MDYyMTI5MjEzNDcy.X6EO4g.WC2gPo-DQAW8SN8yn8Nx37AKR4Y',
        'room' => 773095715252600842
    ],
    'migoda' => [
        'commission_rate' => 12.5,
        'vat' => 19,
    ],
    'stripe' => [
        'keys' => [
            'public' => 'pk_test_51H3FdiCpynlDkhsMXHkACfUmAPPJgzNpX1oM6JW3f3A2'.
                        'Y3xBgUtskmq7n32R6iYhszFp46xSNGT4fspyzVoWCoA000ldTG6t3O',
            'secret' => 'sk_test_51H3FdiCpynlDkhsMSNbLD863DYS7CAXCS9KKxeJMWJWdj'.
                        '8jAZZBlQAm5f8i4Z5kFeLXNzsNWLSP6Tr2p8EaiGclt00TGGmxBag',
            'webhook' => 'whsec_dhdwmkz65Mg0JCPUoUYC5IyMW89lZW6x'
/*            (App::environment() === 'beta_cem' ? 
                            'whsec_dhdwmkz65Mg0JCPUoUYC5IyMW89lZW6x' : 
                            'whsec_NeQJflo5Q4apGnb0fh4mnWIl0AzdPPOd')
*/        ],
        'commission_rate' => 1.25,
        'commission_fixd' => 0.25,
        'restrict' => true,
        'test_account' => 'acct_1Ht8oj2RBzhAR7oQ',
        'url' => [
            'pay_complete' => '/payment-complete',
            'pay_cancel' => '/cancel',
            'customer_portal' => '/return-from-customer-portal'
        ],
        'hooks' => [
            'account.updated',
            'setup_intent.setup_failed', 'setup_intent.succeeded',
            'setup_intent.requires_action', 'setup_intent.canceled', 'setup_intent.created',

//            'payment_intent.amount_capturable_updated', 'payment_intent.canceled',
//            'payment_intent.created', 'payment_intent.payment_failed',
//            'payment_intent.processing', 'payment_intent.requires_action', 'payment_intent.succeeded',

            'customer.created', 'customer.deleted', 'customer.updated',
//            'customer.source.created', 'customer.source.deleted',
//            'customer.source.expiring', 'customer.source.updated',

//            'charge.captured', 'charge.expired', 'charge.failed', 'charge.pending',
//            'charge.refunded', 'charge.succeeded', 'charge.updated',

            'price.deleted', 'price.updated', 'product.created',

            'application_fee.created', 'application_fee.refunded', 'application_fee.refund.updated',
            'billing_portal.configuration.created', 'billing_portal.configuration.updated',
//            'order.payment_succeeded', 'order.payment_failed',
            'payout.created', 'payout.failed', 'payout.canceled', 'payout.paid', 'payout.updated',
            'transfer.created', 'transfer.paid', 'transfer.reversed', 'transfer.updated'
        ]
    ],
];
