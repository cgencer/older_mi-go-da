<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset';

    public function customers()
    {
        return $this->hasMany('App\Models\Customers', 'id');
    }
}
