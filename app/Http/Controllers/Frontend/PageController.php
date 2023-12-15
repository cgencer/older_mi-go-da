<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\contactForms, App\Models\Faq, App\Models\Pages;
use App\Models\User, App\Models\Countries, App\Models\Hotels, App\Models\HotelCategories;
use \Illuminate\Http\Request;
use Auth, Mail, Validator, Redirect, Hash;
use StripeChannel;

class PageController extends Controller
{
    protected $stripeAPI;

    public function index()
    {
        $homeCategories = HotelCategories::orderBy('position', 'asc')->get()->chunk(4);
        return view('front.index', compact('homeCategories'));
    }

    public function about()
    {
        return view('front.about');
    }

    public function getPage($slug)
    {
        $app_locale = \Illuminate\Support\Facades\App::getLocale();
        $page = Pages::where("slug->{$app_locale}", $slug)->get();
        if ($page->count() > 0) {
            $data = $page->first();
            return view('front.page', compact('data'))->render();
        } else {
            abort(404);
        }
    }

    public function howItWorks()
    {
        return view('front.howItWorks');
    }

    public function faq()
    {
        $app_locale = \Illuminate\Support\Facades\App::getLocale();
        $faqs = Faq::whereNotNull('title->' . $app_locale)->where('type','USER')->orderBy('position')->get();
        return view('front.faq', compact('faqs'))->render();
    }

    public function data_privacy()
    {
        $app_locale = \Illuminate\Support\Facades\App::getLocale();
        $faqs = Faq::whereNotNull('title->' . $app_locale)->where('type','PRIVACY')->orderBy('position')->get();
        return view('front.data-privacy', compact('faqs'))->render();
    }

    public function termsAndConditions()
    {
        return view('front.termsAndConditions');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function onboarding(Request $request)
    {
        $link = '';
        $specs = [];
//        $user = User::where('email', 'obsesif@gmail.com')->get()->first()->toArray();
        if ($request->has('country')) {
//            var_dump('it has country: '.$request['country']);
        }
        if ($request->has('hotel_id')) {

            $this->stripeAPI = new StripeChannel;
//            $this->StripeApi = new StripeAPIAdvanced;

            $h = Hotels::where('id', $request->hotel_id)->get()->first();
            $u = User::where('name', $h->name)->get()->first();
            $specs = collect(json_decode(json_encode($this->stripeAPI->retrieveCountrySpecs($h->getCode())->verification_fields->company)));
            if ($u->stripe_data === null) {
                $c = $this->stripeAPI->createHotelAccount($h->getCode(), $u->email);
                $link = $c['link'];
                $u->stripe_data = json_encode([
                    'account_sid' => $c['acc'],
                ]);
                $u->country = $h->getCode();
                $u->prefix = Countries::where('name', 'like', '%' . $h->getCountryName() . '%')->pluck('prefix')[0];
                $u->save();
            }
        }

        $l = Auth::guard('user')->attempt(['email' => 'obsesif@gmail.com', 'password' => '123']);
        $c = Auth::guard('user')->check();
        $user = Auth::guard('user')->user();
        $request->merge([
            'name' => $user->name,
            'email' => $user->email
        ]);
        return view('front.onboarding', [
            'request' => $request,
            'link' => $link,
            'minSpecs' => $specs['minimum'],
            'addSpecs' => $specs['additional']
        ]);
    }

    public function onboardLink(Request $request)
    {

        if ($request->has('hotel_id')) {
        }
    }

    public function postContact(Request $r)
    {
        $attributes = [
            'fullname' => __('txt.field_name'),
            'email' => __('txt.field_email'),
            'message' => __('txt.field_message')
        ];
        $messages = [
//            'g-recaptcha-response.required' => __('txt.g-recaptcha-required'), //!TODO add google recaptcha
//            'g-recaptcha-response.recaptcha' => __('txt.g-recaptcha-recaptcha'),
        ];
        $rules = [
            'fullname' => 'required|max:125',
            'email' => 'required|email|max:125',
            'message' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
        $validator = Validator::make($r->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $contactForm = new contactForms();
        $contactForm->fullname = $r->fullname;
        $contactForm->email = $r->email;
        $contactForm->message = $r->message;
        $new = $contactForm->save();

        /* //!TODO add contact-form view
         *  Mail::send(
             'emails.contact-form', array(
             'fullname' => $r->fullname,
             'email' => $r->email,
             'message' => $r->message,
         ), function ($message) {
             $message->from(env('MAIL_FROM_ADDRESS'))->to([
                 'info@migoda.com',
             ])->subject('Migoda.com Contact Form');
         });*/

        return redirect()->back()->with('success', __('txt.contact_form_success'));
    }
}
