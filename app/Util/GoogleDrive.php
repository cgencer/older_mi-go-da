<?php

namespace App\Util;

use Illuminate\Http\Request, Illuminate\Support\Collection;
use Auth, Carbon\Carbon;
use App\Models\Variables, App\Models\Hotels, App\Models\Countries;
use App\Models\RawData, App\Models\Reservoir;
use Google_Client, Google_Service_Sheets, Google_Service_Sheets_GridRange, Google_Service_Sheets_Color;
use Google_Service_Sheets_CellFormat, Google_Service_Sheets_TextFormat, Google_Service_Sheets_CellData;
use Google_Service_Sheets_RepeatCellRequest, Google_Service_Sheets_Request, Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest, Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_ExtendedValue;
use Google_DriveFile, Google_Service_Drive, Google_Service_Drive_DriveFile, Google_Service_Drive_FileList;
use Google_Service_Drive_Permission, Google_Service_Drive_PermissionList;
use Revolution\Google\Sheets\Sheets;
use Spatie\Translatable\HasTranslations;

class GoogleDrive
{
    protected $client;
    protected $sheets;
    protected $service;
    protected $drive_service;
    protected $save;
    protected $sheetId;
    protected $worksheets;
    protected $worksheet;
    protected $countries;
    protected $credentials = 'credentials-real.json';

	public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path($this->credentials));
        $this->client->setScopes([Google_Service_Sheets::DRIVE, Google_Service_Sheets::SPREADSHEETS]);
        $this->drive_service = new Google_Service_Drive($this->client);
    }

    public function saveAsJSONFile($id, $content)
    {
    	return $this->saveAs('', $content, 'backup.txt', $id, 'application/json');
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
		if(isset($result['name'] ) && !empty( $result['name'])){
			$is_success = true;
			return $result;
		}
		return $is_success;
	}

	public function dir($withFilter=null)
	{
		$optParams = array(
			'fields' => 'files(id, name)'
		);
		$results = collect($this->drive_service->files->listFiles($optParams));
		$dir = \App\Helpers::array_flatten((array) $results->pluck('name', 'id'));
		if($withFilter) {
	        $newdir = [];
	        foreach ($dir as $id => $name) {
    	        if(substr($name, 0, strlen($withFilter)) === $withFilter ){
        	        $newdir[] = [$id => $name];
            	}
	        }
    	    return(\App\Helpers::array_flatten($newdir));
		}else{
			return $dir;
		}
	}

	public function truncateNDays($days = 7)
	{
		$i = 0;
		$dir = $this->dir('MigodaHotels_20');
		foreach ($dir as $id => $name) {
//			for($i=0; $i<10; $i++){
			if($name === 'MigodaHotels_' . Carbon::now()->subDays($days+$i)->toDateString()){

	    		$permissions = $this->drive_service->permissions->listPermissions($id);
		    	var_dump($name);
				try {
					$this->drive_service->files->delete($id);
				} catch (Exception $e) {
					print "An error occurred: " . $e->getMessage();
				}
			}
//			}
		}
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
		$parameters['q'] = 'mimeType=\'application/vnd.google-apps.folder\' and \''.$id.'\' in parents and trashed=false';
		$files = collect($this->drive_service->files->listFiles($parameters));
		$op = [];
		return $files->pluck('name', 'id');
	}

	public function root()
	{
		$parameters['q'] = 'mimeType=\'application/vnd.google-apps.folder\' and \'root\' in parents and trashed=false';
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





	public function getFileId($filename)
	{
		if( substr_count($filename, "/") === 0 ) {
			$filename = $filename;
			$folder_id = $this->getFolderId();
		} else {
			$folder_id = explode("/", $filename);
			$filename = $folder_id[count($folder_id) - 1];
			unset($folder_id[count($folder_id) - 1]);
			$folder_id = implode("/", $folder_id);
			$folder_id = $this->getFolderId($folder_id);
		}
		$results = $this->drive_service->files->listFiles([
			'q' => "mimeType != 'application/vnd.google-apps.folder' and " .
					"name='" . $filename . "' and " .
					"trashed=false ",
//					"'" . $folder_id . "' in parents",
			'fields' => "nextPageToken, files(id, name)",
			'orderBy' => 'modifiedTime desc, name asc',
			'includeItemsFromAllDrives' => true,
			'supportsAllDrives' => true
		]);
		if (count($results->getFiles()) == 0)
			return null;
		else {
			foreach ($results->getFiles() as $file) {
				return $file->getId();
			}
		}
		return null;
	}

	public function getFolderId($name = null)
	{
		$cur_id = 'root';
		if($name === null || $name == "" || $name == "/") {

		} else if(substr_count($name, "/") >= 1) {
			while(1) {
				$first = explode("/", $name)[0];
				$cur_id = $this->getFolderIdRecursive($first, $cur_id);
				if( substr_count($name, "/") === 0 ) { break; }
				$name = substr($name, strpos($name, "/") + 1);
			}
		} else {
			$cur_id = $this->getFolderIdRecursive($name, $cur_id);
		}
		return $cur_id;
	}

	public function getFolderIdRecursive($name, $parent_id = 'root')
	{
		$q = "mimeType = 'application/vnd.google-apps.folder' and " .
			 "name = '".$name."' and " .
			 "trashed=false ";
//			 "'" . $parent_id . "' in parents";

		$results = $this->drive_service->files->listFiles([
			'q' => $q,
			'fields' => "nextPageToken, files(id, name)",
			'orderBy' => 'modifiedTime desc, name asc',
			'includeItemsFromAllDrives' => true,
			'supportsAllDrives' => true
		]);
		if (count($results->getFiles()) == 0) { 
			echo "cannot find folder " . $name . "\n";
			die(); 
			return null;
		} else {
			foreach ($results->getFiles() as $file) {
				return $file->getId();
			}
		}
		return null;
	}

	public function upload($source, $target)
	{
		$target_filename = substr($target, strrpos($target,"/") + 1);
		$target_folder = substr($target, 0, strrpos($target,"/"));

		$this->delete($target);
		$file = new Google_Service_Drive_DriveFile();
		$file->setName($target_filename);
		$file->setParents([$this->getFolderId($target_folder)]);

		$result = $this->drive_service->files->create($file, [
			'data' => file_get_contents(__DIR__.'/../' . $source),
			'mimeType' => 'application/octet-stream',
			'uploadType' => 'media'
		]);
	}

	public function delete($filename)
	{
		$file_id = $this->getFileId($filename);
		try {
			$this->drive_service->files->delete($file_id);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}


}
