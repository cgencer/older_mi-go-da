<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponRule extends Model
{
    protected $table = 'coupon_rules';

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function coupons()
    {
        return $this->hasMany('App\Models\CouponCode', 'rule_id', 'id')->get();
    }
}
