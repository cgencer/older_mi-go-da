<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User, App\Models\Hotels, App\Models\Countries;
use App, DB, Auth, Mail, Validator, Redirect, Hash;
use StripeChannel;

class Onboarding extends Controller
{

    public function onboarding(Request $request)
    {
        $link = '';
//        $user = User::where('email', 'obsesif@gmail.com')->get()->first()->toArray();
        if($request->has('country')){
//            var_dump('it has country: '.$request['country']);
        }
        if($request->has('hotel_id')){

            $this->stripeAPI = new StripeChannel;
//            $this->StripeApi = new StripeAPIAdvanced;

            $h = Hotels::where('id', $request->hotel_id)->get()->first();
            $u = User::where('name', $h->name)->get()->first();
            if($u->stripe_data === null){
            	$specs = $this->StripeApi->retrieveCountrySpecs($h->getCode());
                $c = $this->StripeApi->createHotelAccount($h->getCode(), $u->email);
                $link = $c['link'];
                $u->stripe_data = ['account_sid' => $c['acc']];
                $u->country = $h->getCode();
                $u->prefix = Countries::where('name', 'like', '%'.$h->getCountryName().'%')->pluck('prefix')[0];
                $u->save();
            }
        }

        $l = Auth::guard('user')->attempt(['email' => 'obsesif@gmail.com', 'password' => '123']);
        $c = Auth::guard('user')->check();
        $user = Auth::guard('user')->user();
        $request->merge([
            'name'          => $user->name, 
            'email'         => $user->email
        ]);
        return view('front.onboarding', ['request' => $request, 'link' => $link, 'specs' => $specs['verification_fields']]);
    }

    public function onboardLink(Request $request)
    {

        if($request->has('hotel_id'))
        {
        }
    }
}
