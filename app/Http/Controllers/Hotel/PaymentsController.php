<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hotels;
use App\Models\Customers;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
        return view('hotel_admin.modules.payments.index');
    }

    public function indexAjax(Request $request)
    {

        $userID = Auth::guard('user')->user()->id;
        $getHotel = Hotels::where('user_id', $userID)->first();

        $query = DB::table('payments')->where('hotel_id', $getHotel->id);
        return DataTables()->queryBuilder($query)->only(
            [
                'id',
                'customer_id',
                'reservation_id',
                'checkin_date',
                'nights',
                'status',
                'payout_date',
                'meal_offer',
                'charge_collection_fees',
                'migoda_comission_fees',
                'VAT',
                'payout_amount',
                'stripe_payout_id',
                'receipt',

            ])->startsWithSearch()->escapeColumns()->rawColumns(['id',  'customer_id', 'reservation_id', 'checkin_date', 'nights', 'status', 'payout_date', 'status', 'meal_offer' ,'charge_collection_fees', 'migoda_comission_fees', 'VAT', 'payout_amount', 'stripe_payout_id', 'receipt'])
            ->editColumn(
                'customer_id', function  ($data) {
                $user = Customers::where('id', $data->customer_id)->get()->first();
                return '<div class="list-media">
                         <div class="list-item">
                             <div class="info p-l-0">
                                 <span class="title">' . $user->firstname . ' ' . $user->lastname . '</span>
                             </div>
                         </div>
                     </div>';
            })
            ->editColumn(
                'reservation_id', function ($data) {
                $reservation = Reservation::where('id', $data->reservation_id)->get()->first();
                return '<div class="list-media">
                         <div class="list-item">
                             <div class="info p-l-0">
                                 <span class="title"> <a target="_blank" href="'.(route('hotel_admin.reservations.show', ['id' => $data->reservation_id])).'"> Main Guest: ' . $reservation->main_guest . '</a></span>
                                 <span class="sub-title">Reservation ID: ' . $reservation->id . '</span>
                             </div>
                         </div>
                     </div>';
            })
            ->editColumn(
                'checkin_date', function ($data) {
                $reservation = Reservation::where('id', $data->reservation_id)->get()->first();

                return $reservation->checkin_date->format('d-m-Y');

            })

            ->editColumn(
                'nights', function ($data) {
                    $reservation = Reservation::where('id', $data->reservation_id)->get()->first();
                    $date1 = new \DateTime($reservation->checkin_date);
                    $date2 = new \DateTime($reservation->checkout_date);
                    $nightsDays = $date2->diff($date1)->format("%a");

                 return ($nightsDays);

            })
            ->editColumn(
                'status', function ($data) {

                $status = "";
                switch ($data->proccess_status) {
                    case 'succeeded':
                        $status = "Succeeded";
                        break;
                    case 'holded':
                        $status = "Waiting";
                        break;
                    case 'preflight':
                        $status = "Waiting";
                        break;
                    case 'cancel-grace':
                        $status = "Cancelled - Grace Period";
                        break;
                    case 'cancel-halfpay':
                        $status = "Cancelled (%50 Payout) ";
                        break;

                }

                return '<div class="list-media">
                    <div class="list-item">
                        <div class="info p-l-0">
                        <span class="title text-capitalize">'. $status . '</span>
                        </div>
                    </div>
                </div>';

            })
            ->editColumn(
                'payout_date', function ($data) {
                 $details = json_decode($data->packet, true);
                 return  date("d-m-Y", strtotime($details['metadata']['checkin']));


            })
            ->editColumn(
                'meal_offer', function ($data) {
                $hotels = Hotels::where('id', $data->hotel_id)->get()->first();


                return \App\Helpers::localizedCurrency($hotels->price /100);


            })
            ->editColumn(
                'charge_collection_fees', function ($data) {
                $details = json_decode($data->packet, true);

                return    \App\Helpers::localizedCurrency($details['metadata']['fees']['stripe'] /100);


            })
            ->editColumn(
                'migoda_comission_fees', function ($data) {
                    $details = json_decode($data->packet, true);

                return    \App\Helpers::localizedCurrency($details['metadata']['fees']['migoda'] /100);

            })
            ->editColumn(
                'VAT', function ($data) {
                //  $details = json_decode($data->packet, true);

                //  return $details['charges']['data']['payment_method_details']['card']['network'];

            return "-";

            })
            ->editColumn(
                'payout_amount', function ($data) {
                $details = json_decode($data->packet, true);

               return \App\Helpers::localizedCurrency($details['charges']['data']['amount'] /100);


            })
            ->editColumn(
                'stripe_payout_id', function ($data) {
                 $details = json_decode($data->packet, true);

                 return $details['charges']['data']['id'];

            })
            ->editColumn(
                'receipt', function ($data) {
                //  $details = json_decode($data->packet, true);

                //  return $details['charges']['data']['payment_method_details']['card']['network'];

            return "-";

            })
            ->orderColumn('reservation_id', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('name')
                        ->from('reservations')
                        ->whereColumn('reservation_id', 'reservations.id')
                        ->limit(1);
                }, $order);
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->toJson();
    }


    public function show($id)
        {
            $data = Payments::findOrFail($id);
            return view('admin.modules.payments.show', compact('data'))->render();
        }
    /*public function show($id)
        {
            $data = Reservation::findOrFail($id);

            return view('admin.modules.reservations.show', compact('data'))->render();
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

        public function remove($id)
        {
            if (Reservation::destroy($id)) {
                $alert = [
                    'alert' => [
                        'status' => 'success',
                        'message' => 'Deleted!'
                    ]
                ];

                return redirect(route('admin.reservations.index'))->with($alert);
            } else {
                $alert = [
                    'alert' => [
                        'status' => 'danger',
                        'message' => __('txt.error_one')
                    ]
                ];

                return redirect(route('admin.reservations.index'))->with($alert);
            }
        }*/
}
