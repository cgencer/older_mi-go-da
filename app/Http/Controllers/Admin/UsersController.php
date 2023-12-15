<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Hotels;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'add',
                'edit',
                'save',
                'remove',
                'hotels',
                'hotelsAjax',
            ]);
    }

    public function index()
    {
        return view('admin.modules.users.index');
    }

    public function indexAjax(Request $request)
    {
        $query = User::query();
        if (isset($request->search['value'])) {
            $s = $request->search['value'];
            $query->where('username', 'LIKE', '%' . $s . '%');
            $query->orWhere('name', 'LIKE', '%' . $s . '%');
            $query->orWhere('firstname', 'LIKE', '%' . $s . '%');
            $query->orWhere('lastname', 'LIKE', '%' . $s . '%');
            $query->orWhere('email', 'LIKE', '%' . $s . '%');
        }
        return datatables()->of($query)->only(
            [
                'id',
                'user',
                'email',
                'enabled',
                'created_at',
                'last_login',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'user', 'enabled', 'action'])
            ->addColumn(
                'user', function (User $data) {
                $profile_image = $data->getMedia('profile_image')->first();
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="media-img">
                                <a href="' . (route('admin.users.edit', ['id' => $data->id])) . '">
                                    <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                                </a>
                            </div>
                            <div class="info">
                                <span class="title"><a href="' . (route('admin.users.edit', ['id' => $data->id])) . '">' . ((empty($data->firstname) || empty($data->lastname)) ? $data->username : ($data->firstname . ' ' . $data->lastname)) . '</a></span>
                                <span class="sub-title">ID: ' . $data->id . '</span>
                                <span class="sub-title">Username: ' . ($data->username) . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'id', function (User $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'enabled', function (User $data) {
                switch ($data->enabled) {
                    case 1:
                        return '<td><span class="badge badge-pill badge-gradient-success">Actived</span></td>';
                        break;
                    case 0:
                        return '<span class="badge badge-pill badge-warning">Pending</span>';
                        break;
                    default:
                        return '<span class="badge badge-pill badge-gradient-danger">Rejected</span>';
                        break;
                }
            })
            ->addColumn(
                'created_at', function (User $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'last_login', function (User $data) {
                if (!empty($data->last_login)) {
                    $last_login = $data->last_login->format('d-m-Y H:i:s');
                } else {
                    $last_login = "";
                }
                return ($last_login);
            })
            ->addColumn(
                'action', function (User $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . (($data->hotels()->get()->count() > 0) ? route('admin.users.hotels', $data->id) : 'javascript:void(0);') . '" class="btn btn-primary ' . (($data->hotels()->get()->count() == 0) ? 'disabled' : '') . '" title="User Hotels"><i class="mdi mdi-hotel"></i></a>';
                $action .= '<a href="' . route('admin.users.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.users.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('user', function ($query, $order) {
                $query->orderBy('firstname', $order);
            })
            ->orderColumn('email', function ($query, $order) {
                $query->orderBy('email', $order);
            })
            ->orderColumn('enabled', function ($query, $order) {
                $query->orderBy('enabled', $order);
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('last_login', function ($query, $order) {
                $query->orderBy('last_login', $order);
            })
            ->toJson();
    }

    public function hotels(Request $request, $userId)
    {
        $hotelUser = User::findOrFail($userId);
        return view('admin.modules.users.hotels', compact('hotelUser'));
    }

    public function hotelsAjax(Request $request, $userId)
    {
        $query = Hotels::query();
        $query->where('user_id', $userId);
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
            $query->orWhere('description', 'LIKE', '%' . $s . '%');
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
                    $created_at = $data->created_at->toDateTimeString();
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'updated_at', function (Hotels $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->toDateTimeString();
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

    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.modules.users.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = User::findOrFail($id);
        $attributes = [
            'username' => 'Username',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'gender' => 'Gender',
            'phone' => 'Phone',
            'website' => 'Website',
            'date_of_birth' => 'Birthday',
            'biography' => 'Biography',
        ];
        $messages = [];
        $rules = [
            'username' => (($updateData->username != $request->username) ? 'required|unique:users|min:1|max:125' : 'required|min:1|max:125'),
            'firstname' => 'required|min:1|max:191',
            'lastname' => 'required|min:1|max:191',
            'email' => (($updateData->email != $request->email) ? 'required|unique:users|max:120|email' : 'required|max:120|email'),
            'gender' => 'max:191',
            'phone' => 'max:64',
            'website' => 'max:64',
            'date_of_birth' => 'max:30',
            'biography' => 'max:1000',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->username = $request->username;
        $updateData->firstname = $request->firstname;
        $updateData->lastname = $request->lastname;
        $updateData->email = $request->email;
        $updateData->gender = $request->gender;
        $updateData->phone = $request->phone;
        $updateData->website = $request->website;
        $updateData->date_of_birth = $request->date_of_birth;
        $updateData->biography = $request->biography;
        $save = $updateData->save();
        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Profile Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function securitySave(Request $request, $id)
    {
        $updateData = User::findOrFail($id);
        $attributes = [

            'password' => 'New Password',
            'password_confirmation' => 'New Password Confirmation'
        ];
        $messages = [];
        $rules = [
            'password' => 'required|min:8|max:18|confirmed',
            'password_confirmation' => 'required|min:8|max:18',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->password = Hash::make($request->password);
        $save = $updateData->save();
        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Password Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function remove($id)
    {
        if (User::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.users.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.users'))->with($alert);
        }
    }
}
