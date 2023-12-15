<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Hotels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HotelsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user'])->only(
            [
                'add',
                'edit',
                'save',
            ]);
    }

    public function index()
    {
        return view('hotel_admin.modules.hotels.index');
    }

    public function indexAjax(Request $request)
    {
        $hotelUser = Auth::guard('user')->user();
        $query = $hotelUser->hotels();
        return datatables()->of($query)->only(
            [
                'id',
                'hotel',
                'user',
                'address',
                'country_id',
                'created_at',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'hotel', 'user', 'action'])
            ->addColumn(
                'hotel', function (Hotels $data) {
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="info p-l-0">
                                <span class="title">' . $data->name . '</span>
                                <span class="sub-title">Star: ' . $data->getStar() . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'user', function (Hotels $data) {
                if ($data->user_id) {
                    $user = $data->hotel_user()->get()->first();
                    $profile_image = $user->getMedia('profile_image')->first();

                    return '<div class="list-media">
                        <div class="list-item">
                            <div class="media-img">
                                 <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                            </div>
                            <div class="info">
                                <span class="title">' . ((empty($user->firstname) || empty($user->lastname)) ? $user->username : ($user->firstname . ' ' . $user->lastname)) . '</span>
                            </div>
                        </div>
                    </div>';
                } else {
                    return '<div class="list-media">
                        <div class="list-item">
                            <div class="info p-l-0">
                                <span class="title">No User.</span>
                            </div>
                        </div>
                    </div>';
                }
            })
            ->addColumn(
                'id', function (Hotels $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'country_id', function (Hotels $data) {
                $country = Countries::where('id', $data->country_id)->get()->first();

                return $country->name;
            })
            ->addColumn(
                'created_at', function (Hotels $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'updated_at', function (Hotels $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (Hotels $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('f.detail', ['id' => $data->id, 'slug' => $data->slug]) . '" class="btn btn-info" title="Show" target="_blank"><i class="ti-eye"></i></a>';
                $action .= '<a href="' . route('hotel_admin.hotels.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
//                $action .= '<a href="' . route('hotel_admin.hotels.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })->toJson();
    }

    public function show($id)
    {
        $data = Hotels::findOrFail($id);

        return view('hotel_admin.modules.hotels.show', compact('data'))->render();
    }

    public function edit($id)
    {
        $data = Hotels::findOrFail($id);
        $checkin = explode(':', $data->property_checkin);
        $checkout = explode(':', $data->property_checkout);
        $data['checkin'] = $checkin;
        $data['checkout'] = $checkout;
        return view('hotel_admin.modules.hotels.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $user = Auth::guard('user')->user();
        $updateData = Hotels::findOrFail($id);
        if ($updateData->user_id != $user->id) {
            $alert = [
                'alert' => [
                    'status' => 'error',
                    'message' => 'You do not have permission to do this.'
                ]
            ];

            return redirect()->back()->with($alert);
        }
        $oldData = $updateData->toArray();
        $attributes = [
            'categories' => 'Categories',
            'board_food_allowance_id' => 'BOARD MEAL ALLOWANCE',
            'star_id' => 'Star',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'is_verified' => 'Is Verified',
            'features' => 'Features',
            'price' => 'Price',
            'is_enabled' => 'Is Enabled',
            'gift_for_migoda_guests' => 'Gift for migoda guests',
            'gift_description' => 'Gift description',
            'vat' => 'Vat',
            'sku' => 'Sku',
            'contact_person' => 'Contact person',
            'contact_email' => 'Contact email',
            'contact_phone' => 'Contact phone',
            'country_id' => 'Country',
            'imdlisting' => 'imdlisting',
            'imgallery' => 'imgallery',
            'imdcheckout' => 'imdcheckout',
            'imdmap' => 'imdmap',
            'imddetail' => 'imddetail',
            'immlisting' => 'immlisting',
            'immcheckout' => 'immcheckout',
            'immdetail' => 'immdetail',
            'property_description' => 'Property description',
            'property_checkin' => 'Property checkin',
            'property_checkout' => 'Property checkout',
            'name' => 'Name',
            'description' => 'Description',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1',
            'board_food_allowance_id' => 'required|min:1',
            'star_id' => 'required|min:1',
            'latitude' => 'required|min:1',
            'longitude' => 'required|min:1',
            'price' => 'required|min:1',
            'country_id' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->name = $request->name;
        $updateData->description = $request->description;
        $updateData->categories = $request->categories;
        $updateData->board_food_allowance_id = $request->board_food_allowance_id;
        $updateData->star_id = $request->star_id;
        $updateData->address = $request->address;
        $updateData->latitude = $request->latitude;
        $updateData->longitude = $request->longitude;
        $updateData->gift_for_migoda_guests = ($request->gift_for_migoda_guests) ? 1 : 0;
        $updateData->price = $request->price;
        $updateData->gift_description = $request->gift_description;
        //$updateData->sku = $request->sku;
        $updateData->contact_person = $request->contact_person;
        $updateData->contact_email = $request->contact_email;
        $updateData->contact_phone = $request->contact_phone;
        $updateData->country_id = $request->country_id;
        $updateData->property_description = $request->property_description;
        $updateData->property_checkin = $request->property_checkin . ':' . $request->property_checkin2;
        $updateData->property_checkout = $request->property_checkout . ':' . $request->property_checkout2;
        $updateData->setFeatures($request->features);
        $updateData->setUnavailableDates($request->unavailable_dates);

        $updateData->imdlisting = $request->imdlisting;
        $updateData->imddetail = $request->imddetail;
        $updateData->imdcheckout = $request->imdcheckout;
        $updateData->imdmap = $request->imdmap;
        $updateData->immlisting = $request->immlisting;
        $updateData->immdetail = $request->immdetail;
        $updateData->immcheckout = $request->immcheckout;

        $updateData->imgallery = serialize($request->galeryItems);

        $save = $updateData->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }
}
