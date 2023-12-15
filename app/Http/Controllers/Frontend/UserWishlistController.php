<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Hotels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserWishlistController extends Controller
{
    public function ajaxToggleFavorite($id)
    {
        if ($id) {
            $auth = Auth::guard('customer')->user();
            $customer = Customers::findOrFail($auth->id);
            $hotel = Hotels::findOrFail($id);

            if (!$hotel || !$customer) {
                return Response::json(array('result' => false, 'added' => false, 'removed' => false));
            }
            if ($customer->hasFavorited($hotel)) {
                $customer->unfavorite($hotel);
                return Response::json(array('result' => true, 'added' => false, 'removed' => true));
            } else {
                $customer->favorite($hotel);
                return Response::json(array('result' => true, 'added' => true, 'removed' => false));
            }
        }

        return Response::json(array('result' => false));
    }
}
