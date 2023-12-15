<?php

namespace App\Console\Commands\migoda\task;

use Illuminate\Console\Command;
use App\Models\Reservoir, App\Models\Hotels;
use App\Models\Countries, App\Models\RawData;
use App\Util\GoogleSheets, App\Util\GoogleDrive;
use Google\Auth, Revolution\Google\Sheets\Sheets, Google_Client, Google_Service_Sheets;
use Spatie\Translatable\HasTranslations;
use Carbon\Carbon, DB, Hash, Schema, App\Helpers;
use PhpOffice\PhpSpreadsheet\Spreadsheet, PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class sheetsBackup extends Command
{
    protected $signature = 'migoda:task:sheetsBackup';
    protected $description = 'Backups GoogleSheets regularly, weekly history';

    public function __construct()
    {
        if (DB::connection()->getDatabaseName()) {
            $check = Schema::hasTable('countries');
            if ($check) {
                $this->drive = new GoogleDrive();
                $this->sheets = new GoogleSheets('1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0');
                $this->allCountries = (array) Countries::select('name')->get()->pluck('name');
                $this->allCountries = array_filter(Helpers::array_flatten($this->allCountries), fn($v) => !is_null($v) && $v !== '');
            }
        }
        parent::__construct();
    }

    public function handle()
    {
        $sheet = [];
        $newExcel = new Spreadsheet();
        $tempFile = tempnam(sys_get_temp_dir(), 'worksheet');

        $stuff = $this->sheets->sheetsCountries();
        $worksheets = $stuff['gsheets'];
        $countries = $stuff['countries'];

        foreach ($worksheets as $sheetid => $country) {
            $this->warn($country);
            if (in_array($country, $this->allCountries)) {
                $sheet[$country] = $this->sheets->grabSheet($country, true, false)['sheet'];
                sleep(2);
            }
        }

        foreach ($worksheets as $sid => $country) {
            if (in_array($country, $this->allCountries)) {
                $ws = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($newExcel, $country);
                $ws->fromArray($sheet[$country], null, 'A1');
                $newExcel->addSheet($ws);
            }
        }

        // remove default worksheet at 0
        $sheetIndex = $newExcel->getIndex($newExcel->getSheetByName('Worksheet'));
        $newExcel->removeSheetByIndex($sheetIndex);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($newExcel);
        $writer->save($tempFile);

        $folders = $this->drive->findFolders('sheetBackups');
        foreach ($folders as $id => $name) {
            $ret = $this->drive->saveAsExcel($id, 'MigodaHotels_' . date("Y-m-d"), file_get_contents($tempFile));
        }
        $this->drive->truncateNDays(7);
        $this->warn('done...');
        return 0;
    }

}
//
