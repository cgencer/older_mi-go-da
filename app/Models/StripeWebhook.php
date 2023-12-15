<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Spatie\WebhookClient\Models\WebhookCall;
//use App\Observers\WebhookObserver;
use Spatie\StripeWebhooks\ProcessStripeWebhookJob;

class StripeWebhook implements ProcessStripeWebhookJob
{
    protected $table = 'webhook_calls';

    protected $dispatchesEvents = [
/*
        'created'   => WebhookObserver::class,
        'creating'  => WebhookObserver::class,
        'saved'     => WebhookObserver::class,
        'saving'    => WebhookObserver::class,
*/
    ];
}
