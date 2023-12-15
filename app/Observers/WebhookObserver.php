<?php

namespace App\Observers;

use App\Models\StripeWebhook;
#use \Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Log;

class WebhookObserver
{
    /*
    retrieved   creating    created
    updating    updated     saving
    saved       deleting    deleted
    restoring   restored
    */
    public function creating(StripeWebhook $wh)
    {
        Log::info("========= Observer Creating ==========");
        $wh->event_type = $wh->payload->type;
        $wh->created_at = $wh->payload->created;
    }

    public function created(StripeWebhook $wh)
    {
        Log::info("========= Observer Created ==========");
        $wh->event_type = $wh->payload->type;
        $wh->created_at = $wh->payload->created;
    }

    public function saved(StripeWebhook $wh)
    {
        Log::info("========= Observer Saved ==========");
        $wh->event_type = $wh->payload->type;
        $wh->created_at = $wh->payload->created;
    }

    public function saving(StripeWebhook $wh)
    {
        Log::info("========= Observer Saving ==========");
        $wh->event_type = $wh->payload->type;
        $wh->created_at = $wh->payload->created;
    }

}