<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command;
use App\Models\Reservoir, App\Models\Hotels, App\Models\Cities, App\Models\Countries, App\Models\RawData;
use Carbon\Carbon, DB, Hash, Config, Schema, App\Helpers;
use Spatie\Translatable\HasTranslations;
use Google\Auth, App\Util\GoogleDrive, App\Util\GoogleSheets;
use Revolution\Google\Sheets\Sheets, Google_Client, Google_Service_Sheets;
use PhpOffice\PhpSpreadsheet\Spreadsheet, PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class collectIds extends Command
{
	protected $signature = 'migoda:collectIds';
	protected $description = 'write IDS from database to GoogleSheets';

	public function __construct()
	{
        parent::__construct();
		if (DB::connection()->getDatabaseName()) {
			$check = Schema::hasTable('countries');
			if ($check) {
				$this->drive = new GoogleDrive();
				$this->sheets = new GoogleSheets('1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0');
				$this->allCountries = (array) Countries::select('name')->get()->pluck('name');
				$this->allCountries = array_filter(Helpers::array_flatten($this->allCountries), fn($v) => !is_null($v) && $v !== '');
			}
		}
	}

	public function handle()
	{
		$accents = "[Ğ|ğ|ş|Ş|Š|š|Ž|ž|À|Á|Â|Ã|Ä|Å|Æ|Ç|È|É|Ê|Ë|Ì|Í|Î|Ï|Ñ|Ò|Ó|Ô|Õ|Ö|Ø|Ù|Ú|Û".
		"|Ü|Ý|Þ|ß|à|á|â|ã|ä|ä|å|æ|ç|è|é|ê|ë|ì|í|î|ï|ð|ñ|ò|ó|ô|õ|ø|ù|ú|û|ý|þ|ÿ]";
		$stuff = $this->sheets->sheetsCountries();
		$worksheets = $stuff['gsheets'];
		$country_codes = [];
		foreach ($worksheets as $id => $nam) {
			$cc = (string) Countries::convert('code', ['name' => $nam]);
			if ($cc !== '')
				$country_codes[] = $cc;
		}
		$langs = ['en', 'de', 'fr', 'tr', 'nl'];
		$r = Reservoir::where('vkey', 'writeID.lastCountry')->get()->first();
		$donelist = ($r) ? json_decode($r->vval) : [];

//		if($donelist) array_pop($donelist);		// remove last item, to do it once again.
		$ws = [];
		foreach ($country_codes as $cc) {
			if( !in_array($cc, $donelist) ){
				$ws[] = [$id => Countries::convert('name', ['code' => $cc])];
			}
		}
		$ws = Helpers::array_flatten($ws);

		foreach ($ws as $id => $country) {

			$textual = [];
			$toast = [];
			$country_code 	= Countries::convert('code', ['name' => $country]);
			$country_id 	= Countries::convert('id', 	 ['name' => $country]);

			$this->warn('....................' . $country);

			$combo = $this->sheets->grabSheet($country, true, true);
			$sheet = $combo['sheet'];
			$pack  = $combo['set'];

			if(Reservoir::where('vkey', 'writeID.lastRow')->count()===0){
				Reservoir::updateOrCreate(['vkey'=>'writeID.lastRow'], ['vval'=>0]);
			}
			$t = Reservoir::where('vkey', 'writeID.lastRow')->get()->first();
			$rowno = ($t->vval >0) ? ((int) $t->vval)-1 : 1;

			$this->warn('starting at '.$rowno);
			array_splice($sheet, 0, $rowno);

			// filter out unfilled rows
			$sheet = array_filter($sheet, function($arr){return $arr[1]==='';});

			foreach ($sheet as $row) {

//				if($row[1] === ''){	// && !in_array($row[0], ['ID-OK', 'NOT-FOUND'])){

					$coords = str_pad((integer)$rowno, 3, '0', STR_PAD_LEFT) . ':00';

					if(in_array($country_code, $country_codes)) {

						$this->sheets->cellValue($pack, $coords.'0', 'ONHOLD', true);
						$this->sheets->cellNote($pack, $coords.'0', '', true);
						$this->sheets->cellNote($pack, $coords.'3', '', true);

						$hotels = Hotels::where('country_id', $country_id)
							->where('city', addslashes(html_entity_decode(strip_tags($row[10]))) )
							->whereRaw("REGEXP_REPLACE(name, '" . $accents . "', '%') like " .
								"concat('%', REGEXP_REPLACE('" . addslashes(html_entity_decode(strip_tags($row[3]))) .
								"', '" . $accents . "', '%'), '%')")->get();

						if ($hotels->count() > 1) {
if($row[1] === ''){
							$hh = [];
							foreach ($hotels as $h) {
								$hh[] = (String) $h->id;
							}
							$t = '>1 results. Please check these IDs on the database: ' . implode(', ', $hh);
							$this->warn($t);
							$textual[] = $t;
							$this->sheets->cellValue($pack, $coords.'0', 'ERROR', true);
							$this->sheets->cellNote($pack,  $coords.'0', $t, true);
}
						} else if($hotels->count() === 1) {

							$hotel = $hotels->first();

							$this->warn($hotel->id);
							$this->sheets->cellValue($pack, $coords.'0', 'ID-OK', true);
							$this->sheets->cellValue($pack, $coords.'1', (String) $hotel->id, true);
/*
							$this->sheets->cellLink($pack, $coords.'2',
								'=HYPERLINK("https://migoda.dev/admin/hotels/'.$hotel->id.'/edit", "'.html_entity_decode(strip_tags($row[2])).'")', true);
*/
						} else if($hotels->count() === 0){
if($row[1] === ''){
							$textual[] = 'Could not retrieve '.html_entity_decode(strip_tags($row[3])) .' on GoogleSheets.';
							$this->sheets->cellValue($pack, $coords.'0', 'NOT-FOUND', true);
							$this->sheets->cellNote($pack,  $coords.'0', 'Name mismatch.', true);
}
						}
					}
//				}

				$rowno++;
				Reservoir::updateOrCreate(['vkey'=>'writeID.lastRow'], ['vval'=>$rowno]);

				if(count($textual) > 10) {
					foreach ($textual as $val) {
						$toast[] = ['name' => '---', 'value' => $val];
					}
					$toast = [];
					$textual = [];
				}
				sleep(8);
			}
			if(count($textual)>0){				// remainers
				foreach ($textual as $val) {
					$toast[] = ['name' => '---', 'value' => $val];
				}
			}

			$textual = [];
			$toast = [];

			if(!in_array($country_code, $donelist)){
				$donelist[] = $country_code;
				Reservoir::updateOrCreate(['vkey'=>'writeID.lastCountry'], ['vval'=>json_encode($donelist)]);
			}
			Reservoir::updateOrCreate(['vkey'=>'writeID.lastRow'], ['vval'=>0]);
		}
		return 0;
	}
}
