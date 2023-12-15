<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Models\Hotels;
use App\Models\HotelUnavailableDates;
use App\Models\Reservation;
use App\Notifications\JoinForFree;
use App\Notifications\JoinForFreeAdmin;
use App\Notifications\TestNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class GeneralController extends Controller
{

    public function __construct()
    {
    }

    public function detail($slug, $id)
    {
        $hotel = Hotels::findOrFail($id);

        $unavailableDates = HotelUnavailableDates::where('hotel_id',  $hotel->id)->get();

        $dates = array();

        foreach ($unavailableDates as $value) {
            $date = Carbon::parse($value->date);
            array_push($dates, $date->format('Y-m-d'));
         }

         $customer = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        if ($hotel) {
            return view('front.details', compact('hotel', 'dates'));
        }
        return view('front.details');
    }

    public function hotelPreview($slug, $id)
    {
        $hotel = Hotels::findOrFail($id);

        $unavailableDates = HotelUnavailableDates::where('hotel_id',  $hotel->id)->get();

        $dates = array();

        foreach ($unavailableDates as $value) {
            $date = Carbon::parse($value->date);
            array_push($dates, $date->format('Y-m-d'));
         }

         $customer = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        if ($hotel) {
            return view('front.details-preview', compact('hotel', 'dates'));
        }
        return view('front.details');
    }

    public function joinForFree()
    {
        $jffCouponRule = settings()->get('jff_coupon_rule');
        $jffAdminEmail = settings()->get('jff_admin_email', 'contact@migodahotels.com');

        $mailData = array();
        $sendedCoupons = array();
        if (
            isset($_POST['fullName']) &&
            isset($_POST['email']) &&
            isset($_POST['hotelName']) &&
            isset($_POST['hotelAddress']) &&
            isset($_POST['phone']) &&
            isset($_POST['website']) &&
            isset($_POST['language'])
        ) {
            if (
                !empty($_POST['fullName']) &&
                !empty($_POST['email']) &&
                !empty($_POST['hotelName']) &&
                !empty($_POST['hotelAddress']) &&
                !empty($_POST['phone']) &&
                !empty($_POST['website']) &&
                !empty($_POST['language']) &&
                !empty($jffCouponRule)
            ) {
                $couponCodes = CouponCode::where('rule_id', $jffCouponRule)->where('email_send', 0)->whereNull('coupon_usage_id')->limit(3)->get();

                $mailData['fullName'] = $_POST['fullName'];
                $mailData['email'] = $_POST['email'];
                $mailData['hotelName'] = $_POST['hotelName'];
                $mailData['hotelAddress'] = $_POST['hotelAddress'];
                $mailData['phone'] = $_POST['phone'];
                $mailData['website'] = $_POST['website'];
                $mailData['language'] = $_POST['language'];

                foreach ($couponCodes as $code) {
                    CouponCode::where('id', $code->id)->update(['email_send' => 1]);
                    $sendedCoupons[] = $code->code;
                }

                if (count($sendedCoupons) > 0) {
                    $mailData['coupons'] = $sendedCoupons;
                    Notification::route('mail', $mailData['email'])->notify(new JoinForFree($mailData));
                    Notification::route('mail', $jffAdminEmail)->notify(new JoinForFreeAdmin($mailData));

                    header('Location: https://migodahotels.com/panel/signup.php?message=success&lang='.$mailData['language']);
                    exit;
                }else {
                    header('Location: https://migodahotels.com/panel/signup.php?message=error&lang='.$mailData['language']);
                    exit;
                }
            }
        }

    }

    public function testFunction(Request $request){


        //    Notification::send($customer, new TestNotifications("fake data"));

        return view('emails.en.join-for-free');


        // data for paid and payment sent mail

        // $data = [
        //     'name' => $value->name,
        //     'checkin' => $value->checkin,
        //     'checkout' => $value->checkout,
        //     'route' =>  route('hotel_admin.reservations.show', $value->name),
        //     'res_id' => $value->id,
        // ];


        // data for reservation overview mail - invoice // listener içerisinde mail gönderimi yapılacak. Listenerlar hazırlanacak.


        // $data = [
        //     'name' => "customer",
        //     'hotel_name' => $payments->hotel->name,
        //     'checkin' => $dateCheckin->format('M d, Y'),
        //     'checkout' => $dateCheckout->format('M d, Y'),
        //     'checkin_customer' => $dateCheckin->format('d M Y'),
        //     'checkout_customer' => $dateCheckout->format('d M Y'),
        //     'day_named_date' => \Carbon\Carbon::now()->format('l, d M Y H:i:s'), // timestamp for payment date
        //     'person' =>  $guestAdult,
        //     'children' =>  $guestChild,
        //     'code' =>  $reservation->id,
        //     'nights' =>  $nightsCalculated,
        //     'hotelAddress' =>  $address,
        //     'price' => \App\Helpers::localizedCurrency($hotel->price),
        //     'price_total' => \App\Helpers::localizedCurrency($price),
        //     'route' => route('hotel_admin.reservations.show', $reservation->id),
        //     'route_customer' => route('auth.reservation-status'),
        //     'map_address' => mapaddress gelecek.
        // ];


    }
}
