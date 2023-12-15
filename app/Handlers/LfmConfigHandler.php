<?php

namespace App\Handlers;

use App\Models\Hotels;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Auth, File, Request, Storage;

class LfmConfigHandler
{
    public function userField()
    {
        $hotelId = request('hotelId');
        $url = parse_url(url()->current(), PHP_URL_PATH);
        $urlExp = explode('/', $url);

        if (Auth::guard('user')->check() || Auth::guard('admin')->check()) {
            if ($hotelId) {
                if ($urlExp['1'] == 'admin') {
                    if (!File::exists('uploads/images/hotel_' . $hotelId)) {
                        Storage::disk('uploads')->makeDirectory('images/hotel_' . $hotelId);
                    }
                    return 'hotel_' . $hotelId;
                } else {
                    $user = Auth::guard('user')->user();
                    $hotelModel = Hotels::findOrFail($hotelId);
                    if ($hotelModel->user_id == $user->id) {
                        if (!File::exists('uploads/images/hotel_' . $hotelId)) {
                            Storage::disk('uploads')->makeDirectory('images/hotel_' . $hotelId);
                        }
                        return 'hotel_' . $hotelId;
                    } else {
                        return 'user_' . $user->id;
                    }
                }
            } else {
                if (Auth::guard('admin')->check()) {
                    return 'other';
                } else {
                    $user = Auth::guard('user')->user();
                    return 'user_' . $user->id;
                }
            }
        } else {
            if (Auth::guard('customer')->check()) {
                $customer = Auth::guard('customer')->user();
                return 'customer_' . $customer->id;
            } else {
                abort(403);
            }
        }
    }
}
