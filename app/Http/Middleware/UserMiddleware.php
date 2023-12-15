<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::guard('user')->check()) {
            return Redirect::route('hotel_admin.auth.login');
        }

        return $next($request);
    }
}
