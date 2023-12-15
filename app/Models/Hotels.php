<?php

namespace App\Models;

use App\Models\Countries;
use App\Models\Timezones;
use Illuminate\Support\Facades\Hash;
use Luilliarcec\LaravelUsernameGenerator\Facades\Username;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Emadadly\LaravelUuid\Uuids; 
use Illuminate\Database\Eloquent\Model;
use App\Models\Stripe\StripeProduct, App\Models\Stripe\StripeAccount;
use Illuminate\Support\Facades\Config;
use Plank\Mediable\Mediable;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\{HasSlug, SlugOptions, HasTranslatableSlug};
use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Support\Facades\Auth;


class Hotels extends Model
{
    use Favoriteable, HasTranslations, HasTranslatableSlug, Uuids, Mediable;
    use StripeProduct, StripeAccount, RevisionableTrait;

    public $translatable = ['name', 'slug', 'description', 'gift_description', 'property_description'];
    protected $table = 'hotels';
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'stripe_data' => 'array'
    ];
    protected $appends = ['priceCents', 'price', 'priceFormatted', 'timezone', 'stripeAccountId', 'stripeProductId', 'stripePriceId'];
    protected $stripe_tags = ['product_id', 'price_id'];
    protected $revisionCleanup = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    protected $keepRevisionOf = ['name', 'description', 'address'];
    protected $dontKeepRevisionOf = ['created_at', 'updated_at', 'deleted_at', 'stripe_data'];

    public function features()
    {
        return $this->belongsToMany('App\Models\Features', 'App\Models\HotelFeatures', 'hotel_id', 'feature_id');
    }

    public function getUnavailableDates()
    {
        return $this->hasMany('App\Models\HotelUnavailableDates', 'hotel_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Documents', 'hotelId');
    }

    public function removeUnavailableDates()
    {
        $list = HotelUnavailableDates::where('hotel_id', $this->id)->get();
        foreach ($list as $data) {
            $data->delete();
        }
        return true;
    }

    public function removeAllFeatures()
    {
        $features = $this->features()->get();
        if ($features->count() > 0) {
            foreach ($features as $feature) {
                $f = HotelFeatures::where('feature_id', $feature->id)->where('hotel_id', $this->id)->get();
                if ($f->count() > 0) {
                    $f->first()->delete();
                }
            }
        }
        return true;
    }

    public function setFeatures($features)
    {
        if ($features) {
            if (count($features) > 0) {
                HotelFeatures::whereIn('feature_id', $features)->where('hotel_id', $this->id)->delete();
                foreach ($features as $feature) {
                    $newHotelFeature = new HotelFeatures();
                    $newHotelFeature->hotel_id = $this->id;
                    $newHotelFeature->feature_id = $feature;
                    $newHotelFeature->save();
                }
            }
        }
        return true;
    }

    public function setHotelUsers($users)
    {
        if ($users) {
            if (count($users) > 0) {
                foreach ($users as $user) {
                    if (isset($user['id'])) {
                        $checkUser = User::where('id', $user['id'])->get();
                        if ($checkUser->count() > 0) {
                            $hotelUser = $checkUser->first();

                            $emailCheck = User::where('email', $user['email'])->where('id', '<>', $user['id'])->get()->count();
                            if ($emailCheck > 0) {
                                return false;
                            }
                            $hotelUser->firstname = $user['firstname'];
                            $hotelUser->lastname = $user['lastname'];
                            $hotelUser->email = $user['email'];
                            if (isset($user['password'])) {
                                $hotelUser->password = Hash::make($user['password']);
                            }
                            $hotelUser->save();
                            return true;
                        } else {
                            $newHotelUser = new User();
                            $newHotelUser->firstname = $user['firstname'];
                            $newHotelUser->lastname = $user['lastname'];
                            $newHotelUser->name = $user['firstname'] . ' ' . $user['lastname'];
                            $newHotelUser->email = $user['email'];
                            $newHotelUser->username = Username::make($user['firstname'] . ' ' . $user['lastname']);
                            $newHotelUser->password = Hash::make($user['password']);
                            $newHotelUser->enabled = 1;
                            $newHotelUser->save();
                            $this->user_id = $newHotelUser->id;
                            $this->save();
                            return true;
                        }
                    } else {
                        $newHotelUser = new User();
                        $newHotelUser->firstname = $user['firstname'];
                        $newHotelUser->lastname = $user['lastname'];
                        $newHotelUser->name = $user['firstname'] . ' ' . $user['lastname'];
                        $newHotelUser->email = $user['email'];
                        $newHotelUser->username = Username::make($user['firstname'] . ' ' . $user['lastname']);
                        $newHotelUser->password = Hash::make($user['password']);
                        $newHotelUser->enabled = 1;
                        $newHotelUser->save();
                        $this->user_id = $newHotelUser->id;
                        $this->save();
                        return true;
                    }

                }
            }
        }
        return true;
    }

    public function setUnavailableDates($dates)
    {
        if ($dates) {
            $dates = explode(',', $dates);
            if (count($dates) > 0) {
                HotelUnavailableDates::where('hotel_id', $this->id)->delete();
                foreach ($dates as $date) {
                    $newUnavailableDate = new HotelUnavailableDates();
                    $newUnavailableDate->hotel_id = $this->id;
                    $newUnavailableDate->date = $date . ' 00:00';
                    $newUnavailableDate->save();
                }
            }
        }
        return true;
    }

    public function setUnavailableDatesHotel($dates)
    {
       $hotel = Hotels::where('user_id', Auth::guard('user')->user()->id)->select('id')->get();
        // HotelUnavailableDates::where('hotel_id',  $hotel[0]->id)->delete();
        foreach ($dates as $date) {
            $deleted =  HotelUnavailableDates::where('date', $date[0])->where('hotel_id', $hotel[0]->id)->delete();
                if(!$deleted){
                $newUnavailableDate = new HotelUnavailableDates();
                $newUnavailableDate->hotel_id =  $hotel[0]->id;
                $newUnavailableDate->date = $date[0];
                $newUnavailableDate->save();
            }
        }

        return true;
    }

    public function hotel_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function countries()
    {
        return $this->hasMany('App\Models\Countries', 'id', 'country_id');
    }

    public function unavailableDates()
    {
        return $this->hasMany('App\Models\HotelUnavailableDates', 'id', 'hotel_id');
    }

    public function checkFeature($id)
    {
        $check = $this->features()->where('feature_id', $id)->get()->count();
        if ($check > 0) {
            return true;
        }
        return false;
    }

    public function getCode()
    {
        return $this->countries()->get()->first()->code;
    }

    public function cities()
    {
        return $this->countries()->get()->first()->states()->get()->first()->cities();
    }

    public function reservations()
    {
//        return $this->hasMany('App\Models\Reservation', 'hotel_id', 'id');
//        return $this->belongsToMany('App\Models\Features', 'App\Models\HotelFeatures', 'hotel_id', 'feature_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /* Eski görsel fonksiyonları */

    public function getGalleryUploadDir()
    {
        return $this->getUploadDir();
    }

    public function getGalleryWebImages()
    {
        if (null === $this->imgallery) {
            return [];
        }

        $imgallery = $this->imgallery;

        $paths = [];
        if (!empty($imgallery)) {
            $imgallery = unserialize($imgallery);
            if (is_array($imgallery)) {
                foreach ($imgallery as $image) {
                    if (substr(getenv('APP_ENV'), 0, 5) == "local") {
                        $paths[] = ['path' => asset(config('image.placeholder'))];
                    } else {
                        $paths[] = ['path' => $image];
                    }
                }
            }
        }

        return $paths;
    }

    public function getGalleryImagesForStripe()
    {
        $gal = $this->getGalleryWebImages();
        $ng = [];
        foreach ($gal as $arr) {
            $ng[] = array_values($arr);
        }
        return \App\Helpers::array_flatten($ng);
    }

    public function getUploadDir(): string
    {
        return 'uploads/imhotel/' . $this->guid[0] . '/' . $this->guid[1] . '/' . $this->guid;
    }

    public function getWebPath($imgname)
    {
        return null === $this->{$imgname} ? null : config('app.staging_url') . $this->getUploadDir() . '/' . $this->{$imgname};
    }

    public function getWebPathOld($imgname)
    {
        return config('app.staging_url') . $this->getUploadDir() . '/' . $imgname;
    }

    public function getImageUrl($imgname)
    {
        if (config('app.env') == 'local') {
//      if (getenv('APP_ENV') == "local") {
            return asset(config('image.placeholder'));
        } else {
            return $this->{$imgname};
        }
    }

    public function getGalleryImagesUrl()
    {
        if (null === $this->imgallery) {
            return [];
        }

        $imgallery = $this->imgallery;

        $paths = [];
        if (!empty($imgallery)) {
            $imgallery = unserialize($imgallery);
            if (is_array($imgallery)) {
                foreach ($imgallery as $image) {
                    $paths[] = ['path' => $image];
                }
            }
        }

        return $paths;
    }

    public function getIsVerified()
    {
        return $this->is_verified;
    }

    public function getPropertyTypes()
    {
        $categories = [];
        if (!empty($this->categories)) {
            if (is_array($this->categories)) {
                foreach ($this->categories as $cat) {
                    $categories[] = HotelCategories::where('id', $cat)->get();
                }
            }
        }
        return $categories;
    }

    public function getPropertyCheckinCheckout()
    {
        if (!empty($this->property_checkin) && !empty($this->property_checkout)) {
            return trans('Check-in') . ' ' . $this->property_checkin . ' - ' . trans('Check-out') . ' ' . $this->property_checkout;
        }
        return false;
    }

    public function getBoardFoodAllowance()
    {
        $boardFood = Features::where('id', $this->board_food_allowance_id)->get()->first();
        return $boardFood->name;
    }

    public function getCountryName()
    {
        $country = Countries::where('id', $this->country_id)->get()->first();
        if ($country) {
            return $country->name;
        }
        return '';
    }

    public function getCurrencyNameAttribute()
    {
        $country = Countries::where('id', $this->country_id)->get()->first();
        if ($country) {
            return $country->currency_name;
        }
        return '';
    }

    public function getCurrencyCodeAttribute()
    {
        $country = Countries::where('id', $this->country_id)->get()->first();
        if ($country) {
            return $country->currency;
        }
        return '';
    }

    public function getCurrencySymbolAttribute()
    {
        $country = Countries::where('id', $this->country_id)->get()->first();
        if ($country) {
            return $country->currency_symbol;
        }
        return '';
    }

    public function getCityName()
    {
        /* TODO: Bu kısım ile ilgili güncelleme gerçekleştirilecek.
         * $city = Cities::where('id', $this->city)->get()->first();
        if ($city) {
            return $city->name . ',';
        }*/
        return $this->city;
    }

    public function getStar()
    {
        if ($this->star_id != 6) {
            return $this->star_id;
        }
        return '-';
    }

    public function getStarHtml()
    {
        if ($this->star_id != 6) {
            return '<div class="stars stars_' . $this->star_id . '"><span>&nbsp;</span></div>';
        }
        return '<div class="stars stars_0"><span>&nbsp;</span></div>';
    }

    public function setSkuAndPassword($sku)
    {
        $this->sku = $sku;
        $this->save();
        $hotelUser = $this->hotel_user()->get()->first();
        if ($hotelUser) {
            $hotelUser->setPassword($sku);
            $hotelUser->save();
        }
    }

    public function getStripeAccountIdAttribute()
    {
        return $this->stripe_data['account_sid'] ?? null;
    }

    public function setStripeAccountIdAttribute($id)
    {
        $this->saveStripeData(['account_sid' => $id]);
    }

    public function getStripeProductIdAttribute()
    {
        return $this->stripe_data['product_sid'] ?? null;
    }

    public function setStripeProductIdAttribute($id)
    {
        $this->saveStripeData(['product_sid' => $id]);
    }

    public function getStripePriceIdAttribute()
    {
        return $this->stripe_data['price_sid'] ?? null;
    }

    public function setStripePriceIdAttribute($id)
    {
        $this->saveStripeData(['price_sid' => $id]);
    }

    public function getTimeZoneAttribute()
    {
        $timezone = Timezones::where('countrycode',
            Countries::convert('code', ['id' => $this->country_id]))->get();
        if ($timezone->count() > 0) {
            return $timezone->first()->offsets[0] ? $timezone->first()->offsets[0] : null;
        } else {
            return null;
        }
    }

    public function getPriceCentsAttribute()
    {
        return $this->attributes['price'] ?? 0;
    }

    public function setPriceCentsAttribute($val)
    {
        $this->attributes['price'] = $val;
        $this->save();
    }

    public function getPriceFormattedAttribute()
    {
        return $this->price . ' ' . $this->currencySymbol;
    }

    public function setPriceFormattedAttribute($val)
    {
        $this->attributes['price'] = floatval($val) * 100;
        $this->save();
    }

    public function getPriceAttribute()
    {
        return isset($this->attributes['price']) ? $this->attributes['price'] / 100 : 0;
    }

    public function saveStripeData($in)
    {
        $new = [];
        var_dump('stripe_data is '.gettype($this->stripe_data));
        if(gettype($this->stripe_data) === 'string'){
            $this->stripe_data = [];
            $old = [];
        }
        if(gettype($this->stripe_data) === 'array'){
            $old = $this->stripe_data;
            foreach ($old as $key => $val) {
                if( ($key === 'price_id' && substr($val, 0, 6) === 'price_') ||
                    ($key === 'product_id' && substr($val, 0, 5) === 'prod_')) {
                    // unset($old[$key]);
                }else{
                    $new[$key] = $val;
                }
            }
            $this->attributes['stripe_data'] = json_encode(array_merge($new, $in ?? []));
            $this->save();
        }
    }

    public function checkSync()
    {
        $this->attributes['is_enabled'] = is_null($this->stripeProductId) ? 0 : 1;
    }
}
