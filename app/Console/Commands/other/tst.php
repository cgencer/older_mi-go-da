<?php

namespace App\Console\Commands\other;

use Illuminate\Console\Command;
use Carbon\Carbon, Illuminate\Support\Facades\DB, Illuminate\Support\Facades\Hash, Illuminate\Support\Facades\Schema;
use App\Models\Reservoir, App\Models\Hotels, App\Models\Cities, App\Models\Payments;
use App\Models\Reservation, App\Models\Countries, App\Models\RawData;
use Spatie\Translatable\HasTranslations;
use Google\Auth, App\Util\GoogleDrive, App\Util\GoogleSheets;
use Revolution\Google\Sheets\Sheets, Google_Client, Google_Service_Sheets;
use PhpOffice\PhpSpreadsheet\Spreadsheet, PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Helpers, StripeChannel;
use App\Events\StripeGenerator;

class tst extends Command
{
    protected $signature = 'tst:it';        //{id} {oh} {ah} {am}';
    protected $description = 'Command description';
    protected $stripeAPI;

    public function __construct()
    {
        //$this->stripeAPI = new StripeChannel;
        if (DB::connection()->getDatabaseName()) {
            $check = Schema::hasTable('countries');
            if ($check) {
//                $this->drive = new GoogleDrive();
//                $this->sheets = new GoogleSheets('1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0');
//                $this->allCountries = (array) Countries::select('name')->get()->pluck('name');
//                $this->allCountries = array_filter(Helpers::array_flatten($this->allCountries), fn($v) => !is_null($v) && $v !== '');
//                $this->discord = new DiscordClient(['token' => 'NzczMDk1MDYyMTI5MjEzNDcy.X6EO4g.WC2gPo-DQAW8SN8yn8Nx37AKR4Y']);

            }
        }
        $this->stripeAPI = new StripeChannel;
        parent::__construct();
    }

    public function handle()
    {

        $this->stripeAPI->checkConnected('acct_1Ht8oj2RBzhAR7oQ');


        /*StripeGenerator::dispatch('product', [
            'data'  => [
                'hotelId' => 1,
                'country' => 'de'
            ]
        ]);*/

//        $this->warn(Hash::make('123'));
/*
        $i = $this->StripeAPIAdvanced->attention($this->argument('id'));
        var_dump($i->status);
        $j = $this->StripeAPIAdvanced->realization($i->id, $this->argument('oh'), $this->argument('ah'), $this->argument('am'));
        var_dump($j->status);
*/
        $this->warn('this is the way!..');
        return 0;
    }
}
