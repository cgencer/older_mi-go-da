<?php

namespace App\Console\Commands\migoda\task;

use Illuminate\Console\Command;
use App\Models\Reservoir, App\Models\Hotels, App\Models\Cities, App\Models\Countries, App\Models\RawData;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use AshAllenDesign\LaravelExchangeRates\Classes\RequestBuilder;
use AshAllenDesign\LaravelExchangeRates\Exceptions\ExchangeRateException;
use AshAllenDesign\LaravelExchangeRates\Exceptions\InvalidCurrencyException;
use AshAllenDesign\LaravelExchangeRates\Exceptions\InvalidDateException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class currencies extends Command
{
    protected $signature = 'migoda:task:currencies';
    protected $description = 'Retrieves daily exchange rates';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $ex = new ExchangeRate();
        $all = $ex->currencies();
        foreach ($all as $key) {
            $this->warn($key);
            $c = Countries::where('currency', $key)->get()->first();
            if($c){
                $x = $ex->exchangeRate($key, 'EUR');
                $this->warn($key . ': ' . $x);
                $c->conversion_rate = $x;
                $c->save();
            }
//            $this->warn($key . ': ' . (int)($ex->exchangeRate($key, 'EUR')*100000));
        }
        return 0;
    }
}
