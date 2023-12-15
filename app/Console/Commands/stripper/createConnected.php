<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command;
use App\Models\Customers, App\Models\Hotels, App\Models\Countries,
    App\Models\Payments, App\Models\Reservation, App\Models\Reservoir;
use Spatie\Translatable\HasTranslations;
use Hash, DB, Config, Carbon\Carbon;
use StripeChannel;

class createConnected extends Command
{
    protected $stripeAPI;
    protected $signature = 'stripper:create:connected {q=id} {--force} {--linkOnly}';
    protected $description = 'Create a connected account for a specific hotel';

    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
    }

    public function handle()
    {
        $cid = 0;
        if($this->argument('q')){
            $args = explode('=', $this->argument('q'));
            if($args[0] === 'q'){
                $cid = (int) $args[1];
            }
        }
        $h = Hotels::where('id', (int) $cid)->get()->first();
        $u = $h->hotel_user()->get()->first();
        $email = ($this->option('force')) ? 'obsesif@gmail.com' : $u->email;

        if (!$h->stripe_data || !array_key_exists('account_sid', $h->stripe_data)) {

            $specs = collect(json_decode(json_encode($this->stripeAPI->retrieveCountrySpecs($h->getCode())->verification_fields->company)));
            $t = '';
            $c = [];
            if ($h->hotel_user()->get()->first()->stripe_data === null) {
                $cc = $h->getCode();
                if ($cc != 'TR') {
                    $c = $this->stripeAPI->createHotelAccount($cc, $email);
                    $link = $c['link'];
                    $t = $c['reality_check'] ? 'newly' : 'old';
                    $u->stripe_data = [
                        'account_sid' => $c['acc'],
                        'signup_link' => $c['link']
                    ];
                    $u->save();
                }
                if($this->option('linkOnly')){
                    $this->warn($c['link']);
                    return 0;
                }else{
                    if (isset($c['acc'])) {
                        $this->warn('the ' . $t . ' created hotel account is ' . $c['acc']);
                    }
                    if (isset($c['link'])) {
                        $this->warn($c['link']);
                    }
                }
            }
            return 0;
        }
    }
}
