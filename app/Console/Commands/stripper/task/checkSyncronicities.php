<?php

namespace App\Console\Commands\stripper\task;

use Illuminate\Console\Command;

class checkSyncronicities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripper:check:syncronicities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks regularly entries on DB and StripeApi for inconsistencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
