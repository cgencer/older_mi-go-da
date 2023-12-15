<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\ReservationController;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CouponCode;
use App\Models\CouponUsage;
use App\Models\Customers;
use App\Models\Payments;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CancelBefore;
use App\Notifications\CancelAfter;
use App\Notifications\CancelBeforeCustomer;
use App\Notifications\CancelAfterCustomer;
use App\Notifications\Invoice;
use App\Notifications\PaymentSent;
use App\Notifications\PaymentFailed;
use App\Notifications\Paid;
use App\Models\Hotels;
use App\Models\User;
use Stripe\Customer;
use Illuminate\Support\Str;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'add',
                'edit',
                'save',
                'remove',
                'setReservationStatus',
            ]);
    }


    public function index()
    {
        return view('admin.modules.reservations.index');
    }

    public function indexAjax(Request $request)
    {
        $query = Reservation::query();

        if ($request->search != null) {
            $search = $request->search['value'];
            $converted = Str::substr($search, 0, 2);
            $getHotelSearch = Str::of($search)->explode('-');

            if ($converted == "H-" && isset($getHotelSearch[1])) {
                $query->where(function ($query) {
                    $query->select('id')
                        ->from('hotels')
                        ->whereColumn('hotel_id', 'hotels.id');
                }, $getHotelSearch[1]);
            } else {
                $query->where('id', $search);
            }

            $query->orWhere(function ($query) {
                $query->select('firstname')
                    ->from('customers')
                    ->whereColumn('customer_id', 'customers.id');
            }, 'LIKE', '%' . $search . '%');

            $query->orWhere(function ($query) {
                $query->select('email')
                    ->from('customers')
                    ->whereColumn('customer_id', 'customers.id');
            }, 'LIKE', '%' . $search . '%');

            $query->orWhere(function ($query) {
                $query->select('name')
                    ->from('hotels')
                    ->whereColumn('hotel_id', 'hotels.id');
            }, 'LIKE', '%' . $search . '%');


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
                'created_at',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'hotel', 'user', 'action'])
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
                $profile_image = $user->getProfileImageAttribute();
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="media-img">
                                <a href="' . (route('admin.users.edit', ['id' => $user->id])) . '">
                                    <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                                </a>
                            </div>
                            <div class="info">
                                <span class="title"><a href="' . (route('admin.customers.edit', ['id' => $user->id])) . '">' . ((empty($user->firstname) || empty($user->lastname)) ? $user->username : ($user->firstname . ' ' . $user->lastname)) . '</a></span>
                                <span class="sub-title">ID: ' . $user->id . '</span>
                                <span class="sub-title">Username: ' . ($user->username) . '</span>
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
                return $data->getStatusByCode($data->status);
            })
            ->addColumn(
                'created_at', function (Reservation $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'updated_at', function (Reservation $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'checkin_date', function (Reservation $data) {
                if (!empty($data->created_at)) {
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

                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', \Carbon\Carbon::now());
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $data->checkin_date);


                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.reservations.show', $data->id) . '" class="btn btn-primary" title="Show"><i class="ti-eye"></i></a>';
                $action .= '<a href="' . route('admin.reservations.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';

                if (!empty($data->payments) && in_array($data->payments->proccess_status, ['authed', 'charged', 'proced', 'fees', 'nofees', 'sub2', 'sub7', 'paid']) && $to > $from) {
                    if ($to->diffInHours($from) > 48 && $to > $from && $data->is_cancelled == 0) {
                        $action .= '<a data-set="' . $to->diffInHours($from) . '"   href="' . route('admin.reservations.cancel', $data->id) . '" onclick="return confirm(\'Are you sure you want to cancel it?\');" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Cancel Reservation"><i class="fa fa-window-close"></i></a>';
                    } else {
                        $action .= '<a data-set="' . $to->diffInHours($from) . '" href="" class="btn btn-secondary disabled" disabled="disabled" ><i class="fa fa-window-close"></i></a>';
                    }
                }
//                $action .= '<a href="' . route('admin.reservations.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('user', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('username')
                        ->from('customers')
                        ->whereColumn('customer_id', 'customers.id')
                        ->limit(1);
                }, $order);
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('updated_at', $order);
            })
            ->orderColumn('checkin_date', function ($query, $order) {
                $query->orderBy('checkin_date', $order);
            })
            ->orderColumn('checkout_date', function ($query, $order) {
                $query->orderBy('checkout_date', $order);
            })
            ->toJson();
    }

    public function show($id)
    {
        $data = Reservation::findOrFail($id);

        return view('admin.modules.reservations.show', compact('data'))->render();
    }

    public function testing(Request $request)
    {
        $reservation = Reservation::findOrFail($request->id);

        $reservation->status = $request->status;

        $reservation->save();

        $date1 = new \DateTime($reservation->checkin_date);
        $date2 = new \DateTime($reservation->checkout_date);
        $nightsDays = $date2->diff($date1)->format("%a");

        $data = [
            'name' => $reservation->main_guest,
            'res_id' => $reservation->id,
            'nights' => $nightsDays,
            'hotel' => $reservation->hotel->name,
            'checkin' => $reservation->checkin_date->format('M d, Y'),
            'checkout' => $reservation->checkout_date->format('M d, Y'),
            'day_named_date' => \Carbon\Carbon::now()->format('l, d M Y'),
            'person' => $reservation->guest_adult,
            'children' => $reservation->guest_child,
            'code' => $reservation->id,
            'price' => \App\Helpers::localizedCurrency($reservation->hotel->price),
            'price_total' => \App\Helpers::localizedCurrency($reservation->price),
            'route' => route('hotel_admin.reservations.show', $reservation->id),
            'route_customer' => route('auth.reservation-status'),
            'hotel_address' => $reservation->hotel->address,
            'price_tax' => "15"
        ];


        if ($reservation->status == 3) {

            Notification::send($reservation->customer, new Invoice($data));
            Notification::send($reservation->hotel->hotel_user, new Paid($data));

            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Kullanıcı ödeme yapıldı maili gönderildi'
                ]
            ];

            return redirect()->back()->with($alert);
        } else if ($reservation->status == 4) {

            Notification::send($reservation->customer, new PaymentFailed($data));

            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Kullanıcı ödeme başarısız maili gönderildi'
                ]
            ];

            return redirect()->back()->with($alert);

        } else {

            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Bu Statuse ait bir test maili gönderilemez.'
                ]
            ];

            return redirect()->back()->with($alert);
        }

        // return view('admin.modules.reservations.show', compact('data'))->render();
    }


    public function edit($id)
    {
        $data = Reservation::findOrFail($id);
        return view('admin.modules.reservations.edit', compact('data'))->render();
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
        if (($status == 1 || $status == 2) && !empty($reservationId)) {
            $rejectDesc = null;
            $rejectVal = null;
            if ($status == 2) {
                $rejectVal = $request->rejectVal;
                $rejectDesc = $request->rejectDesc;
                if ((empty($rejectVal) && empty($rejectDesc)) || (!is_int($rejectVal) && empty($rejectDesc))) {
                    $alert = [
                        'alert' => [
                            'status' => 'danger',
                            'message' => 'Lütfen uygun bir onaylanmama sebebi seçiniz.'
                        ]
                    ];
                    return redirect()->back()->with($alert);
                }
            }
            $reservation = Reservation::findOrFail($reservationId);
            $reservation->setStatus($status);
            $reservation->setOtherReason($rejectDesc);
            $reservation->setReason($rejectVal);
            $reservation->save();

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

    public function cancelReservation($id, Request $request)
    {
        $data = Reservation::findOrFail($id);
        $hotel = Hotels::where('id', $data->hotel_id)->get()->first();

        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', \Carbon\Carbon::now());
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $data->checkin_date);

        if ($to->diffInHours($from) > 48 && $to > $from) {

            $frontReservations = new ReservationController();

            $doCancel = $frontReservations->doCancel($data->uuid);

            if (!$doCancel) {
                $alert = [
                    'alert' => [
                        'status' => 'error',
                        'message' => "Payment cancel error."
                    ]
                ];

                return redirect()->back()->with($alert);

            }

            // Grace Period Before - Refund Coupons !TO-DO -> Payment Refunds
            $couponUsage = CouponUsage::where('reservation_id', $id)->get();

            foreach ($couponUsage as $value) {
                $value->reservation_id = null;
                $value->save();
            }
            //Hotel Mail Before
            $mailData = [
                'checkin_date' => \Carbon\Carbon::parse($data->checkin_date)->format('d M Y'),
                'checkout_date' => \Carbon\Carbon::parse($data->checkout_date)->format('d M Y'),
                'guest_name' => $data->main_guest,
                'url' => "https://migoda.com/hotel/payments"
            ];

            //Customer Mail Before
            $mailDataCustomer = [
                'reference_code' => $data->id,
                'lang' => $data->customer->language
            ];


            Notification::send($hotel->hotel_user, new CancelBefore($mailData));
            Notification::send($data->customer, new CancelBeforeCustomer($mailDataCustomer));


        } else {
            //Hotel Mail After - No payment refunds.

            $mailData = [
                'checkin_date' => \Carbon\Carbon::parse($data->checkin_date)->format('d M Y'),
                'checkout_date' => \Carbon\Carbon::parse($data->checkout_date)->format('d M Y'),
                'guest_name' => $data->main_guest,
                'amount' => \App\Helpers::localizedCurrency($data->payments->packet['metadata']['fees']['hotel'] / 100),
                'refund_date' => \Carbon\Carbon::parse($data->checkin_date)->format('d, m Y'),
                'url' => "https://migoda.com/hotel/payments",


            ];

            //Customer Mail After
            $mailDataCustomer = [
                'reference_code' => $data->id,
                'lang' => $data->customer->language
            ];

            Notification::send($hotel->hotel_user, new CancelAfter($mailData));
            Notification::send($data->customer, new CancelAfterCustomer($mailDataCustomer));


        }

        $data->is_cancelled = 1;
        $data->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => "Reservation cancelled successfully. "
            ]
        ];

        return redirect()->back()->with($alert);
    }
}
