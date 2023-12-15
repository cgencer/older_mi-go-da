<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserUpdated;

class UserListener
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
    public function handle(UserUpdated $event)
    {
        $cust = Customers::whereJsonContains('stripe_data->customer_sid', $event->data['customer_sid'])->get()->first();
        if($cust){
Log::warn($cust);
            switch ($event->cmd) {
                case 'created':
                    $cust->enabled = 1;
                    $cust->customer_sid = $id;
                    $cust->save();
dd($cust);
                    break;
                case 'updated':
                    $cust->enabled = 1;
                    $cust->customer_sid = $id;
                    $cust->save();
dd($cust);
                    break;
                case 'deleted':
                    $cust->enabled = 0;
                    $cust->save();
dd($cust);
                
//                    event(new AlertMessages('Some of your data was deleted on the Stripe Platform', $cust));
                    break;
            }
        }

    }
}
