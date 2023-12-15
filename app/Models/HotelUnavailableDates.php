<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelUnavailableDates extends Model
{
    protected $table = 'hotel_unavailable_dates';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];
}
