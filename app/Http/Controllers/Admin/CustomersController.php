<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
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
        return view('admin.modules.customers.index');
    }

    public function indexAjax(Request $request)
    {
        $query = Customers::query();
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
                'user', function (Customers $data) {
                $profile_image = $data->getMedia('profile_image')->first();
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="media-img">
                                <a href="' . (route('admin.customers.edit', ['id' => $data->id])) . '">
                                    <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                                </a>
                            </div>
                            <div class="info">
                                <span class="title"><a href="' . (route('admin.customers.edit', ['id' => $data->id])) . '">' . ((empty($data->firstname) || empty($data->lastname)) ? $data->username : ($data->firstname . ' ' . $data->lastname)) . '</a></span>
                                <span class="sub-title">ID: ' . $data->id . '</span>
                                <span class="sub-title">Username: ' . ($data->username) . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'id', function (Customers $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'enabled', function (Customers $data) {
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
                'created_at', function (Customers $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'last_login', function (Customers $data) {
                if (!empty($data->last_login)) {
                    $last_login = $data->last_login->format('d-m-Y H:i:s');
                } else {
                    $last_login = "";
                }
                return ($last_login);
            })
            ->addColumn(
                'action', function (Customers $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.customers.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.customers.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('user', function ($query, $order) {
                $query->orderBy('firstname', $order);
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('enabled', function ($query, $order) {
                $query->orderBy('enabled', $order);
            })
            ->orderColumn('email', function ($query, $order) {
                $query->orderBy('email', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('last_login', function ($query, $order) {
                $query->orderBy('last_login', $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $data = Customers::findOrFail($id);
        return view('admin.modules.customers.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = Customers::findOrFail($id);
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
            'enabled' => 'Enabled',
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
        $updateData->enabled = $request->enabled;
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
        $updateData = Customers::findOrFail($id);
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
        if (Customers::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.customers.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.customers.index'))->with($alert);
        }
    }
}
