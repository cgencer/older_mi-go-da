<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (!array_key_exists($lang, Config::get('languages'))) {
            abort(400);
        }

        Session::put('applocale', $lang);
        Session::save();
        return Redirect::back();
    }

    public static function switchLangHotel($lang)
    {
        if (!array_key_exists($lang, Config::get('languages'))) {
            abort(400);
        }

        Session::put('applocale', $lang);
        Session::save();
        return Redirect::back();

    }
}
