<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command;
use App\Models\Reservoir, App\Models\Hotels, App\Models\Cities;
use App\Models\Countries, App\Models\RawData;

class cleanStuff extends Command
{
    protected $signature = 'clean:stuff {modus}';
    protected $description = 'Deletes various entries from database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        switch ($this->argument('modus')) {
            case 'sheet-countries':
                $res = Reservoir::whereIn('vkey', ['sheets.countries', 'sheets.countriesList'])->get();
                $res->delete();
                break;
            case 'burst-lastrow':
                $res = Reservoir::whereIn('vkey', ['writeID.lastRow'])->get();
                $res->delete();
                break;
            case 'rawdata-hotel':
                $res = RawData::where('modus', 'HOTEL')->get();
                $res->delete();
                break;
            case 'rawdata-sheet':
                $res = RawData::where('modus', 'SHEET')->get();
                $res->delete();
                break;
            case 'payments':
                $res = Payments::get();
                $res->delete();
                break;
            default:
                break;
        }
        return 0;
    }
}
