<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Favorite;
use App\Models\FeatureGroups;
use App\Models\Features;
use App\Models\HotelCategories;
use App\Models\Hotels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
class DestinationsController extends Controller
{
    public function destinations(Request $request)
    {
        $query = $request->q;
        $filters = [];
        $hotelsQuery = Hotels::query();

        $hotelsQuery = $hotelsQuery->where('is_verified', '=', 1);

        if ($request->filter_on == 1) {
            if ($request->type) {
                foreach ($request->filter as $key => $value) {
                    if ($value['name'] == "filter[]") {
                        array_push($filters, $value['value']);
                    }
                }
            } else {
                $filters = $request->filter;
            }

            if (isset($request->filter)) {

                /*$hotelsQuery = Hotels::whereDoesntHave('features', function ($q) use ($filters) {
                    $q->whereIn('feature_id', $filters);
                })->orderBy('created_at', 'desc');*/
                $stars = [];
                foreach ($filters as $filter) {
                    $filterData = Features::where('id', $filter)->get();
                    if ($filterData->count() > 0) {
                        $filterData = $filterData->first();
                        if ($filterData->type == "star") {
                            $stars[] = $filterData->oldID;
                        }
                    }
                }
                if (count($stars) > 0) {
                    $hotelsQuery = $hotelsQuery->whereIn('star_id', $stars);
                }
                if (count($filters) > 0) {
                    $filtersData = [];
                    foreach ($filters as $filter) {
                        $feature = Features::where('id', $filter)->get();
                        if ($feature->count() > 0) {
                            $feature = $feature->first();
                            if ($feature->type != "star") {
                                $filtersData[] = $filter;
                            }
                        }
                    }
                    if (count($filtersData) > 0) {
                        $hotelsQuery = $hotelsQuery->whereDoesntHave('features', function ($q) use ($filtersData) {
                            foreach ($filtersData as $filter) {
                                $q->where('feature_id', $filter);
                            }
                        });
                    }
                }
            }
            $hotelsQuery = $hotelsQuery->orderBy('created_at', 'desc');

            $min_price = ($hotelsQuery->min('price')) ?: 0;
            $max_price = ($hotelsQuery->max('price')) ?: 100;

            $start_price = $request->start_price;
            $end_price = $request->end_price;

            if (!$start_price == 1 && $end_price == 1000) {
                $hotelsQuery->whereBetween('price', [($start_price * 100), ($end_price * 100)]);
            }

            if ($query != "" && trim($query) !== '') {
                $hotelsQuery->where('name', 'like', '%' . trim($query) . '%');
                $hotelsQuery->orWhere('description', 'like', '%' . trim($query) . '%');
            }

            $hotels = $hotelsQuery->orderBy('created_at', 'desc')->paginate(12)->appends(request()->query());
        } else {
            if ($query != "" && trim($query) !== '') {
                $hotelsQuery->where('name', 'like', '%' . trim($query) . '%');
                $hotelsQuery->orWhere('description', 'like', '%' . trim($query) . '%');
            }

            $min_price = 1;
            $max_price = 1000;
            $start_price = $min_price;
            $end_price = $max_price;

            $hotels = $hotelsQuery->orderBy('created_at', 'desc')->paginate(12);
        }

        $total_records = $hotelsQuery->count();
        $total_pages = $hotels->lastPage();
        $current_page = $request->current_page;

        if ($request->type) {
            $hotelArray = [];
            foreach ($hotels as $key => $value) {
                $properties = [];

                foreach ($value->getPropertyTypes() as $property_type) {
                    if (!is_null($property_type[0]->getCategoryRedIconWebPath())) {
                        array_push($properties, array(
                            'icon' => $property_type[0]->getCategoryRedIconWebPath(),
                            'name' => str_replace(' Hotel', '', $property_type[0]->name)
                        ));
                    }
                }

                $boardFoodExp = explode(' (', $value->getBoardFoodAllowance());
                if (count($boardFoodExp) > 0) {
                    $category = $boardFoodExp[0];
                    $boardInfo = $boardFoodExp[0];
                } else {
                    $category = $value->getBoardFoodAllowance();
                    $boardInfo = $boardFoodExp[1];
                }

                // $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
                // $favorited = Favorite::where('user_id', $user->id)->where('favoriteable_id', $value->id)->get();

                $auth = Auth::guard('customer')->user();
                $customer = Customers::findOrFail($auth->id);
                $hotel = Hotels::findOrFail($value->id);

                array_push($hotelArray, array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'slug' => $value->slug,
                    'url' => route('f.detail', ['slug' => $value->slug, 'id' => $value->id]),
                    'imdImage_desktop' => $value->getImageUrl('imdlisting') ? $value->getImageUrl('imdlisting') : 'https://dummyimage.com/200x170',
                    'imdImage_mobile' => $value->getImageUrl('imdlisting') ? $value->getImageUrl('imdlisting') : 'https://dummyimage.com/200x170',
                    'star' => $value->getStarHtml(),
                    'city' => $value->getCityName(),
                    'country' => $value->getCountryName(),
                    'verified' => $value->getIsVerified() ? $value->getIsVerified() : "",
                    'properties' => $properties,
                    'category' => $category,
                    'boardInfo' => $boardInfo,
                    'boardFood' => isset($boardFoodExp[1]) ? $boardFoodExp[1] : "",
                    'price' => \App\Helpers::localizedCurrency($value->price),
                    'heartIcon' =>  $customer->hasFavorited($hotel) ?  asset('front/assets/images/svg/heart-white.png') : asset('front/assets/images/svg/heart-white-empty.png'),
                    'isFavourited' => $customer->hasFavorited($hotel) ? 1 : 0,
                    'arrowIcon' => asset('front/assets/images/svg/arrow.svg'),
                    'wishListUrl' => route('f.add-to-wishlist', ['id' => $value->id]),
                    'perPerson' => trans("txt.per_person_per_day"),
                    'is_verified' => $value->is_verified,
                ));
            }

            $hotelData = json_encode($hotelArray);

            return response()->json(['success' => 'Hotels filter success!', 'hotels' => compact('hotelData', 'query', 'current_page', 'total_records', 'total_pages', 'min_price', 'max_price', 'start_price', 'end_price')]);
        } else {
            return view('front.destinations', compact('hotels', 'query', 'current_page', 'total_records', 'total_pages', 'min_price', 'max_price', 'start_price', 'end_price', 'filters'));
        }
    }

    // !TODO: Kategori filtre kısmınıda yeni yapıya uygun şekilde güncellenmeli
    public function category($slug, Request $request)
    {
        if ($slug == "") {
            return redirect(route('f.destinations'));
        }
        $category = HotelCategories::where('slug->' . App::getLocale(), $slug)->get();

        if ($category->count() == 0) {
            return redirect(route('f.destinations'));
        }
        $category = $category->first();

        $query = $request->q;
        $filters = [];
        if ($request->filter_on == 1 && isset($request->filter)) {
            $filters = $request->filter;

            $hotelsQuery = Hotels::whereDoesntHave('features', function ($q) use ($filters) {
                $q->whereIn('feature_id', $filters);
            })->where('categories', 'like', '%' . $category->id . '%')->orderBy('created_at', 'desc');

            $min_price = $hotelsQuery->min('price');
            $max_price = $hotelsQuery->max('price');

            $start_price = ($request->start_price) ? $request->start_price : $min_price;
            $end_price = ($request->end_price) ? $request->end_price : $max_price;

            $hotelsQuery->where('price', '>=', $start_price)->where('price', '<=', $end_price);

            if ($query != "" && trim($query) !== '') {
                $hotelsQuery->where('name', 'like', '%' . trim($query) . '%');
                $hotelsQuery->orWhere('description', 'like', '%' . trim($query) . '%');
                //                $cities = Cities::where('name', 'like', '%' . trim($query) . '%')->get()->first()->states()->get()->first()->countries()->get();
            }

            $hotels = $hotelsQuery->paginate(12)->appends(request()->query());
        } else {
            $hotelsQuery = Hotels::where('categories', 'like', '%' . $category->id . '%')->orderBy('created_at', 'desc');

            $min_price = $hotelsQuery->min('price');
            $max_price = $hotelsQuery->max('price');
            $start_price = $min_price;
            $end_price = $max_price;

            if ($query != "" && trim($query) !== '') {
                $hotelsQuery->where('name', 'like', '%' . trim($query) . '%');
                $hotelsQuery->orWhere('description', 'like', '%' . trim($query) . '%');
                //                $cities = Cities::where('name', 'like', '%' . trim($query) . '%')->get()->first()->states()->get()->first()->countries()->get();
            }

            $hotels = $hotelsQuery->paginate(12);
        }


        $total_records = $hotels->total();
        $total_pages = $hotels->lastPage();
        $current_page = $hotels->currentPage();

        return view('front.destinations', compact('hotels', 'query', 'current_page', 'total_records', 'total_pages', 'min_price', 'max_price', 'start_price', 'end_price', 'filters'));
    }
}
