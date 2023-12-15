<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Countries;

class Reservoir extends Model
{
    protected $table = 'variables';
	protected $fillable = ['vkey', 'vval'];

    public static function getLastUpdate($countryName)
    {
		return Reservoir::select('updated_at')
				 		->where('vkey', 'cell.updated.' . Countries::convert('code', ['name' => $countryName]) )
				 		->get()->first()->pluck('updated_at')[0];
    }

}
