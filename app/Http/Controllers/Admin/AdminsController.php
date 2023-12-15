<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'index',
                'indexAjax',
                'add',
                'edit',
                'save',
                'remove',
            ]);
    }

    public function index()
    {
        return view('admin.modules.admins.index');
    }

    public function indexAjax()
    {
        $query = Admins::query();
        $currentAdmin = Auth::guard('admin')->user();
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
                'user', function (Admins $data) {
                $profile_image = $data->getMedia('profile_image')->first();
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="media-img">
                                <a href="' . (route('admin.admin_users.edit', ['id' => $data->id])) . '">
                                    <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                                </a>
                            </div>
                            <div class="info">
                                <span class="title"><a href="' . (route('admin.admin_users.edit', ['id' => $data->id])) . '">' . ((empty($data->firstname) || empty($data->lastname)) ? $data->username : ($data->firstname . ' ' . $data->lastname)) . '</a></span>
                                <span class="sub-title">ID: ' . $data->id . '</span>
                                <span class="sub-title">Username: ' . ($data->username) . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'id', function (Admins $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'enabled', function (Admins $data) {
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
                'created_at', function (Admins $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'last_login', function (Admins $data) {
                if (!empty($data->last_login)) {
                    $last_login = $data->last_login->format('d-m-Y H:i:s');
                } else {
                    $last_login = "";
                }
                return ($last_login);
            })
            ->addColumn(
                'action', function (Admins $data) {
                $currentAdmin = Auth::guard('admin')->user();
                $action = '<div class="text-center font-size-16 btn-group">';
                if ($currentAdmin->id != $data->id) {
                    $action .= '<a href="' . route('admin.admin_users.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                    $action .= '<a href="' . route('admin.admin_users.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                } else {
                    $action .= '<a href="' . route('admin.auth.profile.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                }
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('enabled', function ($query, $order) {
                $query->orderBy('enabled', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('last_login', function ($query, $order) {
                $query->orderBy('last_login', $order);
            })
            ->orderColumn('user', function ($query, $order) {
                $query->orderBy('firstname', $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        if ($currentAdmin->id == $id) {
            $alert = [
                'alert' => [
                    'status' => 'warning',
                    'message' => 'Wow. Are you okay? Because what you\'re trying to do is kinda weird. :)'
                ]
            ];

            return redirect(route('admin.admin_users.index'))->with($alert);
        }
        $data = Admins::findOrFail($id);
        return view('admin.modules.admins.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        if ($currentAdmin->id == $id) {
            $alert = [
                'alert' => [
                    'status' => 'warning',
                    'message' => 'Wow. Are you okay? Because what you\'re trying to do is kinda weird. :)'
                ]
            ];

            return redirect(route('admin.admin_users.index'))->with($alert);
        }
        $updateData = Admins::findOrFail($id);
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
            'username' => (($updateData->username != $request->username) ? 'required|unique:admins|min:1|max:125' : 'required|min:1|max:125'),
            'firstname' => 'required|min:1|max:191',
            'lastname' => 'required|min:1|max:191',
            'email' => (($updateData->email != $request->email) ? 'required|unique:admins|max:120|email' : 'required|max:120|email'),
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
        $currentAdmin = Auth::guard('admin')->user();
        if ($currentAdmin->id == $id) {
            $alert = [
                'alert' => [
                    'status' => 'warning',
                    'message' => 'Wow. Are you okay? Because what you\'re trying to do is kinda weird. :)'
                ]
            ];

            return redirect(route('admin.admin_users.index'))->with($alert);
        }
        $updateData = Admins::findOrFail($id);
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

    public function add(Request $request)
    {
        if (!isset($request->submitted) || empty($request->submitted)) {
            return view('admin.modules.admins.add')->render();
        }
        $newData = new Admins();
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
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ];
        $messages = [];
        $rules = [
            'username' => 'required|unique:admins|min:1|max:125',
            'firstname' => 'required|min:1|max:191',
            'lastname' => 'required|min:1|max:191',
            'email' => 'required|unique:admins|max:120|email',
            'gender' => 'max:191',
            'phone' => 'max:64',
            'website' => 'max:64',
            'date_of_birth' => 'max:30',
            'biography' => 'max:1000',
            'password' => 'required|min:8|max:18|confirmed',
            'password_confirmation' => 'required|min:8|max:18',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $newData->username = $request->username;
        $newData->firstname = $request->firstname;
        $newData->lastname = $request->lastname;
        $newData->email = $request->email;
        $newData->gender = $request->gender;
        $newData->phone = $request->phone;
        $newData->website = $request->website;
        $newData->date_of_birth = $request->date_of_birth;
        $newData->biography = $request->biography;
        $newData->password = Hash::make($request->password);
        $save = $newData->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Added'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function remove($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        if ($currentAdmin->id == $id) {
            $alert = [
                'alert' => [
                    'status' => 'warning',
                    'message' => 'Wow. Are you okay? Because what you\'re trying to do is kinda weird. :)'
                ]
            ];

            return redirect(route('admin.admin_users.index'))->with($alert);
        }
        if (Admins::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.admin_users.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.admin_users.index'))->with($alert);
        }
    }
}
