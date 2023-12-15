<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue, Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue, Illuminate\Queue\SerializesModels;
use StripeChannel, DiscordRoom;
use DB;

class StripeDataFiller implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(string $table, int $id, string $tag='')
    {
//        $this->discord = new DiscordClient(['token' => 'NzczMDk1MDYyMTI5MjEzNDcy.X6EO4g.WC2gPo-DQAW8SN8yn8Nx37AKR4Y']);
//        $this->StripeApi = new StripeAPIAdvanced();

//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
        $this->stripeAPI = new StripeChannel;
        $this->table = $table;
        $this->id = $id;
        $this->tag = $tag;
    }

    public function handle()
    {
        $out = [];
        switch ($this->table) {
            case 'hotels':              // product_sid
                Artisan::call('stripper:create:products q='.$this->id.' --force');
                preg_match('/Product:\s+([a-zA-Z0-9]*)\s+:\s+([a-zA-Z0-9]*)\s+:Price/mi', Artisan::output()), $out);
                list(, $product_id, $price_id) = $out;
  /*
                $this->discordMessage('Hotel '.$this->id.' created as a Stripe-product with '.
                                       $product_id.' and its price as '.$price_id);
*/
                break;
            case 'customers':           // customers_sid
                break;
        }         
    }
}
