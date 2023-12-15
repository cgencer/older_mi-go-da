<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Models\CouponUsage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class CouponController extends Controller
{

    public function addCouponAjax(\Illuminate\Http\Request $request)
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return Response::json(array('result' => false));
        }
        $couponCode = $request->coupon_code;
        $couponCodeTrimmed = preg_replace('/[^a-zA-Z0-9]+/', '', $couponCode);
        $Coupon = CouponUsage::where('code', $couponCodeTrimmed)->get();
        if ($Coupon->count() > 0) {
            return Response::json(array('result' => false, 'code' => 'CouponUsage'));
        }
        $Coupon = CouponCode::where('code', $couponCodeTrimmed)->get();
        if ($Coupon->count() == 0) {
            return Response::json(array('result' => false, 'code' => 'NotFound'));
        }
        $Coupon = $Coupon->first();
        if ($Coupon->checkValidCoupon() === false) {
            return Response::json(array('result' => false, 'code' => 'NotValid'));
        }
        $addCoupon = new CouponUsage();
        $addCoupon->code = $Coupon->code;
        $addCoupon->rule_id = $Coupon->rule_id;
        $addCoupon->customer_id = $user->id;
        $addCoupon->save();

        return Response::json(array('result' => true));
    }

    public function checkCouponAjax(\Illuminate\Http\Request $request)
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return Response::json(array('result' => false));
        }
        $couponCode = $request->coupon_code;
        $couponCodeTrimmed = preg_replace('/[^a-zA-Z0-9]+/', '', $couponCode);

        $Coupon = CouponUsage::where('code', $couponCodeTrimmed)->get();
        if ($Coupon->count() > 0) {
            return Response::json(array('result' => false));
        }
        $Coupon = CouponCode::where('code', $couponCodeTrimmed)->get();
        if ($Coupon->count() == 0) {
            return Response::json(array('result' => false));
        }
        $Coupon = $Coupon->first();
        if ($Coupon->checkValidCoupon() === false) {
            return Response::json(array('result' => false));
        }
        return Response::json(array('result' => true));
    }

    public function getCouponsAjax()
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return Response::json(array('result' => false));
        }

        return Response::json($user->getCustomerCoupons());
    }
}
