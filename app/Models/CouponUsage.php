<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $table = 'coupon_usages';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers', 'customer_id', 'id');
    }

    public function couponUsages()
    {
        return $this->belongsTo('App\Models\CouponUsage', 'code', 'code');
    }

    public function couponCodes()
    {
        return $this->hasOne('App\Models\CouponCode', 'coupon_usage_id', 'id')->get();
    }

    public function release()
    {
        $this->reservation_id = null;
        $this->save();
    }
}
