<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\DeclinedConfirmation;
use App\Notifications\ApprovalConfirmation;
use App\Notifications\DeclinedConfirmationHotel;
use App\Notifications\ApprovalConfirmationHotel;
use Illuminate\Support\Facades\Notification;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:hotel'])->only(
            [
                'edit',
                'save',
            ]);
    }


    public function index()
    {
        return view('hotel_admin.modules.reservations.index');
    }

    public function indexAjax(Request $request)
    {
        $user = Auth::guard('user')->user();
        $status = $request->status;
        $query = $user->hotel_reservations()->orderByRaw(\DB::raw("FIELD(status , '0', '4', '3','1', '2', '5', '6', '7', '8', '9')"))->orderBy('created_at', 'desc')->get();;
        if (!empty($status)) {
            $query->where('status', $status);
        }
        return datatables()->of($query)->only(
            [
                'id',
                'hotel',
                'user',
                'checkin_date',
                'checkout_date',
                'status',
                'guest_adult',
                'guest_child',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'hotel', 'user', 'action', 'status'])
            ->addColumn(
                'hotel', function (Reservation $data) {
                $hotel = $data->hotel()->get()->first();
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="info p-l-0">
                                <span class="title">' . $hotel->name . '</span>
                                <span class="sub-title">Star: ' . $hotel->getStar() . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'user', function (Reservation $data) {
                $user = $data->customer()->get()->first();
                $profile_image = $user->getMedia('profile_image')->first();
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="media-img">
                                <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                            </div>
                            <div class="info">
                                <span class="title">' . ((empty($user->firstname) || empty($user->lastname)) ? $user->username : ($user->firstname . ' ' . $user->lastname)) . '</a></span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'id', function (Reservation $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'status', function (Reservation $data) {
                // return $data->getStatusByCode($data->status);
                switch ($data->status) {
                    case '0':
                        return "
                        <span class='dot waitingStatus'></span>
                        <span class='waitingText'>". trans('txt.waiting') ."</span>
                        ";
                        break;
                    case '1':
                        return '
                        <span class="dot approvedStatus"></span>
                        <span class="approvedText">'. trans('txt.approved') .'</span>
                        ';
                        break;
                    case '2':
                        return '
                        <span class="dot cancelledStatus"></span>
                        <span class="cancelledText">'. trans('txt.declined') .'</span>
                        ';
                        break;
                    case '3':
                        return '
                        <span class="dot approvedStatus"></span>
                        <span class="approvedText">'. trans('txt.paid') . '</span>
                        ';
                        break;
                    case '4':
                        return '
                        <span class="dot cancelledStatus"></span>
                        <span class="cancelledText">'. trans('txt.payment_error') .'</span>
                        ';
                        break;
                    case '5':
                        return '
                        <span class="dot cancelledStatus"></span>
                        <span class="cancelledText">'. trans('txt.user-canceled-after-expiration') .'</span>
                        ';
                        break;
                    case '6':
                        return '
                        <span class="dot cancelledStatus"></span>
                        <span class="cancelledText">'. trans('txt.user-canceled-before-expiration') .'</span>
                        ';
                        break;
                    case '7':
                        return '
                        <span class="dot cancelledStatus"></span>
                        <span class="cancelledText">' . trans('txt.res_expired_customer') .'</span>
                        ';
                        break;
                    case '8':
                        return '
                        <span class="dot cancelledStatus"></span>
                        <span class="cancelledText">'. trans('txt.res_expired_hotel') .'</span>
                        ';
                        break;
                    case '9':
                        return '
                        <span class="dot approvedStatus"></span>
                        <span class="approvedText">' .trans('txt.res_finished') .'</span>
                        ';
                        break;

                }
            })
            ->addColumn(
                'checkin_date', function (Reservation $data) {
                if (!empty($data->checkin_date)) {
                    $checkin_date = $data->checkin_date->format('d-m-Y');
                } else {
                    $checkin_date = "";
                }
                return ($checkin_date);
            })
            ->addColumn(
                'checkout_date', function (Reservation $data) {
                if (!empty($data->checkout_date)) {
                    $checkout_date = $data->checkout_date->format('d-m-Y');
                } else {
                    $checkout_date = "";
                }
                return ($checkout_date);
            })
            ->addColumn(
                'action', function (Reservation $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('hotel_admin.reservations.show', $data->id) . '" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Show"><i class="ti-eye"></i></a>';

//                $action .= '<a href="#" onclick="return confirm(\'Are you sure you want to reject it?\');" class="btn btn-danger ' . (($data->getStatusShortcode($data->reason_id) != "waiting") ? 'disabled' : '') . '" title="Reject"><i class="ti-na"></i></a>';
//                $action .= '<a href="#" onclick="return confirm(\'Are you sure you want to approve it?\');" class="btn btn-success ' . (($data->getStatusShortcode($data->reason_id) != "waiting") ? 'disabled' : '') . '" title="Approve"><i class="ti-check"></i></a>';
                $action .= '</div>';

                return $action;
            })->toJson();
    }

    public function show($id)
    {
        $data = Reservation::findOrFail($id);

        return view('hotel_admin.modules.reservations.show', compact('data'))->render();
    }

    public function edit($id)
    {
        $data = Reservation::findOrFail($id);
        return view('hotel_admin.modules.reservations.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = Reservation::findOrFail($id);
        $oldData = $updateData->toArray();
        $attributes = [
            'hotel_id' => 'Hotel',
            'customer_id' => 'Customer',
            'checkin_date' => 'Checkin Date',
            'checkout_date' => 'Checkout Date',
            'status' => 'Status',
            'guest_adult' => 'Guest Adult',
            'guest_child' => 'Guest Child',
            'main_guest' => 'Main Guest',
            'email' => 'Email',
            'phone' => 'Phone',
            'dob' => 'Dob',
            'gender' => 'Gender',
            'reason_id' => 'Rejection Reasons',
            'other_reason' => 'Other Reason',
            'comments' => 'Comments',
        ];
        $messages = [];
        $rules = [
//            'hotel_id' => 'required|min:1',
//            'customer_id' => 'required|min:1',
            'checkin_date' => 'required|min:1',
            'checkout_date' => 'required|min:1',
            'status' => 'required|min:1',
            'guest_adult' => 'required|min:1',
            'guest_child' => 'required|min:1',
            'main_guest' => 'required|min:1',
            'email' => 'required|min:1',
            'phone' => 'required|min:1',
            'dob' => 'min:1',
            'gender' => 'min:1',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
//        $updateData->hotel_id = $request->hotel_id;
//        $updateData->customer_id = $request->customer_id;
        $updateData->checkin_date = $request->checkin_date;
        $updateData->checkout_date = $request->checkout_date;
        $updateData->status = $request->status;
        $updateData->guest_adult = $request->guest_adult;
        $updateData->guest_child = $request->guest_child;
        $updateData->main_guest = $request->main_guest;
        $updateData->email = $request->email;
        $updateData->phone = $request->phone;
        $updateData->dob = $request->dob;
        $updateData->gender = $request->gender;
        $updateData->reason_id = $request->reason_id;
        $updateData->other_reason = $request->other_reason;
        $updateData->comments = $request->comments;

        $save = $updateData->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function setReservationStatus(Request $request)
    {
        $reservationId = $request->reservationId;
        $status = $request->status;
        $reservation = Reservation::findOrFail($reservationId);

        $hotel = $reservation->hotel;


        // Accept-Rejected Email data

        $data = [
            'name' => $reservation->main_guest,
            'hotel_name' => $hotel->name,
            'checkin' => $reservation->checkin_date->format('M d, Y'),
            'checkout' => $reservation->checkout_date->format('M d, Y'),
            'checkin_customer' => $reservation->checkin_date->format('d M Y'),
            'checkout_customer' => $reservation->checkout_date->format('d M Y'),
            'day_named_date' => \Carbon\Carbon::now()->format('l, d M Y'),
            'person' =>  $reservation->guest_adult,
            'children' =>  $reservation->guest_child,
            'code' =>  $reservation->id,
            'price' => \App\Helpers::localizedCurrency($hotel->price),
            'price_total' => \App\Helpers::localizedCurrency($reservation->price),
            'route' => route('hotel_admin.reservations.show', $reservation->id),
            'route_customer' => route('f.detail', ['id' => $hotel->id, 'slug' => $hotel->slug]),
            'route_destinations' => route('f.destinations'),
            'route_paynow' => route('auth.pay-now'),
            'lang' => $reservation->customer->language
        ];

        // Accept-Rejected Email data

        if (($status == 1 || $status == 2) && !empty($reservationId)) {
            $rejectDesc = null;
            $rejectVal = null;
            if ($status == 2) {
                $rejectVal = $request->rejectVal;
                $rejectDesc = $request->rejectDesc;

                if ((empty($rejectVal))) {
                    $alert = [
                        'alert' => [
                            'status' => 'danger',
                            'message' => trans('txt.reservation_cancel_error')
                        ]
                    ];
                    return redirect()->back()->with($alert);
                }

            }
            $reservation->setStatus($status);
            $reservation->setOtherReason($rejectDesc);
            $reservation->setReason($rejectVal);
            $reservation->save();

            // Email Notifications

            if ($status == 1) {
                Notification::send($reservation->customer, new ApprovalConfirmation($data)); //To Customer
                Notification::send($hotel->hotel_user, new ApprovalConfirmationHotel($data)); //To Hotel
            }elseif($status == 2){
                Notification::send($reservation->customer, new DeclinedConfirmation($data)); //To Customer
                Notification::send($hotel->hotel_user, new DeclinedConfirmationHotel($data)); //To Hotel
            }

            // Email Notifications

            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => trans('txt.reservation_approve_success')
                ]
            ];

            return redirect()->back()->with($alert);
        }
        $alert = [
            'alert' => [
                'status' => 'danger',
                'message' => __('txt.error_one')
            ]
        ];

        return redirect()->back()->with($alert);
    }


}
