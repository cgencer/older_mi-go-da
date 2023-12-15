<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::guard('admin')->check()) {
            return Redirect::route('admin.auth.login');
        }

        return $next($request);
    }
}
