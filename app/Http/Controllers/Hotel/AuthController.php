<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LanguageController;
use App\Models\User;
use App\Models\Tokens;
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
        $this->middleware('auth.hotel')->except(['getLogout', 'getLogin', 'postLogin']);
    }

    public function getLogin(Request $request)
    {

        if (Auth::guard('user')->check()) {
            return redirect(route('hotel_admin.dashboard'));
        } else {

            if ($request->type == "create") {

                LanguageController::switchLangHotel($request->lang);

                $token = Tokens::where('token', $request->verification)->where('status', 1)->get();

                if ($token->count() > 0) {
                    $user = User::where('id', $token->first()->user_id)->get();

                    if ($user->count() > 0) {
                        $user = $user->first();

                        Auth::guard('user')->login($user);
                        return redirect(route('hotel_admin.dashboard'));

                    } else {
                        return redirect()->route('hotel_admin.auth.login')->withErrors([__('auth.failed')]);
                    }
                } else {
                    return redirect()->route('hotel_admin.auth.login')->withErrors([__('auth.failed')]);
                }
            }
            return view('hotel_admin.auth.login');
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
            return redirect()->route('hotel_admin.auth.login')
                ->withErrors($validator)
                ->withInput();
        }
        if (Auth::guard('user')->attempt($credentials, $request->remember_token)) {
            $auth = Auth::guard('user')->user();
            $admin = User::find($auth->id);
            $admin->last_login = Carbon::now();
            $admin->save();

            return redirect(route('hotel_admin.dashboard'));
        } else {
            return redirect()->route('hotel_admin.auth.login')->withErrors([__('auth.failed')]);
        }
    }

    public function getLogout()
    {
        Auth::guard('user')->logout();
        Session::flush();

        return redirect()->route('hotel_admin.auth.login');
    }

    public function profile()
    {
        $data = Auth::guard('user')->user();
        return view('hotel_admin.auth.profile', compact('data'))->render();
    }

    public function profileSave(Request $request)
    {
        $user = Auth::guard('user')->user();
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
        $user = Auth::guard('user')->user();
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


    public function createNewPasswordHotel(Request $request)
    {
        if ($request->password != $request->password_repeat) {
            return redirect()->back()->withErrors(trans('txt.passwords_not_match'));
        } else if (strlen($request->password) < 8) {
            return redirect()->back()->withErrors(trans('txt.minimum_password_length'));
        } else if ($request->terms_conditions == "off") {
            return redirect()->back()->withErrors(trans('txt.terms_conditions_accept'));
        }

        $getCustomer = User::findOrFail($request->hotel_id);
        $getToken = Tokens::where('user_id', $request->hotel_id)->get()->first();

        if (!$getToken) {
            return redirect()->route('hotel_admin.dashboard');
        }

        $getToken->status = 0;
        $getCustomer->password = Hash::make(trim($request->password));
        $getCustomer->isRegister = 1;
        $setNewPassword = $getCustomer->save();
        $setStatus = $getToken->save();

        if ($setNewPassword && $setStatus) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => trans('txt.account_created_success')
                ]
            ];

            return redirect()->back()->with($alert);
        }

        return redirect()->back()->withErrors([trans('txt.password_reset_fail')]);
    }

}
