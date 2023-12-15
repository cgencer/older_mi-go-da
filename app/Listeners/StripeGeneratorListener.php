<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Artisan, App\Events\StripeGenerator;

class StripeGeneratorListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StripeGenerator $e)
    {
        switch ($e->cmd) {
            case 'product':
                Artisan::call('stripper:create:products',
                    ['q' => $this->hotelId, 'country' => $this->country]);
                break;
            
            case 'customer':
                Artisan::call('stripper:create:customer', 
                    ['q' => $e->data['uid'], '--email' => $e->data['email'], '--conn' => null]);
                break;

            case 'account':
                Artisan::call('stripper:create:connected', 
                    ['id' => $this->hotelId, '--force' => '']);
                break;
        }
        return 0;
    }
}
