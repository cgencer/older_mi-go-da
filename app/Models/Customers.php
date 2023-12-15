<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Plank\Mediable\Mediable;
use Artisan, Auth;
use App\Models\Stripe\StripeCustomer;
use App\Events\CustomerCreated;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Authenticatable
{
    use Notifiable, Favoriter, Uuids, Mediable, StripeCustomer, SoftDeletes;

    protected $table = 'customers';
    protected $guarded = [];
    protected $appends = ['profile_image', 'customerSid'];
    protected $stripe_tags = ['customer_id', 'customer_sid'];

    protected $dispatchesEvents = [
        'created' => CustomerCreated::class,
    ];
//        'deleted' => CustomerDeleted::class,
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
        'billing_address' => 'array',
        'stripe_data' => 'array'
    ];

    public function getReservations()
    {
        return $this->hasMany('App\Models\Reservation', 'customer_id', 'id');
    }

    public function getPayments()
    {
        return $this->hasMany('App\Models\Payments', 'customer_id', 'id');
    }

    public function getCustomerCoupons()
    {
        $coupons = [
            'valid' => [],
            'used' => 0,
            'invalid' => 0,
        ];
        $user = $this;

        if (!$user) {
            return $coupons;
        }
        $couponCodes = CouponUsage::where('customer_id', $user->id)->get();
        foreach ($couponCodes as $couponCode) {
            $coupon = CouponCode::where('code', $couponCode->code)->get()->first();

            if ($coupon->checkValidCoupon($user->id)) {
                $coupons['valid'][] = $coupon->code;
            } else {

                if ($coupon->getReservation()) {
                    $coupons['used']++;
                }
                $coupons['invalid']++;
            }
        }
        return $coupons;
    }

    public function getCustomerSidAttribute()
    {
        return $this->stripe_data['customer_sid'] ?? null;
    }

    public function setCustomerSidAttribute($id)
    {
        $this->saveStripeData(['customer_sid'=>$id]);
    }

    public function getProfileImageAttribute()
    {
        if ($this->getMedia('profile_image')->count() > 0) {
            return $this->getMedia('profile_image')->first();
        }
        return null;
    }

    public function passwordReset()
    {
        return $this->belongsTo('App\Models\PasswordReset', 'customer_id');
    }

    public function saveStripeData($in)
    {
        $this->stripe_data = array_merge($this->stripe_data ?? [], $in);
        $this->save();
    }

    public function checkSync()
    {
        $this->attributes['enabled'] = is_null($this->stripeProductId) ? 0 : 1;
    }
    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.' . $this->id;
    }

}
