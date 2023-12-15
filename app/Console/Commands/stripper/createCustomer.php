<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command;
use App\Models\Customers, App\Models\Hotels, App\Models\Countries, 
    App\Models\Payments, App\Models\Reservation, App\Models\Reservoir;
use Spatie\Translatable\HasTranslations;
use Carbon\Carbon, Config, Hash, DB;
use DiscordRoom, StripeChannel;

class createCustomer extends Command
{
    protected $signature = 'stripper:create:customer {q} {--conn=} {--email=} {--force}';
    protected $description = 'Create a customer account on Stripe for a specific user on customers-db';

    public function __construct()
    {
        parent::__construct();

        $this->stripeAPI = new StripeChannel;
//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
    }

    public function handle()
    {
        if($this->argument('q')){
            $args = explode('=', $this->argument('q'));
            if($args[0] === 'q'){
                $cid = (int) $args[1];
            }
            $c = Customers::find($cid);
            $cs = $this->stripeAPI->createCustomer($this->option('email'), $this->option('conn'));
            $c->customerSid = $cs;        // this also saves it...
            $this->warn('Customer with ID: [' . $cs . '] created.');
        }
        return 0;
    }
}
