<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Hotels;
use App\Models\Payments;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Yajra\DataTables\DataTables;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'add',
                'edit',
                'save',
                'remove',
            ]);
    }


    public function index()
    {
        return view('admin.modules.payments.index');
    }

    public function indexAjax(Request $request)
    {


        $query = DB::table('payments');

        if ($request->filter == 1) {

            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $platform = $request->platform;
            $status = $request->status;
            $country = $request->country;
            $search = $request->searchBox;


            if (isset($request->start_date) && isset($request->end_date)) {
                $query-> whereBetween('created_at', [$start_date, $end_date]);
            }

            if (isset($request->country)) {
                $query-> whereIn('country_id', $country);
            }

            if (isset($request->platform)) {
                $query->where('platform', '=', $platform);
            }

            if (isset($request->status)) {
                $query->whereIn('proccess_status', $status);
            }

            if (isset($request->searchBox)) {
                $query->where(function ($query) {
                    $query->select('firstname')
                        ->from('customers')
                        ->whereColumn('customer_id', 'customers.id');
                }, 'LIKE', '%' . $search . '%');

                $query->orWhere(function ($query) {
                    $query->select('name')
                        ->from('hotels')
                        ->whereColumn('hotel_id', 'hotels.id');
                }, 'LIKE', '%' . $search . '%');

            }

        }


        return DataTables()->queryBuilder($query)->only(
            [
                'id',
                'reservation_id',
                'customer_id',
                'number_of_guests',
                'payment_date',
                'hotel_id',
                'status',
                'platform',
                'payment_amount',
                'payment_type',
                'card_type',
                'actions'


            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'reservation_id', 'customer_id', 'number_of_guests', 'payment_date', 'hotel_id', 'status', 'platform', 'payment_amount', 'payment_type', 'card_type', 'actions'])

            ->editColumn(
                'reservation_id', function ($data) {
                $reservation = Reservation::where('id', $data->reservation_id)->get()->first();
                return '<div class="list-media">
                         <div class="list-item">
                             <div class="info p-l-0">
                                 <span class="sub-title">Reservation ID: ' . $reservation->id . '</span>
                             </div>
                         </div>
                     </div>';
            })
            ->editColumn(
                'customer_id', function  ($data) {
                $user = Customers::where('id', $data->customer_id)->get()->first();

                return '<div class="list-media">
                         <div class="list-item">
                             <div class="info p-l-0">
                                 <span class="title"> <a target="_blank" href="'.(route('admin.customers.edit', ['id' => $data->customer_id])).'">' . $user->firstname . ' ' . $user->lastname . '</a></span>
                             </div>
                         </div>
                     </div>';
            })
            ->addColumn(
                'number_of_guests', function ($data) {
                $reservation = Reservation::where('id', $data->reservation_id)->get()->first();
                return '<div class="list-media">
                         <div class="list-item">
                             <div class="info p-l-0">
                                 <span class="title">Adult: ' . $reservation->guest_adult . '</span>
                                 <span class="title">Children: ' . ($reservation->guest_children > 0 ? $reservation->guest_children : '-' ). '</span>
                             </div>
                         </div>
                     </div>';
            })
            ->addColumn(
                'payment_date', function ($data) {
                if (!empty($data->created_at)) {
                    $created_at = date('d-m-Y H:i:s',strtotime($data->created_at)) ;
                } else {
                    $created_at = "-";
                }
                return ($created_at);

            })
            ->editColumn(
                'hotel_id', function ($data){

                $hotels = Hotels::where('id', $data->hotel_id)->get()->first();

                return '<div class="list-media">
                         <div class="list-item">
                             <div class="info p-l-0">
                                 <span class="title"> <a target="_blank" href="'.(route('admin.hotels.edit', ['id' => $data->hotel_id])).'">' . $hotels->name . '</a></span>
                                 <span class="sub-title">Hotel ID: ' . $hotels->id . '</span>

                             </div>
                         </div>
                     </div>';
            })
            ->editColumn(
                'status', function ($data) {
                $details = json_decode($data->packet, true);

                return '<div class="list-media">
                <div class="list-item">
                    <div class="info p-l-0">
                        <span class="title text-capitalize">'. str_replace('_', ' ', $data->proccess_status) . '</span>
                        <span class="sub-title text-capitalize">' . str_replace('_', ' ', $details['charges']['data']['status']). '</span>
                    </div>
                </div>
            </div>';
            })
            ->editColumn(
                'platform', function ($data) {

                return '<div class="list-media">
                <div class="list-item">
                    <div class="info p-l-0">
                        <span class="title text-capitalize">'. $data->platform . '</span>
                    </div>
                </div>
            </div>';
            })
            ->addColumn(
                'payment_amount', function ($data) {

                return \App\Helpers::localizedCurrency($data->amount/100);
            })
            ->addColumn(
                'payment_type', function ($data) {

                 $details = json_decode($data->packet, true);

                $secureErrors = "";
                 if ($details['charges']['data']['paid'] != true) {
                        $secureErrors = $details['charges']['data']['payment_method_details']['card']['cvc_check'];
                 }

                return '<div class="list-media">
                <div class="list-item">
                    <div class="info p-l-0">
                        <span class="title text-capitalize">'. $details['charges']['data']['payment_method_details']['type']. '</span>
                        <span class="sub-title text-capitalize">' . $secureErrors . '</span>
                    </div>
                    </div>
                </div>';

                $details = json_decode($data->packet, true);
                return $details['charges']['data']['payment_method_details']['card']['brand'];

            })
            ->addColumn(
                'card_type', function ($data) {

                $details = json_decode($data->packet, true);

                return '<div class="list-media">
                <div class="list-item">
                    <div class="info p-l-0">
                        <span class="title text-capitalize">'. $details['charges']['data']['payment_method_details']['card']['brand']. '</span>
                    </div>
                    </div>
                </div>';

            })
            ->addColumn(
                'actions', function ($data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="'.(route('admin.payments.show', ['id' => $data->id])).'" class="btn btn-info" title="Show"><i class="ti-eye"></i></a>';
                $action .= '</div>';

                return $action;
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
            ->toJson();
    }


    public function show($id)
    {
        $data = Payments::findOrFail($id);
        return view('admin.modules.payments.show', compact('data'))->render();
    }

    /*    public function edit($id)
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
