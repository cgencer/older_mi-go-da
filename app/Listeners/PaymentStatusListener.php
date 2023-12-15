<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\StatusSync;

class PaymentStatusListener implements ShouldQueue
{

    public $connection = 'database';
    public $queue = 'paymentStates';
    public $delay = 60;

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
    public function handle(StatusSync $pack)
    {
        if(isset($pack['uuid']) && isset($pack['status'])){
            $uuid = $pack['uuid'];
            $status = $pack['status'];

            // update status on reservation here
        }
    }
}
