<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {   
        return view('admin.modules.dashboard.index')->render();
    }

    public function calendar()
    {
        $reservations = Reservation::whereIn('status', [Reservation::STATUS_PAID, Reservation::STATUS_APPROVED])->get();
        return view('admin.modules.dashboard.calendar', compact('reservations'))->render();
    }
}
