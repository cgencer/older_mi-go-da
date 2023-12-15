<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CustomerCreated as CustomerCreatedEvent
use Artisan;

class CustomerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CustomerCreatedEvent $e)
    {
        $customer = $e->customer;
        app('log')->info('listener: '.$e->customer);
        Artisan::call('stripper:create:customer', 
            ['q' => $e->data['uid'], '--email' => $e->data['email'], '--conn' => null]);
        $customer->save();
    }
}
