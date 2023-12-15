<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Hotels;
use App\Models\HotelUnavailableDates;
use DateTime;
use DatePeriod;
use DateInterval;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        $isRegister = $user->isRegister;
        $hotels = $user->hotels()->first();
        $isVerified = $hotels->is_verified;

        $hotelName = $hotels->name;

        return view('hotel_admin.modules.dashboard.index', compact('isRegister','isVerified','hotelName'))->render();
    }

    public function calendar()
    {
        $hotelUser = Auth::guard('user')->user();
        $hotelId = Hotels::where('user_id', $hotelUser->id)->select('id')->first();
        $unavailableDates = HotelUnavailableDates::where('hotel_id', $hotelId->id)->get();
        $reservations = $hotelUser->hotel_reservations()->whereIn('status', [Reservation::STATUS_PAID, Reservation::STATUS_APPROVED])->get();
        return view('hotel_admin.modules.dashboard.calendar', compact('reservations', 'unavailableDates'))->render();
    }

    public function setUnavailableDates(Request $request){

        $start = new DateTime($request->start_date);
        $due = new DateTime($request->due_date);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $due);
        $dates = array();

        if ($request->start_date == $request->due_date) {
            array_push($dates, array($start->format("Y-m-d H:i:s")));
        }else{
            foreach ($period as $dt) {
                array_push($dates, array($dt->format("Y-m-d H:i:s")));
             }
             array_push($dates, array($due->format("Y-m-d H:i:s")));

        }

        $setDates = new Hotels;
        $setDates->setUnavailableDatesHotel($dates);

        if (!$setDates) {
            $alert = [
                'alert' => [
                    'status' => 'error',
                    'message' => trans('txt.hotel_calendar_alert_message')
                ]
            ];

            return redirect()->back()->with($alert);
        }else{
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => trans('txt.hotel_calendar_alert_message')
                ]
            ];

            return redirect()->back()->with($alert);

        }
    }
}
