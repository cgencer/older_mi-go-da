<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Arcanedev\LaravelSettings\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    /**
     * GeneralController constructor.
     */
    public function __construct()
    {
    }

    public function filemanager()
    {
        return view('admin.modules.filemanager.index');
    }
}
