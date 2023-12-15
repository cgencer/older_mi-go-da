<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command;
use DB, Config, Hash;
use App\Models\Reservoir, App\Models\Hotels, App\Models\WebHookCalls;

class event extends Command
{
                            // stripe help|by-event|by-date parameters mail
    protected $signature = 'stripper:event {cmd} {params} {--mailto}';
    protected $description = 'Stripe Events dumper';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
    }
}
