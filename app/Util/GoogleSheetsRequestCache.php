<?php

namespace App\Util;

use Illuminate\Http\Request, Illuminate\Support\Collection, Carbon\Carbon, Auth;
use App\Models\Hotels, App\Models\Countries, App\Models\RawData, App\Models\Reservoir;
use Google_Client, Google_Service_Sheets, Google_Service_Sheets_RepeatCellRequest, Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest, Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_Request, Google_Service_Sheets_ExtendedValue, GStack;
use Google_DriveFile, Google_Service_Drive, Google_Service_Drive_DriveFile, Google_Service_Drive_FileList;
use Revolution\Google\Sheets\Sheets;
use Spatie\Translatable\HasTranslations;

class GoogleSheetsRequestCache
{
    protected $client, $sheets;
    protected $dservice, $sservice;
    protected $worksheet, $worksheets;
    protected $sheetId;
    protected $credentials = 'credentials-real.json';
    protected $reqArchive = [];
    protected $reqArchiveCounter = 0;
    protected $blockSize = 0;

	public function __construct($blockSize=40, $id=null)
    {
        $this->sheetId = $id ?? config('google.sheets.sheet_id');
    	$this->reqArchive = [];
    	$this->reqArchiveCounter = 0;
        $this->blockSize = $blockSize;

        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path($this->credentials));
        $this->client->setScopes([Google_Service_Sheets::DRIVE, Google_Service_Sheets::SPREADSHEETS]);

        $this->sservice = new \Google_Service_Sheets($this->client);
        $this->dservice = new Google_Service_Drive($this->client);

        $this->sheets = new Sheets();
        $this->sheets->setService($this->service);
    }

    public function createReq($cell)
    {
		if(($this->reqArchiveCounter % $this->blockSize) >= $this->blockSize-1){
			// put the last one also onto stack
			$req = new Google_Service_Sheets_Request();
//$repeatCell->setCell($cell);
			$req->setRepeatCell($cell);
			$this->reqArchive[] = $req;

			if(count($this->reqArchive) > 0){
				$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $this->reqArchive]);
				$this->sheets->spreadsheets->batchUpdate($this->sheetId, $batchUpdateRequest);
			}
			$this->reqArchive = [];
			$this->reqArchiveCounter = 0;
		}else{
			$this->reqArchive[] = new Google_Service_Sheets_Request();
			$this->reqArchive[ count($this->reqArchive)-1 ]->setRepeatCell($cell);
		}
		$this->reqArchiveCounter++;
    }

    public function cacheNotEmpty()
    {
		return (count($this->reqArchive) > 0) ? true : false;
    }

    public function forceUpdates()
    {
    	if(count($this->reqArchive)>0){
			$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(['requests' => $this->reqArchive]);
			$this->sheets->spreadsheets->batchUpdate($this->sheetId, $batchUpdateRequest);
			$this->reqArchive = [];
    	}
    }

}
