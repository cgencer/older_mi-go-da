<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Hotels;
use App\Models\Tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Facades\MediaUploader;
use Plank\Mediable\Jobs\CreateImageVariants;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Invitation;
use Illuminate\Support\Str;

class HotelsController extends Controller
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
        return view('admin.modules.hotels.index');
    }

    public function indexAjax(Request $request)
    {
        $query = Hotels::query();
        $current_lang = App::getLocale();
        if (isset($request->search['value'])) {
            $s = $request->search['value'];
            $query->where('name', 'LIKE', '%' . $s . '%');
            $query->orWhere('address', 'LIKE', '%' . $s . '%');
            $query->orWhere(function ($query) {
                $query->select('username')
                    ->from('users')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1);
            }, 'LIKE', '%' . $s . '%');
            $query->orWhere(function ($query) {
                $query->select('firstname')
                    ->from('users')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1);
            }, 'LIKE', '%' . $s . '%');
            $query->orWhere(function ($query) {
                $query->select('lastname')
                    ->from('users')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1);
            }, 'LIKE', '%' . $s . '%');
            $query->orWhere(function ($query) {
                $query->select('email')
                    ->from('users')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1);
            }, 'LIKE', '%' . $s . '%');
            $query->orWhere('sku', 'LIKE', '%' . $s . '%');
            $query->orWhere('description->'.$current_lang, 'LIKE', '%' . $s . '%');
            $query->orWhere('city', 'LIKE', '%' . $s . '%');
            $query->orWhere('contact_email', 'LIKE', '%' . $s . '%');
            $query->orWhere(function ($query) {
                $query->select('name')
                    ->from('countries')
                    ->whereColumn('country_id', 'countries.id')
                    ->limit(1);
            }, 'LIKE', '%' . $s . '%');
        }
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
                                <a href="' . (route('admin.users.edit', ['id' => $user->id])) . '">
                                    <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                                </a>
                            </div>
                            <div class="info">
                                <span class="title"><a href="' . (route('admin.users.edit', ['id' => $user->id])) . '">' . ((empty($user->firstname) || empty($user->lastname)) ? $user->username : ($user->firstname . ' ' . $user->lastname)) . '</a></span>
                                <span class="sub-title">ID: ' . $user->id . '</span>
                                <span class="sub-title">Username: ' . ($user->username) . '</span>
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
                $action .= '<a href="' . route('admin.hotels.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.hotels.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })->orderColumn('user', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('username')
                        ->from('users')
                        ->whereColumn('user_id', 'users.id')
                        ->limit(1);
                }, $order);
            })->orderColumn('hotel', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('country_id', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('name')
                        ->from('countries')
                        ->whereColumn('country_id', 'countries.id')
                        ->limit(1);
                }, $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->toJson();
    }

    public function show($id)
    {
        $data = Hotels::findOrFail($id);

        return view('admin.modules.hotels.show', compact('data'))->render();
    }

    public function edit($id)
    {
        $data = Hotels::findOrFail($id);
        $checkin = explode(':', $data->property_checkin);
        $checkout = explode(':', $data->property_checkout);
        $data['checkin'] = $checkin;
        $data['checkout'] = $checkout;
        return view('admin.modules.hotels.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = Hotels::findOrFail($id);
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
            'city' => 'City',
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
            'hotelUsers.*.firstname' => 'Hotel User Firstname',
            'hotelUsers.*.lastname' => 'Hotel User Lastname',
            'hotelUsers.*.email' => 'Hotel User Email',
            'hotelUsers.*.password' => 'Hotel User Password',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1',
            'sku' => 'required|min:1|max:255',
            'board_food_allowance_id' => 'required|min:1',
            'star_id' => 'required|min:1',
            'latitude' => 'required|min:1',
            'longitude' => 'required|min:1',
            'price' => 'required|min:1',
            'country_id' => 'required|min:1',
            'hotelUsers.*.firstname' => 'required|min:1',
            'hotelUsers.*.lastname' => 'required|min:1',
            'hotelUsers.*.email' => 'required|min:1|email'
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
        $updateData->is_verified = ($request->is_verified) ? 1 : 0;
        $updateData->is_enabled = ($request->is_enabled) ? 1 : 0;
        $updateData->gift_for_migoda_guests = ($request->gift_for_migoda_guests) ? 1 : 0;
        $updateData->price = $request->price;
        $updateData->gift_description = $request->gift_description;
        $updateData->sku = $request->sku;
        $updateData->contact_person = $request->contact_person;
        $updateData->contact_email = $request->contact_email;
        $updateData->contact_phone = $request->contact_phone;
        $updateData->country_id = $request->country_id;
        $updateData->city = $request->city;
        $updateData->property_description = $request->property_description;

        $updateData->property_checkin = $request->property_checkin . ':' . $request->property_checkin2;
        $updateData->property_checkout = $request->property_checkout . ':' . $request->property_checkout2;

        $updateData->imdlisting = $request->imdlisting;
        $updateData->imddetail = $request->imddetail;
        $updateData->imdcheckout = $request->imdcheckout;
        $updateData->imdmap = $request->imdmap;
        $updateData->immlisting = $request->immlisting;
        $updateData->immdetail = $request->immdetail;
        $updateData->immcheckout = $request->immcheckout;

        $updateData->imgallery = serialize($request->galeryItems);

        $hotelUsers = $request->hotelUsers;

        $updateData->setFeatures($request->features);
        $updateData->setUnavailableDates($request->unavailable_dates);

        if ($updateData->setHotelUsers($hotelUsers) == false) {
            $alert = [
                'alert' => [
                    'status' => 'error',
                    'message' => 'There is a registered user at this e-mail address.!'
                ]
            ];

            return redirect()->back()->with($alert);
        }

        $save = $updateData->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function add()
    {
        return view('admin.modules.hotels.add')->render();
    }

    public function addPost(Request $request)
    {
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
            'city' => 'City',
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
            'hotelUsers.*.firstname' => 'Hotel User Firstname',
            'hotelUsers.*.lastname' => 'Hotel User Lastname',
            'hotelUsers.*.email' => 'Hotel User Email',
            'hotelUsers.*.password' => 'Hotel User Password',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1',
            'sku' => 'required|min:1|max:255|unique:hotels',
            'board_food_allowance_id' => 'required|min:1',
            'star_id' => 'required|min:1',
            'latitude' => 'required|min:1',
            'longitude' => 'required|min:1',
            'country_id' => 'required|min:1',
            'hotelUsers.*.firstname' => 'required|min:1',
            'hotelUsers.*.lastname' => 'required|min:1',
            'hotelUsers.*.email' => 'required|min:1|unique:users,email|email',
            'hotelUsers.*.password' => 'required|min:8|max:20',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $newData = new Hotels();
        $newData->name = $request->name;
        $newData->description = $request->description;
        $newData->categories = $request->categories;
        $newData->board_food_allowance_id = $request->board_food_allowance_id;
        $newData->star_id = $request->star_id;
        $newData->address = $request->address;
        $newData->latitude = $request->latitude;
        $newData->longitude = $request->longitude;
        $newData->is_verified = ($request->is_verified) ? 1 : 0;
        $newData->is_enabled = ($request->is_enabled) ? 1 : 0;
        $newData->gift_for_migoda_guests = ($request->gift_for_migoda_guests) ? 1 : 0;
        $newData->price = $request->price;
        $newData->gift_description = $request->gift_description;
        $newData->sku = $request->sku;
        $newData->contact_person = $request->contact_person;
        $newData->contact_email = $request->contact_email;
        $newData->contact_phone = $request->contact_phone;
        $newData->country_id = $request->country_id;
        $newData->city = $request->city;
        $newData->property_description = $request->property_description;
        $newData->property_checkin = $request->property_checkin;
        $newData->property_checkout = $request->property_checkout;

        $hotelUsers = $request->hotelUsers;

        $save = $newData->save();
        if ($newData->setHotelUsers($hotelUsers) == false) {
            $newData->forceDelete();
            $alert = [
                'alert' => [
                    'status' => 'error',
                    'message' => 'There is a registered user at this e-mail address.!'
                ]
            ];

            return redirect()->back()->with($alert);
        }
        $newData->setFeatures($request->features);
        $newData->setUnavailableDates($request->unavailable_dates);

        Storage::disk('uploads')->makeDirectory('images/hotel_' . $newData->id);

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Hotel and Hotel User Added! Please add pictures for the hotel now.'
            ]
        ];

        return redirect(route('admin.hotels.edit', ['id' => $newData->id]))->with($alert);
    }

    public function remove($id)
    {
        $hotel = Hotels::findOrFail($id);
        $hotel->removeAllFeatures();
        $hotel->removeUnavailableDates();
        if (Hotels::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.hotels.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.hotels.index'))->with($alert);
        }
    }

    public function inviteHotel(Request $request, $id)
    {


        $hotel = Hotels::where('id', $id)->get()->first();

        $key = Str::random(100);

        $loginUrl = url('hotel/login?type=create&lang='.$request->lang.'&verified=true&verification='.$key);

        $token = new Tokens();

        $token->token = $key;
        $token->status = 1;
        $token->user_id = $hotel->hotel_user->id;

        $save =  $token->save();

        if ($save) {

            $welcomeSubject = "";

            switch ($request->lang) {
                case 'tr':
                    $welcomeSubject = "Migodahotels.com'a Hoşgeldiniz";
                    break;
                case 'en':
                    $welcomeSubject = "Welcome to Migodahotels.com";
                     break;
                case 'fr':
                    $welcomeSubject = "Bienvenue Sur Migodahotels.com";
                     break;
                case 'de':
                    $welcomeSubject = "Willkommen bei migodahotels.com";
                    break;
                case 'nl':
                    $welcomeSubject = "Welkom bij migodahotels.com";
                    break;
            }

        $data = [
            'url' => $loginUrl,
            'name' => $hotel->hotel_user->name,
            'lang' => $request->lang,
            'subject' => $welcomeSubject,
            'gender' => $hotel->hotel_user->gender
        ];


        Notification::send($hotel->hotel_user, new Invitation($data));

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Hotel invitation mail send successfully!'
            ]
        ];

        return redirect()->back()->with($alert);

        }else{
            $alert = [
                'alert' => [
                    'status' => 'error',
                    'message' => 'Hotel invitation not completed!'
                ]
            ];

            return redirect()->back()->with($alert);
        }


    }
}
