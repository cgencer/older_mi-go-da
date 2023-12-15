<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Documents extends Model
{
    use Mediable;

    protected $table = 'documents';
    protected $appends = ['files'];

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'userID');
    }

    public function hotels()
    {
        return $this->belongsTo('App\Models\Hotels', 'hotelId', 'id');
    }
    public function getFilesAttribute()
    {
        $documents = array();
        if ($this->getMedia('file')->count() > 0) {
            foreach ($this->getMedia('file') as $value) {
                $documents[] = $value;
            }
            return $documents;
        }
        return null;

    }
}
