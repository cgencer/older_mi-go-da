<?php

namespace App\Util;

use Illuminate\Http\Request, Illuminate\Support\Collection, Illuminate\Console\Command;
use Carbon\Carbon, Auth;
use App\Models\Variables, App\Models\Hotels, App\Models\Countries;
use App\Models\RawData, App\Models\Reservoir;
use Google_Client, Google_Service_Sheets, Google_Service_Sheets_GridRange, Google_Service_Sheets_Color;
use Google_Service_Sheets_CellFormat, Google_Service_Sheets_TextFormat, Google_Service_Sheets_CellData;
use Google_Service_Sheets_RepeatCellRequest, Google_Service_Sheets_Request, Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest, Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_ExtendedValue, GStack;
use Google_DriveFile, Google_Service_Drive, Google_Service_Drive_DriveFile, Google_Service_Drive_FileList;
use Revolution\Google\Sheets\Sheets;
use Spatie\Translatable\HasTranslations;

class GoogleSheets
{
    protected $client;
    protected $sheets;
    protected $service;
    protected $drive_service;
//    protected $save;
    protected $sheetId;
    protected $worksheets;
    protected $worksheet;
    protected $countries;
    protected $credentials = 'credentials-real.json';
    protected $reqArchive = [];
    protected $reqArchiveCounter = 0;
    protected $blockSize = 0;
    protected $colNames = ['', 'id', 'sku', 'name', '', '', '', '', 'address', '', 'city', '',
	'contact_email', 'website', 'contact_phone', '', '', '', '', '', '', '', 'description', '', '', '', ''];
    protected $lngs;

	public function __construct($id = '1Jo5NwxCiAhqciyZ0ZghG1nqNbblzdSCgXonhpYpm1t0', $blockSize=40)
    {
        $this->sheetId = $id ?? config('google.sheets.sheet_id');
        $this->statues = config('services.google.sheets.sync_status');
        $this->lngs = config('services.google.sheets.langs');

    	$this->reqArchive = [];
    	$this->reqArchiveCounter = 0;

        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path($this->credentials));
        $this->client->setScopes([Google_Service_Sheets::DRIVE, Google_Service_Sheets::SPREADSHEETS]);

        $this->service = new \Google_Service_Sheets($this->client);
        $this->drive_service = new Google_Service_Drive($this->client);

        $this->sheets = new Sheets();
        $this->sheets->setService($this->service);

//        $this->cache = new GoogleSheetsRequestCache();

        $this->blockSize = $blockSize;

//        $this->save = config('google.service.file');
        config('google.service.file', storage_path($this->credentials));
        config('google.service.enable', true);
    }

    public function __destruct()
    {
//        config('google.service.file', $this->save);
        config('google.service.enable', config('google.service.enable', true));
    }

    public function saveAsJSONFile($id, $content)
    {
    	return $this->saveAs('', json_encode(['key'=>'value']), 'backup.txt', $id, 'application/json');
    }

    public function saveAsExcel($id, $name, $content)
    {
    	return $this->saveAs('', $content, $name, $id, 'application/vnd.ms-excel');
    }

	public function saveAs($file_path = '', $content = null, $file_name, $parent_file_id = null, $mime)
	{
	    $file = new Google_Service_Drive_DriveFile();
	    $file->setName($file_name);
		$results = collect($this->drive_service->files->listFiles());
//		var_dump($results->pluck('name', 'id'));
		foreach ($results->pluck('name', 'id') as $id => $name) {
			if($name === 'sheetBackups' && !empty( $parent_file_id )){
				$file->setParents( [ $id ] );
				break;
			}
		}
		$result = $this->drive_service->files->create($file, [
			'data' => $content, 		//($file_path = '') ? $content : file_get_contents($file_path),
			'mimeType' => $mime
		]);

		$is_success = false;
		if( isset( $result['name'] ) && !empty( $result['name'] ) ){
			$is_success = true;
			return $result;
		}
		return $is_success;
	}

	public function createSkelleton( $row )
	{
		$skel = [];

		$i = 0;
		foreach ($this->colNames as $val) {
			if($val !== ''){

				$idx = (int) array_search($val, $this->colNames);
				if($val === 'contact_phone') {

					$skel[$val] = trim(preg_replace('/00[\d]*\s([\d\s]*)/i', '$1', $row[$idx]));

				} else if($val === 'description' || $val === 'name') {

					$set = [];
					$offset = 0;
					foreach ($this->lngs as $lang) {

						$set[$lang] = ( substr( $row[$idx - 1], $offset, 1) === 'X' || $val === 'name') ?
						 	$row[ $idx + $offset ] : '';

						if($val === 'description') $offset++;
					}
					$skel[$val] = json_encode($set);

				} else if(in_array($val, array_filter($this->colNames, function($v){return $v !== '';}) )) {

					$skel[$val] = $row[$i];
				}
			}
			$i++;
		}
		return (object) $skel;
	}

	public function findFolders( $folder_name )
	{
		$parameters['q'] = 'mimeType=\'application/vnd.google-apps.folder\' and name=\''.$folder_name.'\' and trashed=false';
		$files = collect($this->drive_service->files->listFiles($parameters));
		$op = [];
		return \App\Helpers::array_flatten((array) $files->pluck('name', 'id'));
	}

	public function ll( $id )
	{
		$parameters['q'] = 'mimeType=\'application/vnd.google-apps.folder\' and name=\''.$id.'\' in parents and trashed=false';
		$files = collect($this->drive_service->files->listFiles($parameters));
		$op = [];
		return $files->pluck('name', 'id');
	}

	public function create_folder( $folder_name, $parent_folder_id=null )
	{
		$folder_list = check_folder_exists( $folder_name );

		// if folder does not exists
		if( count( $folder_list ) == 0 ){
			$service = new Google_Service_Drive( $GLOBALS['client'] );
			$folder = new Google_Service_Drive_DriveFile();

			$folder->setName( $folder_name );
			$folder->setMimeType('application/vnd.google-apps.folder');
			if( !empty( $parent_folder_id ) ){
				$folder->setParents( [ $parent_folder_id ] );
			}

			$result = $service->files->create( $folder );
			$folder_id = null;

			if( isset( $result['id'] ) && !empty( $result['id'] ) ){
				$folder_id = $result['id'];
			}
			return $folder_id;
		}
		return $folder_list[0]['id'];
    }

	public function get_files_and_folders()
	{
		$service = new Google_Service_Drive($GLOBALS['client']);

		$parameters['q'] = 'mimeType=\'application/vnd.google-apps.folder\' and \'root\' in parents and trashed=false';
		$files = $service->files->listFiles($parameters);

		foreach( $files as $k => $file ){
			echo "{$file['name']} - {$file['id']} ---- " . $file['mimeType'];
            try {
				// subfiles
				$sub_files = $service->files->listFiles(array('q' => "'{$file['id']}' in parents"));
				foreach( $sub_files as $kk => $sub_file ) {
					echo $sub_file['name'] - $sub_file['id'] . $sub_file['mimeType'];
				}
			} catch (\Throwable $th) {
				// dd($th);
			}
		}
	}

    public function sheetsCountries()
    {
        $vData = Reservoir::where('vkey', 'sheets.countries')->whereNotNull('vval')->get()->pluck('vval')->first();
        if($vData === null){
			$gsheets = $this->sheets->spreadsheet($this->sheetId)->sheetList();
            $encoded = json_encode($gsheets);
	        Reservoir::updateOrCreate(['vkey' => 'sheets.countries'],['vval' => $encoded]);
            $vData = $encoded;
        }
        $gsheets = json_decode($vData);

        $crs = '';
        $vData = Reservoir::where('vkey', 'sheets.countriesList')->whereNotNull('vval')->get()->pluck('vval')->first();
        if($vData === null){
            foreach ($gsheets as $id => $nam) {
                $crs .= $nam . ', ';
            }
            $crs = substr($crs, 0, strlen($crs)-2);
	        Reservoir::updateOrCreate(['vkey' => 'sheets.countriesList'],['vval' => $crs]);
        }else{
            $crs = $vData;
        }
        return ['countries'=>$crs, 'gsheets'=>$gsheets];
    }

    public function grabSheet($country, $sheet = true, $pack = true)
    {
    	$arr = [];
    	if(!$this->worksheets){
	        $stuff = $this->sheetsCountries();
	        $this->worksheets = $stuff['gsheets'];
	        $this->countries  = $stuff['countries'];

//	        $this->warn('available worksheets:');
//    	    $this->warn($this->countries);
    	}
        foreach ($this->worksheets as $worksheetId => $nam) {
            if(strtolower(trim($nam)) == strtolower(trim($country))){
            	if($worksheetId && $this->worksheets && $this->sheetId){
	                $this->worksheet = $this->sheets->spreadsheet($this->sheetId)->sheetById($worksheetId)->all();
					$s = $sheet ? ['sheet' => $this->worksheet] : [];
					$p = $pack ? ['set' => ['id'=>$worksheetId, 'name'=>$nam]] : [];

					$c = strtolower(Countries::select('code')->where('name', 'like', '%'.$nam.'%')->get()->pluck('code')->first());
					$son = Reservoir::where('vkey', 'sheets.backup.'.$c)->orderBy('updated_at', 'desc')->get()->first();
					if($son){
						if($nam !== '' && Carbon::now()->diffInMinutes($son->updated_at) > 360)
						{
	    	    	        $voir = new Reservoir();
    			            $voir->vkey = 'sheets.backup.'.$c;
    	    		        $voir->vval = json_encode($this->worksheet);
	            		    $voir->save();
						}
					}
            	    return array_merge($s, $p);
            	}
            }
        }
        return false;
    }

    public function getValue($countryname, $cellpos)
    {
		$coordYX = explode(':', $cellpos);

		$workSheet = $this->grabSheet($countryname, true, false);
		if($workSheet)
			return html_entity_decode( strip_tags( $workSheet['sheet'][ (integer) $coordYX[0] ][ (integer) $coordYX[1] ] ));
		else
			return false;
    }

    public function getBitMaskStatusAtSheet($country, $cellpos, $bitpos)
    {
		$va = str_split($this->getValue($country, substr($cellpos, 0, 4).'020'));
		return ($va[$bitpos]==='X') ? true : false;
    }

    public function setBitMaskStatusAtSheet($country, $cellpos, $bitpos, $onf=false)
    {
		$va = explode('', $this->getValue($country, substr($cellpos, 0, 4).'020'));
		$va[$bitpos] = $onf ? 'X' : 'O';
		$this->cellValue($country, substr($cellpos, 0, 4).'020', implode('', array_reverse($va)));
    }

    public function convertToCell($coords)
    {
    	$lettered = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		$pos = explode(':', $coords);
		return $lettered[(integer) $pos[1]-1] . (integer) $pos[0] . ':' . $lettered[(integer) $pos[1]] . (integer) ($pos[0]+1);
    }

    public function cleanNotes($subSheet)
    {
		$sheetId = $this->sheets->get($this->sheetId);
		$range = new Google_Service_Sheets_GridRange();
		$range->setSheetId($subSheet['id']);
		$range->setStartRowIndex(0);
		$range->setEndRowIndex(1000);
		$range->setStartColumnIndex(0);
		$range->setEndColumnIndex(100);
		$repeatCell = new Google_Service_Sheets_RepeatCellRequest();
		$cellData = new Google_Service_Sheets_CellData();
		$cellData->setNote('');
		$repeatCell->setCell($cellData);
		$repeatCell->setRange($range);
		$repeatCell->setFields("note");
		$this->queueUpdates($repeatCell);
    }

    public function cellValue($subSheet, $coords, $newContent, $collect=false)
    {
		$range = $this->setCoords($subSheet, $coords);
		$repeatCell2 = new Google_Service_Sheets_RepeatCellRequest();
		$cellData2 = new Google_Service_Sheets_CellData();
		$extVal2 = new Google_Service_Sheets_ExtendedValue();
		$extVal2->setStringValue($newContent);
		$cellData2->setUserEnteredValue($extVal2);
		$values2[] = $cellData2;
		$repeatCell2->setCell($cellData2);
		$repeatCell2->setRange($range);
		$repeatCell2->setFields('userEnteredValue');
		if ($collect){
			$this->queueUpdates($repeatCell2);
		} else{
			$reqNoArchive = new Google_Service_Sheets_Request();
			$reqNoArchive->setRepeatCell($repeatCell2);
			$updateReq = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $reqNoArchive]);
			$this->sheets->spreadsheets->batchUpdate($this->sheetId, $updateReq);
		}
    }

    public function cellLink($subSheet, $coords, $link, $collect=false)
    {
		$range = $this->setCoords($subSheet, $coords);
		$repeatCell2 = new Google_Service_Sheets_RepeatCellRequest();
		$cellData2 = new Google_Service_Sheets_CellData();
		$extVal2 = new Google_Service_Sheets_ExtendedValue();
		$extVal2->setFormulaValue($link);
		$cellData2->setUserEnteredValue($extVal2);
		$values2[] = $cellData2;
		$repeatCell2->setCell($cellData2);
		$repeatCell2->setRange($range);
		$repeatCell2->setFields('userEnteredValue');
		if ($collect){
			$this->queueUpdates($repeatCell2);
		} else{
			$reqNoArchive = new Google_Service_Sheets_Request();
			$reqNoArchive->setRepeatCell($repeatCell2);
			$updateReq = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $reqNoArchive]);
			$this->sheets->spreadsheets->batchUpdate($this->sheetId, $updateReq);
		}
    }
	public function cellNote($subSheet, $coords, $note, $collect=false)
	{
		$range = $this->setCoords($subSheet, $coords);
		$repeatCell = new Google_Service_Sheets_RepeatCellRequest();
		$cellData = new Google_Service_Sheets_CellData();
		$cellData->setNote($note);
		$repeatCell->setCell($cellData);
		$repeatCell->setRange($range);
		$repeatCell->setFields("note");
		if ($collect){
			$this->queueUpdates($repeatCell);
		} else{
			$reqNoArchive = new Google_Service_Sheets_Request();
			$reqNoArchive->setRepeatCell($repeatCell);
			$updateReq = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $reqNoArchive]);
			$this->sheets->spreadsheets->batchUpdate($this->sheetId, $updateReq);
		}
    }

    public function setCoords($subSheet, $coords)
    {
		$sheetId = $this->sheets->get($this->sheetId);
		$pos = explode(':', $coords);
		$posY = (integer)$pos[0];
		$posX = (integer)$pos[1];

		$range = new Google_Service_Sheets_GridRange();
		$range->setSheetId($subSheet['id']);
		$range->setStartRowIndex($posY);				// +1 for titlerow
		$range->setEndRowIndex($posY+1);				// +2 for title+ +1 for 'until next row'
		$range->setStartColumnIndex($posX);
		$range->setEndColumnIndex($posX+1);
		return $range;
    }

    public function queueUpdates($rCell)
    {
		if(($this->reqArchiveCounter % $this->blockSize) === 0){
			if(count($this->reqArchive)>0){
				$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $this->reqArchive]);
				$this->sheets->spreadsheets->batchUpdate($this->sheetId, $batchUpdateRequest);
			}
			$this->reqArchive = [];
		}else{
			$this->reqArchive[] = new Google_Service_Sheets_Request();
			$this->reqArchive[count($this->reqArchive)-1]->setRepeatCell($rCell);
		}
		$this->reqArchiveCounter++;
    }

    public function forceUpdates()
    {
    	if(count($this->reqArchive)>0){
			$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $this->reqArchive]);
			$this->sheets->spreadsheets->batchUpdate($this->sheetId, $batchUpdateRequest);
			$this->reqArchive = [];
    	}
    }

    public function getSubSheetInfo($fromCode = '', $fromName = ''){
    	$pack = [];
    	if($fromCode != ''){
			foreach ($this->worksheets as $id => $nam) {
				if($nam === \App\Models\Countries::select('name')->where('code', strtoupper($fromCode))->get()->pluck('name')->first()){
					$pack = ['id'=>$id, 'name'=>$nam];
					break;
				}
			}
    	}else if($fromName != ''){
			foreach ($this->worksheets as $id => $nam) {
				if($nam === \App\Models\Countries::select('name')->where('code', strtoupper($fromCode))->get()->pluck('name')->first()){
					$pack = ['id'=>$id, 'name'=>$nam];
					break;
				}
			}
    	}
    	return $pack;
	}

	public function changeStatus($subSheet, $coords, $status, $detail = '')
	{
		$sheetId = $this->sheets->get($this->sheetId);
		$pos = explode(':', $coords);
		$coords = str_pad((integer)$pos[0], 3, '0', STR_PAD_LEFT) . ':000';

		if(in_array($status, $this->statues)){
			$this->cellValue($subSheet, $coords, $status);

			if($detail !== '')
				$this->cellNote($subSheet, $coords, $detail);
		}
	}

	public function addRow($countryname, $hotelname, $rowdata = ['en'=>'', 'de'=>'', 'fr'=>'', 'tr'=>'', 'nl'=>''])
	{
		var_dump($countryname, $hotelname, $rowdata);
		$range = $countryname.'!A:Y';
		$body = new Google_Service_Sheets_ValueRange([
			'values' => [["NEW-ON-DB", "", $hotelname, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
						"OOOOO", $rowdata["en"], $rowdata["de"], $rowdata["fr"], $rowdata["tr"], $rowdata["nl"], ""]]
		]);
		$result = $this->service->spreadsheets_values->append($this->sheetId, $range, $body, ['valueInputOption' => "RAW"]);
	}

	public function cellBorder($subSheet, $coords)
	{
		$sheetId = $this->sheets->get($this->sheetId);
		$requests = [
			new Google_Service_Sheets_Request([
				'repeatCell' => [
					'fields' => 'userEnteredFormat.backgroundColor, userEnteredFormat.textFormat.bold',
					'range' => [
						'sheetId' 			=> $subSheet['id'],
						'startRowIndex' 	=> $posY,
						'endRowIndex' 		=> $posY+1,
						'startColumnIndex' 	=> $posX,
						'endColumnIndex' 	=> $posX+1,
					],
					'cell' => [
						'userEnteredFormat' => [
/*							'backgroundColor' => [
								'red' 	=> $red,
								'green' => $green,
								'blue' 	=> $blue,
								'alpha' => $alpha,
							], */
							'textFormat' => [
								'bold' => true
							]
						]
					],
				],
			])
		];

		$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
			'requests' => $requests
		]);
		return $this->sheets->spreadsheets->batchUpdate($this->sheetId, $batchUpdateRequest);
	}
}
