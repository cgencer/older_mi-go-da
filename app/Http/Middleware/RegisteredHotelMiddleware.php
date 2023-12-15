<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Models\Hotels;
use GuzzleHttp\Psr7\Request;

class RegisteredHotelMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::guard('user')->user();
        $hotels = $hotel = $user->hotels()->first();
        
        $current = $request->path();

        if( $hotels->is_verified == 1) {
          return $next($request);
        }
      
        if (($current != "hotel/dashboard" && $current != "hotel/hotels/createNewPassword") && $user->isRegister == 0) {

          return Redirect::route('hotel_admin.dashboard');
          }

         return $next($request);
        }
}
