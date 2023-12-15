<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertMessage extends Model
{
	public $fillable = ['user_id', 'message'];
}
