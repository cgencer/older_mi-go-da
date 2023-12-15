<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class States extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $table = 'states';

    public function cities()
    {
        return $this->belongsTo('App\Models\Cities', 'id', 'state_id');
    }

    public function countries()
    {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id');
    }
}
