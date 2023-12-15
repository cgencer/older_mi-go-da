<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user'])->only(
            [
                'index',
            ]);
    }

    public function index()
    {
        $app_locale = \Illuminate\Support\Facades\App::getLocale();
        $faq = Faq::whereNotNull('title->' . $app_locale)->where('type', 'HOTEL')->orderby('position', 'asc')->get();
        return view('hotel_admin.modules.faq.index', compact('faq'))->render();
    }

    public function data_privacy()
    {
        $app_locale = \Illuminate\Support\Facades\App::getLocale();
        $faq = Faq::whereNotNull('title->' . $app_locale)->where('type', 'HOTEL_PRIVACY')->orderby('position', 'asc')->get();
        return view('hotel_admin.modules.hotel_privacy.index', compact('faq'))->render();
    }
}
