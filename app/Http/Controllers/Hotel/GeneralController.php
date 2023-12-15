<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\User;
use App\Models\Tokens;
use Arcanedev\LaravelSettings\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class GeneralController extends Controller
{
    /**
     * GeneralController constructor.
     */
    public function __construct()
    {
    }

    public function filemanager()
    {
        return view('hotel_admin.modules.filemanager.index');
    }

    public function forgotPassword()
    {
        return view('hotel_admin.auth.forgot-password');
    }

    public function postResetPassword(Request $request)
    {
        $attributes = [
            'email' => "email",
        ];
        $messages = [];
        $rules = [
            'email' => 'required|max:191',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = User::where('email', $request->email)->first();
        if ($customer) {
            // Check old password reset requests and destroy
            Tokens::where('user_id', $customer->id)->where('status', 0)->delete();

            $key = Str::random(100);

            $setPasswordReset = new Tokens;
            $setPasswordReset->token = $key;
            $setPasswordReset->user_id = $customer->id;
            $setPasswordReset->save();
            $resetUrl = url('hotel/password-reset?type=reset&verified=true&verification=' . $key);

            Notification::send($customer, new PasswordResetNotification($resetUrl));

            return redirect()->back()->with('success', trans('txt.password_reset_sent_success'));

        }

        return redirect()->back()->withErrors([trans('txt.password_reset_sent_failed')]);
    }


    public function createNewPassword(Request $request)
    {
        $verification = $request->verification;
        $getControls = Tokens::where('token', $verification)->where('status', 0)->firstOrFail();
        $customer = $getControls->user_id;
        $resetId = $getControls->id;

        return view('hotel_admin.auth.password-reset', compact('resetId', 'customer'));
    }

    public function saveNewPassword(Request $request)
    {
        $customerId = $request->customer;
        $reset_id = $request->resetId;
        $getCustomer = User::findOrFail($customerId);
        $getPasswordReset = Tokens::findOrFail($reset_id);

        $getPasswordReset->status = 1;
        $getCustomer->password = Hash::make(trim($request->password));
        $setNewPassword = $getCustomer->save();
        $setStatus = $getPasswordReset->save();

        if ($setNewPassword && $setStatus) {
            return redirect(route('hotel_admin.auth.login'))->with('success', trans('txt.password_reset_success'));
        }

        return redirect()->back()->withErrors([trans('txt.password_reset_fail')]);
    }

}
