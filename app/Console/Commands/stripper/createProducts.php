<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command;
use App\Models\Customers, App\Models\Hotels, App\Models\Countries, 
	App\Models\Payments, App\Models\Reservation, App\Models\Reservoir;
use Spatie\Translatable\HasTranslations;
use Hash, DB, Config, Carbon\Carbon;
use DiscordRoom, StripeChannel;

class createProducts extends Command
{
	protected $signature = 'stripper:create:products {location?} {--q=} {--all} {--w}';            // specific hotel / country
	protected $description = 'Creates Stripe:product upon hotels';
	public function __construct()
	{
		parent::__construct();
        $this->stripeAPI = new StripeChannel;
//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
	}

	public function handle()
	{
		$hotel_id = 0;
		$country_id = 0;

		$this->overwrite = $this->option('w') ?? false;

		$hotel_id = $this->option('q') ?? null;
		if(!is_null($hotel_id)) {
			$this->saveHotel(Hotels::find($hotel_id));
		}else{
			if($this->argument('location')){
				$args = explode('=', $this->argument('location'));

				$cidList = [];
				if($args[1] === 'all' || $this->option('all')){
					$c = Config::get('services.google.sheets.sheet_countries');
					foreach ($c as $cn) {
						array_push($cidList, Countries::convert('id', ['name' => $cn]));
					}
				}else{
					$set = ($args[0] === 'iso' ? 'iso3' : ($args[0] === 'code' ? 'code' : ($args[0] === 'name' ? 'name' : null)));
					array_push($cidList, Countries::convert('id', [$set => $args[1]]));
				}
				$hotels = Hotels::whereIn('country_id', $cidList)->get();
				$this->warn('There will be '.$hotels->count().' products created.');
//			    $bar = $this->output->createProgressBar($hotels->count());
				foreach ($hotels as $hotel) {
					$this->saveHotel($hotel);
//		            $bar->advance();
				}
//		        $bar->finish();    
			}
		}
		return 0;
	}

	public function saveHotel(Hotels $hotel)
	{
		if($hotel){
			// force overwriting attributes
			if($this->overwrite){
				if($hotel->stripeProductId && !$hotel->stripePriceId) 		// only delete if there is no price attached on stripe 
					$this->stripeAPI->deleteProduct($hotel);
				$hotel->stripeProductId = null;
				$hotel->stripePriceId = null;
			}

			$product_id = (isset($hotel->stripeProductId)) ? $hotel->stripeProductId : $this->stripeAPI->saveProduct($hotel);
			if($product_id){
				$hotel->stripePriceId = $this->stripeAPI->createPrice($product_id, $hotel->price, $hotel->currency_code)->id;
				$hotel->stripeProductId = $product_id;
			}
			$this->warn('The new prodId for '.$hotel->name.' (@'.$hotel->id.') is ['.$product_id.'] and the priceId is ['.$hotel->stripePriceId.']');
			sleep(1);
		}
	}
}
