<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CouponCode extends Model
{
    protected $table = 'coupon_codes';

    public function getCouponRule()
    {
        return CouponRule::where('id', $this->rule_id)->get()->first();
    }

    public function couponUsages()
    {
        return $this->hasOne('App\Models\CouponUsage', 'code', 'code');
    }

    public function getReservation()
    {
        return CouponUsage::where('code', $this->code)->whereNotNull('reservation_id')->get()->count();
    }

    public function releaseTheCoupon()
    {
        $this->coupon_usage_id = null;
        $this->save();
    }

    public static function getCoupons($name)
    {
        $coupons = DB::table('coupon_codes')
            ->select('coupon_codes.code')
            ->where('coupon_rules.name', $name)
            ->join('coupon_rules', 'coupon_codes.rule_id', '=', 'coupon_rules.id')
            ->get();
        return $coupons;
    }

    public function checkValidCoupon($customerID = null)
    {

        if ($customerID == null) {
            if ($this->coupon_usage_id !== null) {
                return false;
            }
            $couponUsage = CouponUsage::where('code', $this->code)->get();
            if ($couponUsage->count() > 0) {
                return false;
            }
        } else {
            $couponUsage = CouponUsage::where('code', $this->code)->where('customer_id', $customerID)->whereNotNull('reservation_id')->get();
            if ($couponUsage->count() > 0) {
                return false;
            }
        }
        $rule = $this->getCouponRule();
        if (!$rule->is_active) return false;

        $today = Carbon::now();
        if ($rule->start_date > $today && $rule->start_date !== null) return false;
        if ($rule->end_date < $today && $rule->end_date !== null) return false;

        return true;
    }
}
