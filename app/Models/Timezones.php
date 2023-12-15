<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timezones extends Model
{
    protected $table = 'zonas';
    protected $casts = [
        'offsets' => 'array',
        'alias' => 'array'
    ];
}
