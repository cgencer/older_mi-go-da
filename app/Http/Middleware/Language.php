<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    private string $defaultLocale;
    private string $defaultCurrency;
    private string $defaultCurrencySign;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
        $this->defaultCurrency = 'EUR';
        $this->defaultCurrencySign = '€';
    }

    public function handle($request, Closure $next)
    {
        if (Session::has('applocale') && array_key_exists(Session::get('applocale'), Config::get('languages'))) {
            App::setLocale(Session::get('applocale'));
        } else {
            App::setLocale(Config::get('app.fallback_locale'));
        }
        Session::put('_currency', $this->defaultCurrency);
        Session::put('_currency_sign', $this->defaultCurrencySign);
        Session::put('_currency_rate', 1);
        Session::put('_locale', App::getLocale());
        return $next($request);
    }
}
