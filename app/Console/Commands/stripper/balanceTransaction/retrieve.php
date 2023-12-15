<?php

namespace App\Console\Commands\stripper\balanceTransaction;

use Illuminate\Console\Command;
use Stripe\BalanceTransaction;
use StripeChannel;

class Retrieve extends Command
{
    protected $signature = 'stripper:balance:trans:retrieve {id}';
    protected $description = 'Retrieve a balance transaction';

    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
    }

    public function handle()
    {
        try {
            $call = BalanceTransaction::retrieve($this->argument('id'));
            $headers = ['ID', 'Amount', 'Available on', 'Created', 'Currency', 'Description', 'Exchange rate', 'Fee', 'Net', 'Status', 'Type'];
            $data = [
                collect($call->toArray())
                    ->only(['id', 'amount', 'available_on', 'created', 'currency', 'description', 'exchange_rate', 'fee', 'net', 'status', 'type'])
                    ->toArray(),
            ];

            $this->table($headers, $data);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}