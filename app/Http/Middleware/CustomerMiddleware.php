<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CustomerMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::guard('customer')->check()) {
            return Redirect::route('auth.login');
        }

        return $next($request);
    }
}
