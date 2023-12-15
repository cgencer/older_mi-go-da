<?php

namespace App\Console\Commands\migoda\task;

use Illuminate\Console\Command, Carbon\Carbon;
use App\Models\Countries, App\Models\Hotels, App\Models\RawData, App\Models\Reservoir;
use App\Models\Revisions, App\Models\User;
use Spatie\Translatable\HasTranslations;
use App\Util\Compositor, App\Util\SideBySide;
use Config, Schema, Hash, DB, GDrive, GSheets;
use DiscordRoom, App\Traits\DiscordTrait;

class sheets2db extends Command
{
    use DiscordTrait;

    protected $signature = 'migoda:task:sheets2db {country_selection=}';
    protected $sheets;
    protected $countryName = '';
    protected $countryCode = '';
    protected $countryId = 0;
    protected $countriesNames = [];
    protected $countriesIds = [];
    protected $save;
    protected $colsToGrab = [3, 22, 23, 24, 25, 26];
    //  'Status','SKU','Hotel\'s Name','Stars','Rating','Source of Data','Responsible',
    //  'Address','Postal Code','City','County','E-mail','Website','Phone Number','Price',
    //  'New Price','Pictures','Account Status','Ready to Call','Last Edit Date', 'Active Languages',
    //  'EN - Description','DE - Description','FR - Description','TR - Description','NL - Description'
    protected $colNames = ['status', '', '', 'name', '', '', '', '',
        '', '', '', '', '', '', '', '',
        '', '', '', '', '', '',
        'description', 'description', 'description', 'description', 'description'];
    protected $lngs = ['en', 'de', 'fr', 'tr', 'nl'];
    protected $langs = ['en' => 'english', 'de' => 'german', 'fr' => 'french', 'tr' => 'turkish', 'nl' => 'dutch'];

    protected $description = 'Grab the GoogleSheet and extract the hotels for a country';

    // Migoda side:
    // 1. sheet is copied to RAW:SHEETS via this script, updating same entries, with NO CRC!!!
    // 2. sync sheets coords to RAW:HOTELS via sync script
    // 3. check RAW:SHEETS hashes against crc(content)
    // 4. all tainted entries get copied from RAW:SHEETS to DATABASE and then their hash corrected on RAW:SHEETS.

    // Hotels side:
    // 1. all DATABASE entries are copied to RAW:HOTELS via PanelToRaw
    // 2. sync sheets dbId's to RAW:SHEETS via sync script
    // 3. check RAW:HOTELS hashes against crc(content)      if editing occurs: hash value is tainted, at begin its null, again tainted
    // 4. all tainted entries get copied from RAW:SHEETS to GoogleSheet and marked, afterwards their hash corrected on RAW:HOTELS

    public function __construct()
    {
        if (DB::connection()->getDatabaseName() && Schema::hasTable('countries')) {
            $this->sheets = new GSheets;
        }
        parent::__construct();
    }

    public function handle()
    {
        $cargs = explode('=', $this->argument('country_selection'));
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

        $stuff = $this->sheets->sheetsCountries();
        $this->countriesNames = $stuff['countries'];
        $this->worksheets = $stuff['gsheets'];

        $this->countryCode = strtolower(Countries::select('code')->where('name', 'like', '%' . $this->countryName . '%')->get()->pluck('code')->first());

        $this->countryId = $cidList[0];

        foreach ($this->worksheets as $sheetid => $name) {
            $this->countriesIds[] = strtolower(Countries::select('code')->where('name', 'like', '%' . $name . '%')->get()->pluck('code')->first());
        }
        Reservoir::updateOrCreate(['vkey' => 'console.run.' . $this->countryCode], ['vval' => Carbon::now()]);

//        $this->panel2raw();
        $this->panel2rawNew();
        $this->sheet2raw();
        $this->sync();
//        $this->MarkandGo($this->checkCRC('HOTEL'));
        $this->SaveandGo($this->checkCRC('SHEET'));
        $this->remainingHotels();
    }

    public function sheet2raw()
    {
        $cellY = 0;

        $alerts = [];
        $coordsSet = [];
        $rowTitles = [];

        $this->warn('processing sheet entries...');

        $sheetSet = $this->sheets->grabSheet($this->countryName);
        if (!$sheetSet) {
            var_dump($this->countryName);
            dd('couldnt fetch the sheet, dude...');
        }
        $sheet = $sheetSet['sheet'];

        $bar = $this->output->createProgressBar(count($sheet));
        foreach ($sheet as $row) {
            // ensure the language codes are coming from the title columns
            if ($cellY === 0) {
                $cellX = 0;
                /*
                                $this->warn('processing title row...');

                                $rowTitles = $row;
                                foreach ($row as $cell) {
                                    if($cellX > 20 && substr( trim($cell), 0, -11 ) === 'Description'){
                                        $this->lngs[] = strtolower(trim(substr($cell, 0, 2)));
                                    }
                                    $cellX++;
                                }
                */
            } else {
                $cellX = 0;
//                $this->warn('processing row '.$cellY);
                foreach ($row as $cell) {
                    if (in_array($cellX, $this->colsToGrab)) {
                        if ($cell !== 'No' && $cell !== '') {

                            $coords = str_pad($cellY, 3, '0', STR_PAD_LEFT) . ':' . str_pad($cellX, 3, '0', STR_PAD_LEFT);
                            $coordsSet[] = $coords;

                            $oldData = RawData::where('modus', 'SHEET')
                                ->where('cellpos', $coords)
                                ->where('country', $this->countryCode)
//                                        ->where('dbId', $this->countryCode)
                                ->get()->first();
                            $raw = $oldData ? $oldData : new RawData;


                            // update the data only if the hashes do NOT match!

                            // if new entry: create a CRC from original sheetdata,
                            // else use the old data CRC to compare against changes
                            $hashed = (!$this->isValidCellpos($raw->cellpos)) ? crc32($cell) : crc32($raw->celldata);
                            // save it if its a new entry or checksum failed
                            if ($raw->dbId === null) {         // || ($raw->hash !== $hashed)) {
                                $raw->modus = 'SHEET';

                                $raw->hash = crc32($cell);
                                $raw->checksum_at = null;

                                $raw->cellpos = $coords;
                                $raw->celldata = html_entity_decode(strip_tags($cell));
                                $raw->lang = ($cellX === 3) ? 'en' : $this->lngs[$cellX - 22];
                                $raw->country = $this->countryCode;
                                $raw->dbId = is_numeric($row[1]) ? ((int)$row[1]) : null;
                                $raw->colname = $this->colNames[$cellX];
                            }
                            if ($raw->celldata !== $cell) {
                                $raw->celldata = html_entity_decode(strip_tags($cell));
                                $raw->dbId = is_numeric($row[1]) ? ((int)$row[1]) : null;
                                $raw->checksum_at = Carbon::now();
                            }
                            $raw->save();
                        }
                    }
                    $cellX++;
                }
            }
            $cellY++;
            $bar->advance();
        }
        $bar->finish();
        return 0;
    }

    public function panel2rawNew()
    {
        $hotels = Hotels::where('country_id', $this->countryId)->get();
        $this->bar = $this->output->createProgressBar(count($hotels));
        foreach ($hotels as $hotel) {
            $timestamp = Carbon::now();
            $hn = html_entity_decode(strip_tags($hotel->getTranslations()['name']['en']));
            $descs = $hotel->getTranslations()['description'];

            // check if the hotel is saved (trough its names checksum OR its ID)
            $oldData = RawData::where('modus', 'HOTEL')
                ->where('hash', html_entity_decode(strip_tags(crc32($hotel->getTranslations()['name']['en']))))
                ->orWhere('dbId', $hotel->id)
                ->get()->first();

            $raw = $oldData ?? new RawData;

            if (!$oldData) {

                $raw->modus = 'HOTEL';
                $raw->dbId = $hotel->id;
                $raw->celldata = $hn;
                $raw->lang = 'en';
                $raw->colname = 'name';
                $raw->country = strtolower($this->countryCode);
                $raw->hash = crc32(strtolower($hn));
                $raw->checksum_at = null;

            } else {

                if ($raw->celldata !== null && html_entity_decode(strip_tags($raw->celldata)) !== $hn) {
                    $raw->checksum_at = $timestamp;
                }
                $raw->celldata = $hn;
            }
            $raw->save();

            foreach ($this->lngs as $lang) {

                if (key_exists($lang, $descs)) {

                    $oldData = RawData::where('modus', 'HOTEL')
                        ->where('hash', crc32($descs[$lang]))
                        ->get()->first();
                    $raw = $oldData ? $oldData : new RawData;

                    if (!$oldData) {

                        $raw->modus = 'HOTEL';
                        $raw->dbId = $hotel->id;
                        $raw->celldata = html_entity_decode(strip_tags($descs[$lang]));
                        $raw->lang = $lang;
                        $raw->cellpos = null;
                        $raw->colname = 'description';
                        $raw->country = strtolower($this->countryCode);
                        $raw->hash = crc32($descs[$lang]);
                        $raw->checksum_at = null;

                    } else {

                        if ($oldData->celldata !== null &&
                            html_entity_decode(strip_tags($oldData->celldata)) !== html_entity_decode(strip_tags($descs[$lang]))) {
                            $raw->checksum_at = $timestamp;
                        }
                        $raw->celldata = html_entity_decode(strip_tags($descs[$lang]));

                    }
                    $raw->save();
                }
            }
        }
        $sheetSet = $this->sheets->grabSheet($this->countryName);
        if (!$sheetSet)
            dd('trouble with sheet ' . $this->countryName . '; couldnt fetch the sheet, dude...');
        else
            list('sheet' => $sheet, 'set' => $pack) = $sheetSet;

        $xdiff = new SideBySide();
        $xdiff->setAffixes(['~~', '~~', '__', '__']);

        $lastId = Reservoir::select('vval')->where('vkey', 'lastSyncedHotel')->get()->pluck('vval')->first();
        $revs = Revisions::where('revisionable_type', 'App\Models\Hotels')->where('id', '>', $lastId ?? 0)->get();
        foreach ($revs as $rev) {
            $od = (array)json_decode($rev->old_value);
            $nd = (array)json_decode($rev->new_value);
            $theHotel = Hotels::where('id', $rev->revisionable_id)->get()->first();
            if (isset($theHotel->sku)) {
                $theSku = $theHotel->sku;
                foreach ($od as $key => $val) {
                    if (array_key_exists($key, $od) && array_key_exists($key, $nd)) {
                        if (crc32(html_entity_decode(strip_tags($val))) != crc32(html_entity_decode(strip_tags($nd[$key])))) {

                            $theColumn = $this->colsToGrab[$this->indexOf($key, $this->lngs) + 1];
                            $rowNo = 0;
                            $theLine = 0;
                            foreach ($sheet as $rows) {
                                if ($rows[1] === $theSku) {
                                    $theLine = $rowNo++;
                                }
                            }
                            $thePos = str_pad($theLine, 3, '0', STR_PAD_LEFT) . ':' . str_pad($theColumn, 3, '0', STR_PAD_LEFT);

                            $uname = is_null($rev->user_id) ? 'someone' :
                                "User " . User::select('username')->where('id', $rev->user_id)->get()->pluck('username')[0];

                            $theDiff = [];
                            $theLines = [];
                            if ($val === '') {

                                $theLines[] = [
                                    'name' => "the old content was empty.",
                                    'value' => "..."
                                ];

                            } else if ($nd[$key] === '') {

                                $theLines[] = [
                                    'name' => "the content has been deleted.",
                                    'value' => "..."
                                ];

                            } else if ($val != '' && $nd[$key] != '') {
                                $theDiff = $xdiff->compute(html_entity_decode(strip_tags($val)), html_entity_decode(strip_tags($nd[$key])));

                                // combine old & new results into one...
                                preg_match_all('/~~[^~]*~~/', $theDiff[0], $matches, PREG_OFFSET_CAPTURE);
                                foreach ($matches as $arr) {
                                    foreach ($arr as $found) {
                                        $theDiff[1] = substr($theDiff[1], 0, $found[1]) . $found[0] . substr($theDiff[1], $found[1]);
                                    }
                                }
                                preg_match_all('/\.[.]*\s[^~*]*[~*]{2}[^~*]*[~*]{2}[^.]*\./', $theDiff[1], $matches, PREG_OFFSET_CAPTURE);
                                foreach ($matches as $arr) {
                                    foreach ($arr as $found) {
                                        $theLines[] = [
                                            'name' => "changes at " . $found[1],
                                            'value' => $found[0]
                                        ];
                                    }
                                }

                            }
                            /*
                                                    $this->discordMsg($theLines, [
                                                        'type'      => "Content Change from dashboard",
                                                        'title'     => $theHotel->name . " has been changed:",
                                                        'description' => $uname . " edited for " . $this->langs[$key],
                                                        'color'     => 'ORANGE',
                                                        'url'       => Config::get('services.app.url') . '/admin/hotels/'.$theHotel->id.'/edit',
                                                    ]);
                            */

                            $this->sheets->cellValue($pack, $thePos, html_entity_decode(strip_tags($nd[$key])), true);
                            $this->sheets->cellNote($pack, $thePos, html_entity_decode(strip_tags($od[$key])), true);

                        }
                    }
                }
                Reservoir::updateOrCreate(['vkey' => 'lastSyncedHotel'], ['vval' => $rev->id]);
            }
        }
        if ($this->sheets->cacheNotEmpty()) $this->sheets->forceUpdates();
    }

    public function indexOf($object, array $elementData)
    {
        $elementCount = count($elementData);
        for ($i = 0; $i < $elementCount; $i++) {
            if ($object == $elementData[$i]) {
                return $i;
            }
        }
        return -1;
    }

    public function panel2raw()
    {
        $hotels = Hotels::where('country_id', $this->countryId)->get();
        $this->bar = $this->output->createProgressBar(count($hotels));
        foreach ($hotels as $hotel) {

            $timestamp = Carbon::now();
            $hn = html_entity_decode(strip_tags($hotel->getTranslations()['name']['en']));
            $descs = $hotel->getTranslations()['description'];

            // check if the hotel is saved (trough its names checksum OR its ID)
            $oldData = RawData::where('modus', 'HOTEL')
                ->where('hash', html_entity_decode(strip_tags(crc32($hotel->getTranslations()['name']['en']))))
                ->orWhere('dbId', $hotel->id)
                ->get()->first();

            $raw = $oldData ? $oldData : new RawData;

            if (!$oldData) {

                $raw->modus = 'HOTEL';
                $raw->dbId = $hotel->id;
                $raw->celldata = $hn;
                $raw->lang = 'en';
                $raw->colname = 'name';
                $raw->country = strtolower($this->countryCode);
                $raw->hash = crc32(strtolower($hn));
                $raw->checksum_at = null;

            } else {

                if ($raw->celldata !== null && html_entity_decode(strip_tags($raw->celldata)) !== $hn) {
                    $raw->checksum_at = $timestamp;
                }
                $raw->celldata = $hn;
            }
            $raw->save();

            foreach ($this->lngs as $lang) {

                if (key_exists($lang, $descs)) {

                    $oldData = RawData::where('modus', 'HOTEL')
                        ->where('hash', crc32($descs[$lang]))
                        ->get()->first();
                    $raw = $oldData ? $oldData : new RawData;

                    if (!$oldData) {

                        $raw->modus = 'HOTEL';
                        $raw->dbId = $hotel->id;
                        $raw->celldata = html_entity_decode(strip_tags($descs[$lang]));
                        $raw->lang = $lang;
                        $raw->cellpos = null;
                        $raw->colname = 'description';
                        $raw->country = strtolower($this->countryCode);
                        $raw->hash = crc32($descs[$lang]);
                        $raw->checksum_at = null;

                    } else {

                        if ($oldData->celldata !== null &&
                            html_entity_decode(strip_tags($oldData->celldata)) !== html_entity_decode(strip_tags($descs[$lang]))) {
                            $raw->checksum_at = $timestamp;
                        }
                        $raw->celldata = html_entity_decode(strip_tags($descs[$lang]));

                    }
                    $raw->save();
                }
            }
            $this->bar->advance();
        }
        $this->bar->finish();
        return 0;
    }

    public function checkCRC($type)
    {
        $db = DB::select('SELECT * FROM rawdata WHERE '
            . 'modus = ? AND '//, [$type]);
            . 'checksum_at IS NOT NULL '
            . 'ORDER BY checksum_at DESC, dbId ASC, cellpos ASC;', [$type]);
        return $db;
    }

    public function remainingHotels()
    {
        $stuff = $this->sheets->sheetsCountries();
        $sheets = $stuff['gsheets'];
        foreach ($sheets as $country_id => $country_name) {
            $cid = Countries::convert('id', ['name' => $country_name]);
            $allHotels = Hotels::where('country_id', $cid)->get()->all();
            $sheet = $this->sheets->grabSheet($country_name, true, true)['sheet'];
            $hotelNames = [];
            foreach ($sheet as $row) {
                $hotelNames[] = html_entity_decode(strip_tags($row[2]));
            }
            foreach ($allHotels as $hotel) {
                if (!in_array($hotel->name, $hotelNames)) {

                    $descs = $hotel->getTranslations()['description'];
                    foreach ($this->lngs as $vals) {
                        if (!in_array($vals, array_keys($descs))) $descs[$vals] = '';
                    }
                    $this->sheets->addRow($country_name, $hotel->name, [
                        'en' => html_entity_decode(strip_tags($descs['en'])),
                        'de' => html_entity_decode(strip_tags($descs['de'])),
                        'fr' => html_entity_decode(strip_tags($descs['fr'])),
                        'tr' => html_entity_decode(strip_tags($descs['tr'])),
                        'nl' => html_entity_decode(strip_tags($descs['nl']))
                    ]);
                    $this->warn($country_name . ': ' . $hotel->name . ' added to sheet');
                }
            }
        }
        if ($this->sheets->cacheNotEmpty()) $this->sheets->forceUpdates();
    }

    public function SaveandGo($tainted)
    {
        $pack = [];
        $this->warn('processing entries to Database...');
        // save to sheet, need cellpos
        foreach ($tainted as $item) {
            if ($item->colname === 'name') {
                $this->warn('processing to DB:' . $item->dbId . ': at ' . $item->cellpos . ' named : ' . $item->celldata);
            } else {
                $this->warn('   ' . $item->country . '/' . $item->lang . ': ' . $item->dbId . ' (' . $item->cellpos . ')');
            }
            // select tab of the sheet according to the tained entries country
            $pack = $this->sheets->grabSheet($this->countryName, false, true)['set'];

            // find out the real name of the hotel
            $hotelName = RawData::select('celldata')
                ->where('modus', 'HOTEL')
                ->where('dbId', $item->dbId)
                ->where('colname', 'name')
                ->get()->pluck('celldata')->first();

            $hotel = $item->dbId ?
                Hotels::where('id', $item->dbId)->get()->first() :
                // if dbId is not found, it could be not sync'ed yet, so find out first.
                Hotels::where('name', 'like', '%' . $hotelName . '%')->get()->first();
            if (!$hotel) {
                //still not present, alert the SHEET
                $this->sheets->changeStatus($pack, $item->cellpos,
                    'NOT-PRESENT', 'Hotel was not found on the server database; possibly not created yet.');
            }
            $isActive = $this->sheets->getBitMaskStatusAtSheet(
                $this->countryName, $item->cellpos, array_search($item->lang, $this->lngs)
            );
            $isChanged = $hotel->getTranslations()['description']['en'] === strip_tags($item->celldata) ? true : false;

            $item->colname === 'name' ?
                $hotel->name = [$item->lang => strip_tags($item->celldata)] :
                $hotel->description = [$item->lang => ($isActive ? strip_tags($item->celldata) : '')];
            $hotel->save();

            $this->updateChecksums($item);
            $this->sheets->changeStatus($pack, $item->cellpos, 'LIVE');
            sleep(5);
        }
        if ($this->sheets->cacheNotEmpty()) $this->sheets->forceUpdates();
        return 0;
    }

    public function MarkandGo($tainted)
    {
        $this->warn('processing entries to GoogleSheets...');
        $logs = [];
        $colNames = ['', '', 'name', '', '', '', '',
            '', '', '', '', '', '', '', '',
            '', '', '', '', '', '',
            'english description', 'german description', 'french description', 'turkish description', 'dutch description'];
        $pack = $this->sheets->grabSheet($this->countryName, false, true)['set'];
        // save to database, need IDs please
        foreach ($tainted as $item) {
            if ($item->dbId && $item->colname && $item->lang && $item->country) {

                if ($item->colname === 'name' && $this->isValidCellpos($item->cellpos)) {
                    $this->warn('processing to DB:' . $item->dbId . ': at ' . $item->cellpos . ' named : ' . $item->celldata);
                } else {
                    $this->warn('   ' . $item->country . '/' . $item->lang . ': ' . $item->dbId . ' (' . $item->cellpos . ')');
                }

                // get the specific HOTEL as in tainted
//                $this->sheets->cleanNotes($pack);
                if ($item->celldata && $this->isValidCellpos($item->cellpos)) {

                    $oldContent = $this->sheets->getValue($this->countryName, $item->cellpos);
                    if (!$oldContent)
                        dd('Sheets couldnt be loaded, check authentication settings & permissions...');
                    if ($oldContent !== html_entity_decode(strip_tags($item->celldata))) {
                        $this->sheets->cellValue($pack, $item->cellpos,
                            html_entity_decode(strip_tags($item->celldata)));

// added for revisions table
                        $rev = new Revisions;
                        $rev->extras = $item->lang . ':' . $item->cellpos;
                        $rev->revisionable_type = "Google\Sheets";
                        $rev->revisionable_id = $item->dbId;
                        if ($item->dbId) {
                            $rev->old_value = Hotels::select('description')->where('id', $item->dbId)->get()->first()->pluck('description');
                        }
                        $rev->new_value = html_entity_decode(strip_tags($item->celldata));
                        $rev->save();
// added for revisions table

                    }
                    $this->sheets->cellNote($pack, $item->cellpos, $oldContent);
                    $logs[] = (object)[
                        'sheet' => $this->countryName,
                        'cell' => $item->cellpos,
                        'time' => Reservoir::getLastUpdate($this->countryName)
                    ];

                }
                $this->updateChecksums($item);
                $this->sheets->changeStatus($pack, $item->cellpos,
                    'REVIEW', 'Hotels ' .
                    $colNames[array_search((integer)substr($item->cellpos, -3, 3), $this->colsToGrab)] .
                    ' has been edited trough the dashboard and is on review.');
            }
            sleep(5);
        }
        if ($this->sheets->cacheNotEmpty()) $this->sheets->forceUpdates();
        return 0;
    }

    public function updateChecksums($item)
    {
        $hash = ($item->colname === 'name') ? crc32(strtolower($item->celldata)) : crc32($item->celldata);
        RawData::where('modus', 'SHEET')
            ->where('dbId', $item->dbId)
            ->where('country', $item->country)
            ->where('lang', $item->lang)
            ->where('colname', $item->colname)
            ->update([
                'celldata' => $item->celldata,
                'hash' => $hash,
                'checksum_at' => null]);

        RawData::where('modus', 'HOTEL')
            ->where('dbId', $item->dbId)
            ->where('country', $item->country)
            ->where('lang', $item->lang)
            ->where('colname', $item->colname)
            ->update([
                'celldata' => $item->celldata,
                'hash' => $hash,
                'checksum_at' => null]);
    }

    public function isValidCellpos($cp)
    {
        $cps = explode(':', $cp);
        return (is_int($cps[0]) && is_int($cps[1])) ? true : false;
    }

    public function sync()
    {
        $cellY = 0;
        $cellX = 0;

        // 1. get name from HOTEL items
        // 2. match them with the SHEET items trough HASH table
        // 3. update the matching SHEET items based on CELLPOS && COUNTRY
        // 4. update multiple rows on HOTEL with the CELLPOS on the sheet

        $rawhotels = RawData::where('modus', 'HOTEL')->where('colname', 'name')->get();

        $bar = $this->output->createProgressBar(count($rawhotels));
        foreach ($rawhotels as $rawhotel) {
            // find corresponding entry within SHEET by its hashvalue
            $single = RawData::where('modus', 'SHEET')
                ->where('hash', $rawhotel->hash)
                ->get()->first();

            if ($single) {
                // update all entries of the same row with the same dbId

                // Update DBIDs of the same cellpos and same country
                RawData::where('modus', 'SHEET')
                    ->where('cellpos', 'like', substr($single->cellpos, 0, 4) . '%')
                    ->where('country', $single->country)       // to be on the right worksheet!
                    ->update(['dbId' => $rawhotel->dbId]);

                // grab all hotelrows of the same dbId...
                $many = RawData::where('modus', 'HOTEL')
                    ->where('dbId', $rawhotel->dbId)->get();
                $x = 0;
                // to update them with the corrected cellpos, NEEDS to be handreached as xPos needs to be calc'ed
                foreach ($many as $one) {
                    RawData::where('id', $one->id)
                        ->update(['cellpos' => substr($single->cellpos, 0, 4) .
                            str_pad($this->colsToGrab[$x], 3, '0', STR_PAD_LEFT)]);
                    $x++;
                    $x %= count($this->colsToGrab) - 1;
                }

            }
            //DB::statement("DELETE FROM variables WHERE variables.vkey LIKE 'sheets.backup.%' AND variables.updated_at < FROM_DAYS(TO_DAYS(NOW())-6);");

            $bar->advance();
        }
        $bar->finish();

        // these arent existing on the sheets
        $notOnSheets = RawData::where('modus', 'HOTEL')->whereNull('cellpos')->get();

        // these are on sheet but not on local database
        $notOnDB = RawData::where('modus', 'SHEET')->whereNull('dbId')->get();

        return 0;
    }
}
