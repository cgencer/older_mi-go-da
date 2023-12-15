<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\StripeWebhook, App\Observers\WebhookObserver, \Spatie\WebhookClient\Models\WebhookCall;
use App\Models\Hotels, App\Observers\HotelObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        StripeWebhook::observe(WebhookObserver::class);
//        Hotels::observe(HotelObserver::class);
    }
}
