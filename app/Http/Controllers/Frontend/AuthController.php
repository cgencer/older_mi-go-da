<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Models\CouponUsage;
use App\Models\Customers;
use App\Models\Tokens;
use App\Models\HotelCategories;
use App\Models\Hotels;
use App\Models\Countries;
use App\Notifications\ActivateAccount;
use App\Notifications\PasswordResetNotification;
use App\Notifications\DeleteAccount;
use App\Notifications\Welcome;
use App\Notifications\Subscribe;
use App\Models\PasswordReset;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Luilliarcec\LaravelUsernameGenerator\Facades\Username;
use Revolution\Google\Sheets\Facades\Sheets;
use Plank\Mediable\Facades\MediaUploader;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\LanguageController;
use Intervention\Image\ImageManagerStatic as Image;


class AuthController extends Controller
{
    public function getLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect(route('auth.profile'));
        }
        $homeCategories = HotelCategories::orderBy('position', 'asc')->get()->chunk(4);
        Session::put('login-active', true);
        return view('front.index', compact('homeCategories'));
    }

    public function postLogin(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            return redirect(route('auth.profile'));
        }

        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];
        $attributes = [
            'username' => __('txt.field_email'),
            'password' => __('txt.field_password')
        ];
        $rules = [
            'username' => 'required|email',
            'password' => 'required'
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            Session::put('login-active', true);
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $remember = $request->remember_me;

        $isTrashed = Customers::onlyTrashed()
            ->where('email', $request->username)
            ->get();

            if($isTrashed->count() > 0){
                $isTrashed = $isTrashed->first();
                if(Hash::check( $request->password ,$isTrashed->password)){
                        $isTrashed->restore();
                        $isTrashed->enabled = 1;
                        $isTrashed->save();
                }
            }

        if (Auth::guard('customer')->attempt($credentials, $remember)) {
            $auth = Auth::guard('customer')->user();
            $user = Customers::where('id', $auth->id)->get()->first();

            if ($user->enabled != 1) {
                Auth::guard('customer')->logout();
                return Redirect::back()->withErrors([trans('txt.validate_your_account')]);
            }
            $user->last_login = Carbon::now();
            $user->save();
            Session::put('login-active', false);

            $changeLang = new LanguageController();

            $changeLang->switchLang($user->language);

            return Redirect::route('f.index');
        }

        return Redirect::back()->withErrors([trans('txt.invalid_credentials')]);
    }

    public function getLogout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('f.index');
    }

    public function getRegister()
    {
        if (Auth::guard('customer')->check()) {
            return redirect(route('auth.profile'));
        }
        $homeCategories = HotelCategories::orderBy('position', 'asc')->get()->chunk(4);
        Session::put('signup-active', true);
        return view('front.index', compact('homeCategories'));
    }

    public function postRegister(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            return redirect(route('auth.profile'));
        }

        $inputData = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ];

        Session::put('signupInformations', $inputData);

        $attributes = [
            'firstname' => __('txt.field_firstname'),
            'lastname' => __('txt.field_lastname'),
            'email' => __('txt.field_email'),
            'password' => __('txt.field_password'),
            'password_confirmation' => __('txt.field_password_confirmation'),
            'terms' => __('txt.terms_conditions_accept'),
            'coupon_codes.*' => __('txt.enter_coupon_code'),
        ];
        $messages = [];
        $rules = [
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|email|unique:customers|max:191',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'terms' => 'accepted',
            'coupon_codes.*' => 'required',
//            'g-recaptcha-response' => 'required|recaptcha' //!TODO Google Recaptche eklenecek
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $coupon_codes = $request->coupon_codes;
        if (count($coupon_codes) == 0) {
            return Redirect::back()->withErrors(trans('txt.enter_coupon_code'));
        } else {
            $errors = [];
            foreach ($coupon_codes as $coupon_code) {
                $coupon = CouponCode::where('code', $coupon_code)->get();
                if ($coupon->count() > 0) {
                    $coupon = $coupon->first();
                    if (is_null($coupon)) {
                        $errors[] =  trans('txt.your_code_invalid'). ': ' . $coupon_code;
                    }
                    if ($coupon->checkValidCoupon() === false) {
                        $errors[] = trans('txt.your_code_invalid'). ': '  . $coupon_code;
                    }
                } else {
                    $errors[] = trans('txt.your_code_invalid'). ': 0'  . $coupon_code;
                }

            }
            if (count($errors) > 0) {
                return Redirect::back()->withErrors([$errors]);
            }
        }
        $form_data = [
            'name' => $request->firstname . ' ' . $request->lastname,
            'username' => Username::make($request->firstname . ' ' . $request->lastname),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'enabled' => 0,
            'email_token' => Str::random(30) . time(),
            'language' => \Illuminate\Support\Facades\App::getLocale()
        ];
        $new_customer = Customers::create($form_data);
        if ($new_customer) {
            foreach ($coupon_codes as $coupon_code) {
                $coupon = CouponCode::where('code', $coupon_code)->get()->first();

                $newCoupon = new CouponUsage();
                $newCoupon->code = $coupon->code;
                $newCoupon->rule_id = $coupon->rule_id;
                $newCoupon->customer_id = $new_customer->id;
                $newCoupon->save();

                $coupon->coupon_usage_id = $newCoupon->id;
                $coupon->save();
            }

            $new_customer->notify(new ActivateAccount($new_customer));
            Session::put('user_registered', true);
            Session::forget('signupInformations');
            return redirect(route('auth.register'))->with('success', trans("txt.registration_complete_before"));
        }

        return redirect(route('auth.register'));
    }

    public function activeAccount($code)
    {
        if (Auth::guard('customer')->check() || empty($code)) {
            return redirect(route('auth.login'));
        }
        $checkActivationCode = Customers::where('email_token', $code)->get();
        if ($checkActivationCode->count() > 0) {
            $user = $checkActivationCode->first();
            try {
                $user->enabled = 1;
                $user->email_token = "";
                $user->email_verified_at = Carbon::now();
                $user->save();
                $user->notify(new Welcome($user));

                return redirect(route('auth.login'))->with('success', trans("txt.registration_complete_after"));
            } catch (\Exception $e) {
                return Redirect::route('auth.login')->withErrors([trans('txt.account_verification_error') . $e->getMessage()]);
            }
        }
        $data = [
            'alert' => [
                'status' => 'error',
                'message' => __('txt.invalid_verification_code'),
            ],
        ];
        return Redirect::route('auth.login')->withErrors([ trans('txt.invalid_verification_code')]);
    }

    public function getResetPassword()
    {
        Session::put('forgotten-active', true);
        $homeCategories = HotelCategories::orderBy('position', 'asc')->get()->chunk(4);
        return view('front.index', compact('homeCategories'));
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
        }else{
            $customer = Customers::where('email', $request->email)->first();
            if ($customer) {
                // Check old password reset requests and destroy
                PasswordReset::where('email',  $request->email)->where('status', 0)->delete();

                $now = Carbon::now();
                $expiresAt = $now->addDays(1);
                $key = Str::random(100);

                $setPasswordReset = array();
                $setPasswordReset = new PasswordReset;
                $setPasswordReset->verification_code = $key;
                $setPasswordReset->customer_id = $customer->id;
                $setPasswordReset->email = $request->email;
                $setPasswordReset->expire_date = $expiresAt;
                $setPasswordReset->save();
                $resetUrl = url('password-reset?type=reset&verified=true&verification='.$key);
                $lang = $customer->language;

                Notification::send($customer, new PasswordResetNotification($resetUrl, $lang));

              return redirect()->back()->with('success', trans('txt.password_reset_sent_success'));

           }
           else{
              Session::put('forgotten-active', true);
              return redirect()->back()->withErrors([trans('txt.password_reset_sent_failed')]);
           }

        }
    }

    public function createNewPassword(Request $request){
       $verification = $request->verification;
       $getControls = PasswordReset::where('verification_code', $verification)->where('expire_date', '>', Carbon::now())->where('status', 0)->firstOrFail();
       $customer = $getControls->customer_id;
       $resetId = $getControls->id;
       $create_new = true;

       Session::put('forgotten-active', true);
       return view('front.index', compact('create_new', 'customer', 'resetId'));
    }

    public function saveNewPassword(Request $request){
        $customerId = $request->customer;
        $reset_id = $request->reset_id;
        $getCustomer = Customers::findOrFail($customerId);
        $getPasswordReset =  PasswordReset::findOrFail($reset_id);

        $getPasswordReset->status = 1;
        $getCustomer->password = Hash::make(trim($request->password));
        $setNewPassword = $getCustomer->save();
        $setStatus = $getPasswordReset->save();

        if ($setNewPassword && $setStatus) {
            Session::put('login-active', true);
            Session::put('forgotten-active', false);
            return redirect(route('auth.login'))->with('success', trans('txt.password_reset_success'));
        }

        return redirect()->back()->withErrors([trans('txt.password_reset_fail')]);
    }

    public function getProfile()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        return view('front.auth.profile', compact('user'));
    }

    public function postProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        $attributes = [
            'firstname' => __('txt.field_firstname'),
            'lastname' => __('txt.field_lastname'),
            'phone' => __('txt.field_phone'),
            'gender' => __('txt.field_gender'),
        ];
        $messages = [];
        $rules = [
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'gender' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->country = $request->country;
        // TODO: need to change the profile.blade: it returns the iso code of country selected named as 'prefix'
        // this works at the moment.
        $user->prefix = $request->prefix;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        if ($request->month != "" && $request->day != "" && $request->year != "") {
            $user->date_of_birth = $request->year . '-' . $request->month . '-' . $request->day;
        }

        if($request->year == "1900"){
            return redirect()->back()->withErrors([trans('txt.select_birthdate')]);
        }

        $saved = $user->save();

        if (isset($request->cropped_image)) {
            $img = Image::make($request->cropped_image)->encode('png');
            $media = MediaUploader::fromString($img)
            ->toDestination('uploads', 'avatars')
            ->useHashForFilename()
            ->upload();

            $user->syncMedia($media, 'profile_image');
            $user->profile_image = $media->getUrl();
        }

        $saved = $user->save();

        if ($saved) {
            return redirect()->back()->with('success', trans('txt.user_saved'));
        }

        return redirect()->back()->withErrors([trans('txt.user_not_saved')]);
    }

    public function getPassword()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        return view('front.auth.password', compact('user'));
    }

    public function postPassword(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        $attributes = [
            'oldPassword' => __('txt.field_old_password'),
            'password' => __('txt.field_new_password'),
            'password_confirmation' => __('txt.field_new_password_repeat'),
        ];
        $messages = [];
        $rules = [
            'oldPassword' => 'required|max:191',
            'password' => 'required|max:191|confirmed',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        if (!Hash::check($request->oldPassword, $user->password)) {
            return redirect()->back()->withErrors([trans('txt.incorrect_current_password')]);
        }

        $user->password = Hash::make(trim($request->password));
        $saved = $user->save();

        if ($saved) {
            return redirect()->back()->with('success', trans('txt.user_saved'));
        } else {
            return redirect()->back()->withErrors([trans('txt.user_not_saved')]);
        }
    }

    public function getWishlist()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        $hotels = $user->getFavoriteItems(Hotels::class)->get();
        return view('front.auth.wishlist', compact('user', 'hotels'));
    }

    public function getWaitingConfirmation(Request $request)
    {
        $status = "all";
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        if (isset($request->status)) {
            $status = $request->status;
            $reservations = $user->getReservations()->where('status', $request->status)->get()->paginate(5);
        }else{
             $status = "all";
             $reservations = $user->getReservations()->whereNotIn('status',  [3,9])->orderByRaw('FIELD(status,1,4,0,7,8,2,5,6)', 'ASC')->get()->paginate(5);
        }

        return view('front.auth.waiting-confirmation', compact('user', 'reservations', 'status'));
    }

    public function getSheets(Request $request)
    {
//        config(['sheets.post_spreadsheet_id' => env('GOOGLE_SHEET_ID')]);
        $sheets = Sheets::spreadsheet(config('services.google.sheets.sheet_id'))->sheetList();
        $crs = '';


    }

    public function getTravelHistory()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        $reservationsPast = $user->getReservations()->where('status','!=', 3)->where('status', 9)->paginate(3);
        $reservationsCurrent= $user->getReservations()->whereIn('status', [3])->paginate(3);


        return view('front.auth.travel-history', compact('user', 'reservationsPast', 'reservationsCurrent'));
    }

    public function getPays()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        $reservations = $user->getReservations()->whereIn('status', [1, 4])->get();
        return view('front.auth.pay-now', compact('user', 'reservations'));
    }

    public function getAccountSettings()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        return view('front.auth.account-settings', compact('user'));
    }

    public function setAccountSettings(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        $customer = Customers::find($user->id);

        $customer->subscribed = $request->newsletter == "on" ? 1 : 0 ;
        $customer->notifications = $request->system == "on" ? 1 : 0 ;

        if ( $request->newsletter == "on") {
            $data = [
                'type' => 1,
                'name' => $customer->name
            ];
        }else{
            $data = [
                'type' => 0,
                'name' => $customer->name
            ];

        }

        Notification::send($user, new Subscribe($data));

        $customer->save();

        if ($customer) {
            return redirect()->back()->with('success', trans('txt.settings_saved'));

            return redirect()->back()->withErrors([trans('txt.settings_not_saved')]);
        }
    }

    public function deleteAccountNotify(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        if (!Hash::check($request->password_confirmation, $user->password)) {
            return redirect()->back()->withErrors([trans('txt.settings_password_incorrect')]);
        }

        $name = $user->name;
        $key = Str::random(100);
        $deleteUrl = url('delete-account-confirm?type=delete&verified=true&verification='.$key);

        $tokens = new Tokens();
        $tokens->customer_id = $user->id;
        $tokens->token = $key;
        $tokens->save();

        $data = [
            'deleteUrl' => $deleteUrl,
            'name' => $name,
        ];

         Notification::send($user, new DeleteAccount($data));

        return redirect()->back()->with('success', trans('txt.settings_delete_account_request_success'));

    }


    public function deleteAccountConfimation(Request $request)
    {
            $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
            $getControls = Tokens::where('token', $request->verification)->where('status', 0)->firstOrFail();
            $getTokens =  Tokens::findOrFail($getControls->id);
            $customer = Customers::findOrFail($user->id);

            $getTokens->status = 1;
            $customer->enabled = 0;
            $customer->save();
            $getControls->save();
            $customer->delete();

            if ($customer) {
                return redirect(route('auth.login'))->with('success', trans('txt.settings_account_deleted'));
            }
        }

        public function getSecurity()
        {
            $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

            return view('front.auth.security', compact('user'));
        }

        public function getSubscriptions()
        {
            $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

            return view('front.auth.subscriptions', compact('user',));
        }

        public function getLanguage()
        {
            $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

            return view('front.auth.language', compact('user'));
        }

        public function setLanguage(Request $request)
        {
            $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

            $setUser = Customers::where('id', $user->id)->firstOrFail();

            $setUser->language = $request->language;
            $setUser->save();

            // $changeLang = new LanguageController();

            // $changeLang->switchLang($request->language);

            if (!$setUser) {
                return Redirect::back()->withErrors([trans('txt.profile_was_not_saved')]);
            }

         return redirect()->back()->with('success', trans('txt.profile_successfully_uptade'));

        }

    }
