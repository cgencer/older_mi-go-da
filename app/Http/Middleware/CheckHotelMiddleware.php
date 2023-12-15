<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Hotels;


class CheckHotelMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {

        $hotel = Hotels::findOrFail($request->id);

        if (!Auth::guard('user')->check()) {
            return Redirect::route('hotel_admin.auth.login');
        }

        if (!$hotel->user_id == Auth::guard('user')->user()->id) {
            return view('errors.404');
        }


        return $next($request);
    }
}
