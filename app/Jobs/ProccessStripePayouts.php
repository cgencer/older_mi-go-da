<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Payments;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProccessStripePayouts implements SelfHandling, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pay;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payments $pay)
    {
        $this->pay = $pay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    //  from any controller:
    //  $this->dispatch(new ProcessPhoto($payment));

    public function handle()
    {

  //          $intent = $this->stripeAPI->attention($this->pay->stripe_data['intent_sid']);
  //          $intent->confirm();
    //        $toPay->proccessed = true;
//            $toPay->save();
    }
}
