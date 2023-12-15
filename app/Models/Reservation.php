<?php

namespace App\Models;

use App\Notifications\IncomingBookingRequestFollowup;
use App\Notifications\GuestReminder;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\TestNotifications;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class Reservation extends Model
{
    const STATUS_WAITING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_CANCELED = 2;
    const STATUS_PAID = 3;
    const STATUS_PAYMENT_ERROR = 4;
    const STATUS_U_CANCELED_B = 5;
    const STATUS_U_CANCELED_A = 6;
    const STATUS_EXPIRED_CUSTOMER = 7;
    const STATUS_EXPIRED_HOTEL = 8;
    const STATUS_FINISHED = 9;


    use Uuids;

    protected $table = 'reservations';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'checkin_date' => 'datetime',
        'checkout_date' => 'datetime',
        'stripe_data' => 'array'
    ];
    protected $appends = ['remainingHoursFromGenesis', 'formattedPrice', 'remainingHoursFromNow', 'cancel', 'checkinMdY', 'checkoutMdY'];

    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotels', 'hotel_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers', 'customer_id', 'id');
    }

    public function payments()
    {
        return $this->belongsTo('App\Models\Payments', 'id', 'reservation_id');
    }

    public function getCoupons()
    {
        return $this->hasMany('App\Models\CouponUsage', 'reservation_id', 'id');
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
        if ($this->status == 2) {
            $allCouponUsages = $this->getCoupons()->get();
            foreach ($allCouponUsages as $couponUsage) {
                $coupons = $couponUsage->couponCodes();
                foreach ($coupons as $coupon) {
                    $coupon->releaseTheCoupon();
                }
                $couponUsage->release();
            }
        }
    }

    public function setReason($reason = null)
    {
        $this->reason_id = $reason;
        $this->save();
    }

    public function setOtherReason($otherReason = null)
    {
        $this->other_reason = $otherReason;
        $this->save();
    }

    public function getLength()
    {
        return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(DAY, checkin_date, checkout_date) AS days')->get()->first()->days;
    }

    public function addCouponCode($Coupon)
    {
        $user = Auth::guard('customer')->user();
        $addCoupon = CouponUsage::where('code', $Coupon->code)->where('customer_id', $user->id)->get()->first();
        if ($addCoupon) {
            $addCoupon->reservation_id = $this->id;
            $addCoupon->save();

            $Coupon = $Coupon::where('code', $Coupon->code)->get()->first();

            $Coupon->coupon_usage_id = $addCoupon->id;
            $Coupon->save();
        }
    }

    public function getStatusShortcode($statusCode = null)
    {
        if ($statusCode === null) $statusCode = $this->status;
        $statuses = [
            $this::STATUS_WAITING => 'waiting',
            $this::STATUS_APPROVED => 'ready',
            $this::STATUS_CANCELED => 'declined',
            $this::STATUS_PAID => 'payment_completed',
            $this::STATUS_PAYMENT_ERROR => 'error',
            $this::STATUS_U_CANCELED_B => 'u_canceled_before',
            $this::STATUS_U_CANCELED_A => 'u_canceled_after',
            $this::STATUS_EXPIRED_CUSTOMER => "expired_customer",
            $this::STATUS_EXPIRED_HOTEL => "expired_hotel",
            $this::STATUS_FINISHED => "finished",
        ];

        return $statuses[$statusCode] ?? '';
    }

    public function getStatusByCode($statusCode = null)
    {
        if ($statusCode === null) $statusCode = $this->status;
        $statuses = [
            $this::STATUS_WAITING => 'Pending Confirmation',
            $this::STATUS_APPROVED => 'Ready for payment',
            $this::STATUS_CANCELED => 'Booking declined',
            $this::STATUS_PAID => 'Payment Completed',
            $this::STATUS_PAYMENT_ERROR => 'Payment error',
            $this::STATUS_U_CANCELED_B => 'User canceled before expiration',
            $this::STATUS_U_CANCELED_A => 'User canceled after expiration',
            $this::STATUS_EXPIRED_CUSTOMER => "Offer expired (customer) ",
            $this::STATUS_EXPIRED_HOTEL => "Inquiry expired (hotel)",
            $this::STATUS_FINISHED => "Booking Finished",
        ];

        return $statuses[$statusCode] ?? '';
    }

    public function getStatusList()
    {
        return [
            $this::STATUS_WAITING => 'Pending Confirmation',
            $this::STATUS_APPROVED => 'Ready for payment',
            $this::STATUS_CANCELED => 'Booking declined',
            $this::STATUS_PAID => 'Payment Completed',
            $this::STATUS_PAYMENT_ERROR => 'Payment error',
            $this::STATUS_U_CANCELED_B => 'User canceled before expiration',
            $this::STATUS_U_CANCELED_A => 'User canceled after expiration',
            $this::STATUS_EXPIRED_CUSTOMER => "Offer expired (customer) ",
            $this::STATUS_EXPIRED_HOTEL => "Inquiry expired (hotel)",
            $this::STATUS_FINISHED => "Booking Finished",
        ];

    }

    static function getStatusDataList()
    {
        return [
            Reservation::STATUS_WAITING => 'Pending Confirmation',
            Reservation::STATUS_APPROVED => 'Ready for payment',
            Reservation::STATUS_CANCELED => 'Booking declined',
            Reservation::STATUS_PAID => 'Payment Completed',
            Reservation::STATUS_PAYMENT_ERROR => 'Payment error',
            Reservation::STATUS_U_CANCELED_B => 'User canceled before expiration',
            Reservation::STATUS_U_CANCELED_A => 'User canceled after expiration',
            Reservation::STATUS_EXPIRED_CUSTOMER => "Offer expired (customer) ",
            Reservation::STATUS_EXPIRED_HOTEL => "Inquiry expired (hotel)",
            Reservation::STATUS_FINISHED => "Booking Finished",
        ];

    }

    public function getGenderText()
    {
        switch ($this->gender) {
            case 'm':
                return 'Male';
                break;
            case 'f':
                return 'Female';
                break;
            case 'o':
                return 'Other';
                break;
            default:
                return 'Not specified';
                break;
        }
    }

    public function getAsTimestamp($attr)
    {
        $c = Carbon::create($this->attributes[$attr])->midDay();
        return $c->toDateTimeString();
    }

    public function getRemainingHoursFromGenesisAttribute()
    {
        $c = $this->getAsTimestamp('checkin_date');
        return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(HOUR, created_at, "'.$c.'") AS hours')->get()->first()->hours;
    }

    public function getRemainingHoursFromNowAttribute()
    {
        return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(HOUR, NOW(), checkin_date) AS hours')->get()->first()->hours;
    }

    public function getRemainingMinutesFromNowAttribute()
    {
        // return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(MINUTE, NOW(), checkin_date) AS hours')->get()->first()->hours;

        $c = $this->getAsTimestamp('checkin_date');
        return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(MINUTE, created_at, "'.$c.'") AS minutes')->get()->first()->minutes;
    }

    public function getRemainingMinutesFromTimerAttribute()
    {
         return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(MINUTE, created_at, NOW()) AS minutes')
         ->get()->first()->minutes;
    }

    public function getRemainingSecondsFromTimerAttribute()
    {
         return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(SECOND, created_at, NOW()) AS seconds')
         ->get()->first()->seconds;
    }

    public function getRemainingMinutesDifferenceAttribute()
    {
         return DB::table('reservations')->where('id', $this->attributes['id'])->selectRaw('TIMESTAMPDIFF(HOUR, NOW(), checkin_date) AS minutes')->get()->first()->minutes;

    }

    public function getCheckinMdYAttribute()
    {
        return Carbon::create($this->attributes['checkin_date'])->midDay()->toFormattedDateString();
    }

    public function getCheckoutMdYAttribute()
    {
        return Carbon::create($this->attributes['checkout_date'])->midDay()->toFormattedDateString();
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price . ' ' . $this->currencySymbol;
    }

    public function setFormattedPriceAttribute($val)
    {
        $this->attributes['price'] = (float) $val * 100;
    }

    public function getCancelAttribute()
    {
        if ($this->remainingHoursFromNow > 0) {
            if ($this->remainingHoursFromNow > 48) {
                return 'free';
            } elseif ($this->remainingHoursFromNow > 24) {
                return 'non-free';
            }
        }
        return false;
    }

    public function saveStripeData($in)
    {
        $this->stripe_data = array_merge($this->stripe_data ?? [], $in, [
            'reservation_id'    => $this->attributes['id'],
            'reservation_uuid'  => $this->attributes['uuid']
        ]);
        $this->save();
    }

    public function checkAllReservations(){

        $reservationIncoming = $this::where('status', 0)->where('is_cancelled', 0)->whereRaw('Date(checkin_date) >= CURDATE()')->get();
        $reservationReminder= $this::where('status', 3)->where('is_cancelled', 0)->whereRaw('Date(checkin_date) >= CURDATE()')->get();
        $reservationFailedPayment= $this::where('status', 4)->where('is_cancelled', 0)->whereRaw('Date(checkin_date) >= CURDATE()')->get();
        $remain = [];

        foreach ($reservationIncoming as $value) {
            // İlk 24 saat cevapsız kalan reservation otele gönderilecek mail

            if ($value->getRemainingMinutesFromNowAttribute() > 0 || $value->getRemainingMinutesFromNowAttribute() == 1440 ) {

                $data = [
                    'name' => $value->main_guest,
                    'hotel_name' => $value->hotel->name,
                    'checkin' => $value->checkin_date->format('M d, Y'),
                    'checkout' => $value->checkin_date->format('M d, Y'),
                    'price' => \App\Helpers::localizedCurrency($value->hotel->price),
                    'route' => route('hotel_admin.reservations.show', $value->id),
                    'route_customer' => route('auth.reservation-status'),
                ];

                Notification::send($value->hotel, new IncomingBookingRequestFollowup($data));

            }

        }

        foreach ($reservationReminder as $value) {

            if ($value->getRemainingMinutesDifferenceAttribute() > 0 || $value->getRemainingMinutesDifferenceAttribute() == 1440 ) {

                $data = [
                    'name' => $value->main_guest,
                    'hotel_name' => $value->hotel->name,
                    'checkin' => $value->checkin_date->format('M d, Y'),
                    'checkout' => $value->checkin_date->format('M d, Y'),
                    'person' =>  $value->guest_adult,
                    'children' =>  $value->guest_child,
                    'price' => \App\Helpers::localizedCurrency($value->hotel->price),
                    'route' => route('hotel_admin.reservations.show', $value->id),

                ];

                // hotel reminder mail

                Notification::send($value->hotel, new GuestReminder($data));

            }
        }

        // foreach ($reservationFailedPayment as $value) {
            // Başarısız ödeme hatırlatması - View yok, eklenecek.

            // if ($value->getRemainingMinutesFromNowAttribute() > 0 || $value->getRemainingMinutesFromNowAttribute() == 1440 ) {

            //     $data = [
            //         'name' => $value->main_guest,
            //         'hotel_name' => $value->hotel->name,
            //         'checkin' => $value->checkin_date->format('M d, Y'),
            //         'checkout' => $value->checkin_date->format('M d, Y'),
            //         'price' => \App\Helpers::localizedCurrency($value->hotel->price),
            //         'route' => route('hotel_admin.reservations.show', $value->id),
            //         'route_customer' => route('auth.reservation-status'),
            //     ];

            //     Notification::send($value->hotel, new IncomingBookingRequestFollowup($data));

            // }

        // }



       return "Check reservations success";


    }


}
