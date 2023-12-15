<?php

namespace App\Console\Commands\stripper\balance;

use Illuminate\Console\Command;
use Stripe\Balance;
use StripeChannel;

class Retrieve extends Command
{
    protected $signature = 'stripper:balance:retrieve';
    protected $description = 'Retrieve balance';

    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
//        $this->StripeApi = new StripeAPIAdvanced();
    }

    public function handle()
    {
        try {
            $call = Balance::retrieve();
            $available = collect($call->toArray()['available'])
                ->map(function ($item) {
                    $item['status'] = 'available';

                    return collect($item)->only(['amount', 'currency', 'status']);
                })
                ->toArray();
            $pending = collect($call->toArray()['pending'])
                ->map(function ($item) {
                    $item['status'] = 'pending';

                    return collect($item)->only(['amount', 'currency', 'status']);
                })
                ->toArray();
            $headers = ['Amount', 'Currency', 'Status'];
            $data = collect($available)->merge($pending)->toArray();

            $this->table($headers, $data);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}