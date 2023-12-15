<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Features extends Model
{

    use  HasTranslations;

    public $translatable = ['name'];

    protected $table = 'features';

    public function group()
    {
        return $this->belongsTo('App\Models\FeatureGroups', 'group_id');
    }
}
