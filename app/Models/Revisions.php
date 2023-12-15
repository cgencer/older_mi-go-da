<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisions extends Model
{
    protected $table = 'revisions';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}