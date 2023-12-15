<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->except(['getLogout', 'getLogin', 'postLogin']);
    }

    public function getLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        } else {
            return view('admin.auth.login');
        }
    }

    public function postLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'enabled' => 1,
        ];
        $attributes = [
            'email' => trans('Email'),
            'password' => trans('Password'),
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        if (Auth::guard('admin')->attempt($credentials, $request->remember_token)) {
            $auth = Auth::guard('admin')->user();
            $admin = Admins::find($auth->id);
            $admin->last_login = Carbon::now();
            $admin->save();

            return redirect(route('admin.dashboard'));
        } else {
            return redirect()->route('admin.auth.login')->withErrors([__('auth.failed')]);
        }
    }

    public function getLogout()
    {
        Auth::guard('admin')->logout();
        Session::flush();

        return redirect()->route('admin.auth.login');
    }

    public function profile()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.auth.profile', compact('data'))->render();
    }

    public function profileSave(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $updateData = $user;
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
                'message' => 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function profileSecuritySave(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $updateData = $user;
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
}
