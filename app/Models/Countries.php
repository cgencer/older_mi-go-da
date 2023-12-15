<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Countries extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $table = 'countries';

    public function states()
    {
        return $this->belongsTo('App\Models\States', 'id', 'country_id');
    }

    public function getPrefixedName()
    {
        return $this->name . ' (+' . $this->prefix . ')';
    }

    // converts any column of countries into another
    // USAGE: Countries::convert('code', ['code'=>'de'])
    public static function convert($out='code', $pre, $lower = false)
    {
        if(!in_array($out, ['code', 'iso3', 'id', 'name', 'currency', 'currency_symbol', 'currency_name', 'prefix'])){
            dd('countries modell:convert destination trouble...');
        }
        foreach ($pre as $k => $v) {
            $like = ($k === 'name') ? true : false;
            $c = Countries::when(!empty($pre) && !$like, function ($q) use ($k, $v) {
                return $q->where($k, strtoupper($v));
            })->when($like, function ($q) use ($k, $v) {
                return $q->whereRaw("LOWER(".$k.") LIKE '%".strtolower($v)."%'");
            })->get()->pluck($out)->first();
        }
        return \App\Helpers::array_flatten($c)[0];
    }

    public function getConversionRateAttribute($val)
    {
        return ($val / 10000);
    }

    public function setConversionRateAttribute($val)
    {
        return ($val * 10000);
    }

}

