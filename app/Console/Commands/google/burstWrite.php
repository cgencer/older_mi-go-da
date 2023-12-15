<?php

namespace App\Console\Commands\google;

use Illuminate\Console\Command;
use App\Models\Reservoir, App\Models\Hotels, App\Models\Cities;
use App\Models\Countries, App\Models\RawData;
use Google\Auth, App\Util\GoogleDrive, App\Util\GoogleSheets;
use Revolution\Google\Sheets\Sheets, Google_Client, Google_Service_Sheets;
use Carbon\Carbon, Schema, Config, DB;
use Spatie\Translatable\HasTranslations;
use GDrive, GSheets, App\Helpers;
use DiscordRoom, App\Traits\DiscordTrait;

class burstWrite extends Command
{
    use DiscordTrait;

    protected $signature = 'migoda:burstWrite {country?}';
    protected $description = 'Overwrites hotel database with GoogleSheet entries...';

    public function __construct()
    {
        parent::__construct();

        if (DB::connection()->getDatabaseName() && Schema::hasTable('countries')) {
            $this->drive = new GDrive;
//          $this->sheets = new GoogleSheets(config(self::SHEETID));
            $this->sheets = new GSheets;
            $this->allCountries = (array) Countries::select('name')->get()->pluck('name');
            $this->allCountries = array_filter(Helpers::array_flatten($this->allCountries), fn($v) => !is_null($v) && $v !== '');
//            $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
        }
    }

    public function handle()
    {
        $onlyOneCountry = $this->argument('country');

        $stuff = $this->sheets->sheetsCountries();
        $worksheets = $stuff['gsheets'];
        $country_codes = [];
        foreach ($worksheets as $id => $nam) {
            $cc = (string) Countries::convert('code', ['name' => $nam]);
            if ($cc !== '') {
                $country_codes[] = $cc;
            }
        }
        $langs = ['en', 'de', 'fr', 'tr', 'nl'];
        $total = 0;
        $toast = [];

        if ($onlyOneCountry && in_array($onlyOneCountry, array_values((array)$worksheets))) {
            $worksheets = [array_search($onlyOneCountry, (array)$worksheets) => $onlyOneCountry];
        }

        foreach ($worksheets as $id => $country) {
            $this->warn('....................' . $country);
            $sheet = $this->sheets->grabSheet($country, true, false)['sheet'];
            $r = 0;
            $aratotal = (count($sheet) - 1);
            foreach ($sheet as $row) {
                if ($r > 0) {
                    $row = array_pad($row, 26, '');
                    if (in_array(Countries::convert('code', ['name' => $country]), $country_codes)) {
                        $this->warn($row[2]);

                        $hotel = Hotels::where('contact_email', $row[12])->get()->first();
                        if ($hotel) {
                            $hotel->address = $row[8];
                            $hotel->city = html_entity_decode(strip_tags($row[10]));
                            $hotel->country_id = Countries::convert('id', ['name' => $country]);
                            $hotel->contact_email = $row[12];
                            $hotel->website = $row[13];
                            $i = 0;
                            $hotel->name = html_entity_decode(strip_tags( $row[3] ));
                            foreach ($langs as $lang) {
//                                $hotel->setTranslation('name', $lang, html_entity_decode(strip_tags($row[3])));
                                $hotel->setTranslation('description', $lang, html_entity_decode(strip_tags($row[22 + $i])));
                                $i++;
                            }
                            $hotel->zip = $row[9];
                            $hotel->setSkuAndPassword($row[2]);
                            $hotel->save();
                            $total++;
                        } else {
                            $this->warn($row[2].' not found.');
                            $aratotal--;
                        }
                    }
                }
                $r++;
            }
            $toast[] = [
                "name" => $country,
                "value" => "has " . (count($sheet) - 1) . " entries of which " . $aratotal . " are overwritten on database."
            ];
            sleep(3);
        }
        $toast[] = [
            "name" => $total,
            "value" => "GoogleSheet has a total of " . $total . " entries, all sync'ed with our database."
        ];
/*
        $this->discordMsg($toast, [
            'type'          => "Coupons", 
            'color'         => 'RED',
            'description'   => $total . " entries overwritten with burstWrite()",
            'title'         => "reporting from war-zone...",
        ]);
*/
        $this->warn('...................... total number of hotels updated: ' . $total);
        return 0;
    }
}
