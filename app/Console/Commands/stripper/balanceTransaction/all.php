<?php

namespace App\Console\Commands\stripper\balanceTransaction;

use Illuminate\Console\Command;
use Stripe\BalanceTransaction;
use StripeChannel;

class All extends Command
{
    protected $signature = 'stripper:balance:trans:all';
    protected $description = 'List all balance transactions';

    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
    }

    public function handle()
    {
        try {
            $call = BalanceTransaction::all();

            if ($call) {
                $headers = ['ID', 'Amount', 'Available on', 'Created', 'Currency', 'Description', 'Exchange rate', 'Fee', 'Net', 'Status', 'Type'];
                $data = collect($call->toArray()['data'])
                    ->map(function ($item, $key) {
                        return collect($item)
                            ->only(['id', 'amount', 'available_on', 'created', 'currency', 'description', 'exchange_rate', 'fee', 'net', 'status', 'type']);
                    })
                    ->toArray();

                $this->table($headers, $data);
            } else {
                $this->info('Not Available');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}