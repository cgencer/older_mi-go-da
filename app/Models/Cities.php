<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Cities extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $table = 'cities';

    public function states()
    {
        return $this->belongsTo('App\Models\States', 'state_id', 'id');
    }
}
