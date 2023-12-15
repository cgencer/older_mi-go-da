<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command;
use Artisan, StripeChannel;
use App\Models\User, App\Models\Hotels;

class checkConnected extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $stripeAPI;
    protected $signature = 'stripper:check:connected {q} {--short}';
    protected $description = 'Checks the validity of connected account on Stripe, returns info on these';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->stripeAPI = new StripeChannel;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ret = null;
        if($this->argument('q')){
            $args = explode('=', $this->argument('q'));
            if($args[0] === 'q'){
                $cid = $args[1];
            }
            if(is_string($cid) && substr($cid, 0, 5)==='acct_'){       // input is a stripe id
                $ret = $this->stripeAPI->checkConnected($cid);
            }else if(is_integer($cid)){           // input is a migoda id, so check user table first
                $u = User::where('id', $cid)->get()->first();
                if($u){
                    if($u['stripe_data']){
                        if(array_key_exists('account_sid', $u['stripe_data'])){
                            if(substr($u->stripe_data['account_sid'], 0, 5)==='acct_'){
                                $ret = $this->stripeAPI->checkConnected($cid);
                            }else{
                                Artisan::call('stripper:create:connected', ['q' => $cid]);
                                $callOut = preg_split('/\r\n|\r|\n/', Artisan::output());
                                $u = User::where('id', $cid)->get()->first();
                                $ret = $this->stripeAPI->checkConnected($u->stripe_data['account_sid']);
                            }
                        }
                    }
                }
            }else{
                $this->warn('You need to supply either Hotel userid or Stripe accountId');
            }
            if($ret){
                if($this->option('short')){
                    $this->warn(json_encode($ret));
                }else{
                    dd($ret);                    
                }
            }
            return 0;
        }
    }
}
