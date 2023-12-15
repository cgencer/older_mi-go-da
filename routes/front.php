<?php

use App\Http\Controllers\Controller;
use Illuminate\Routing\Router as Router;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


Route::get('/lang/{lang}', [
    'uses' => 'LanguageController@switchLang',
    'as' => 'lang.switch',
    'middleware' => ['language']
]);
Route::get('/stripeWebHooks', [
    'uses' => 'StripeNotifications@receiveHook',
    'as' => 'stripeWebHooks'
]);
Route::stripeWebhooks('stripeWebHooks');
Route::get('/info', function(){ phpinfo(); });

Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});

// MigodaHotels post
Route::post('/join-for-free', [
    'uses' => 'Frontend\GeneralController@joinForFree'
]);

Route::group(
    ['namespace' => 'Frontend', 'as' => 'f.', 'middleware' => ['language']], function (Router $router) {
    $router->get('/', [
        'uses' => 'PageController@index',
        'as' => 'index'
    ]);
    $router->get('/about', [
        'uses' => 'PageController@about',
        'as' => 'about'
    ]);
    /* $router->get('/terms-and-conditions', [
         'uses' => 'PageController@termsAndConditions',
         'as' => 'terms-and-conditions'
     ]);*/
    $router->get('/how-it-works', [
        'uses' => 'PageController@howItWorks',
        'as' => 'how-it-works'
    ]);

    $router->get('/onboarding', [
        'uses' => 'PageController@onboarding',
        'as' => 'onboarding'
    ]);
    $router->post('/onboarding', [
        'uses' => 'PageController@onboarding',
        'as' => 'onboarding.post'
    ]);
    $router->get('/onboardLink', [
        'uses' => 'PageController@onboarding',
        'as' => 'onboardLink'
    ]);


    $router->post('/createHotelAccount', [
        'uses' => 'StripeAPIAdvanced@createHotelAccount',
        'as' => 'createHotelAccount'
    ]);


    $router->get('/faq', [
        'uses' => 'PageController@faq',
        'as' => 'faq'
    ]);
    $router->get('/data-privacy', [
        'uses' => 'PageController@data_privacy',
        'as' => 'data-privacy'
    ]);
    $router->get('/contact', [
        'uses' => 'PageController@contact',
        'as' => 'contact'
    ]);
    $router->post('/contact', [
        'uses' => 'PageController@postContact',
        'as' => 'contact.post'
    ]);

    $router->group(['middleware' => ['auth.customer']], function (Router $router) {
        $router->get('/hooks', [
            'uses' => 'webHooks@hooks',
            'as' => 'hooks'
        ]);
    });

    $router->get('/detail-preview/{slug}_{id}', [
        'uses' => 'GeneralController@hotelPreview',
        'as' => 'detail-preview'
    ])->middleware('auth.hotel_preview');

    $router->group(['middleware' => ['auth.customer']], function (Router $router) {
        $router->get('/destinations', [
            'uses' => 'DestinationsController@destinations',
            'as' => 'destinations'
        ]);
        $router->get('/getHotels', [
            'uses' => 'DestinationsController@getHotels',
            'as' => 'getHotels'
        ]);
        $router->get('/category/{slug}', [
            'uses' => 'DestinationsController@category',
            'as' => 'category'
        ]);
        $router->get('/detail/{slug}_{id}', [
            'uses' => 'GeneralController@detail',
            'as' => 'detail'
        ]);
        $router->get('/add-to-wishlist/{id}', [
            'uses' => 'UserWishlistController@ajaxToggleFavorite',
            'as' => 'add-to-wishlist'
        ]);
        $router->get('/book', [
            'uses' => 'ReservationController@book',
            'as' => 'book'
        ]);
        $router->post('/bookAction', [
            'uses' => 'ReservationController@bookAction',
            'as' => 'bookAction'
        ]);
        $router->post('/payment', [
            'uses' => 'ReservationController@prepareForPayment',
            'as' => 'payment'
        ])->middleware('auth.customer');

        $router->post('/charge', [
            'uses' => 'ReservationController@charge',
            'as' => 'charge'
        ])->middleware('auth.customer');

        $router->post('/paymentOnHold', [
            'uses' => 'ReservationController@paymentOnHold',
            'as' => 'paymentOnHold'
        ])->middleware('auth.customer');

        $router->get('/success/{uuid}', [
            'uses' => 'ReservationController@success',
            'as' => 'success'
        ])->middleware('auth.customer');

        $router->get('/invoice/{uuid}', [
            'uses' => 'ReservationController@generate_invoice',
            'as' => 'invoice'
        ])->middleware('auth.customer');

        $router->get('/reservation/{uuid}', [
            'uses' => 'ReservationController@getReservation',
            'as' => 'reservation'
        ])->middleware('auth.customer');

        $router->get('/cancellation/{uuid}', [
            'uses' => 'ReservationController@doCancel',
            'as' => 'cancellation'
        ])->middleware('auth.admin');

        $router->post('/customerPortal', [
            'uses' => 'ReservationController@customerPortal',
            'as' => 'customerPortal'
        ])->middleware('auth.customer');

        $router->post('/return-from-customer-portal', [
            'uses' => 'ReservationController@returnFromCustomerPortal',
            'as' => 'returnFromCustomerPortal'
        ])->middleware('auth.customer');


// these need to be removed before prod
        $router->post('/changeStatus', [
            'uses' => 'ReservationController@changeReservation',
            'as' => 'changeStatus'
        ])->middleware('auth.customer');
// until here...

        $router->get('/payment-complete/{sessionId}/{uuid}', [
            'uses' => 'ReservationController@postPayment',
            'as' => 'payment-complete'
        ])->middleware('auth.customer');


        // Testing Route
        $router->get('/testing-route', [
            'uses' => 'GeneralController@testFunction',
            'as' => 'testing-route'
        ])->middleware('auth.customer');
    });
});
Route::group(
    ['as' => 'auth.', 'namespace' => 'Frontend', 'middleware' => ['language']], function (Router $router) {
    $router->get('/logout', [
        'uses' => 'AuthController@getLogout',
        'as' => 'logout'
    ]);
    $router->get('/login', [
        'uses' => 'AuthController@getLogin',
        'as' => 'login'
    ]);
    $router->post('/login', [
        'uses' => 'AuthController@postLogin',
        'as' => 'login.post'
    ]);
    $router->get('/register', [
        'uses' => 'AuthController@getRegister',
        'as' => 'register'
    ]);
    $router->post('/register', [
        'uses' => 'AuthController@postRegister',
        'as' => 'register.post'
    ]);
    $router->get('/activeAccount/{code}', [
        'uses' => 'AuthController@activeAccount',
        'as' => 'active.account'
    ]);

    $router->get('/reset-password', [
        'uses' => 'AuthController@getResetPassword',
        'as' => 'reset_password'
    ]);
    $router->post('/reset-password', [
        'uses' => 'AuthController@postResetPassword',
        'as' => 'reset_password.submit'
    ]);

    $router->get('/profile', [
        'uses' => 'AuthController@getProfile',
        'as' => 'profile'
    ])->middleware('auth.customer');
    $router->post('/profile', [
        'uses' => 'AuthController@postProfile',
        'as' => 'postProfile'
    ])->middleware('auth.customer');

    $router->get('/password', [
        'uses' => 'AuthController@getPassword',
        'as' => 'password'
    ])->middleware('auth.customer');
    $router->post('/password', [
        'uses' => 'AuthController@postPassword',
        'as' => 'postPassword'
    ])->middleware('auth.customer');
    $router->get('/password-reset', [
        'uses' => 'AuthController@createNewPassword',
        'as' => 'create_new_password'
    ]);
    $router->post('/password-reset', [
        'uses' => 'AuthController@saveNewPassword',
        'as' => 'create_new_password.submit'
    ]);
    $router->get('/wishlist', [
        'uses' => 'AuthController@getWishlist',
        'as' => 'wishlist'
    ])->middleware('auth.customer');

    $router->get('/reservation-status', [
        'uses' => 'AuthController@getWaitingConfirmation',
        'as' => 'reservation-status'
    ])->middleware('auth.customer');

    $router->post('/reservation-status', [
        'uses' => 'AuthController@getWaitingConfirmation',
        'as' => 'reservation-status.submit'
    ])->middleware('auth.customer');

    $router->get('/bookings', [
        'uses' => 'AuthController@getTravelHistory',
        'as' => 'bookings'
    ])->middleware('auth.customer');
    $router->get('/pay-now', [
        'uses' => 'AuthController@getPays',
        'as' => 'pay-now'
    ])->middleware('auth.customer');

    $router->get('/account-settings', [
        'uses' => 'AuthController@getAccountSettings',
        'as' => 'account-settings'
    ])->middleware('auth.customer');
    $router->post('/account-settings/save', [
        'uses' => 'AuthController@setAccountSettings',
        'as' => 'account-settings-save'
    ])->middleware('auth.customer');
    $router->post('/delete-account', [
        'uses' => 'AuthController@deleteAccountNotify',
        'as' => 'delete-account'
    ])->middleware('auth.customer');
    $router->get('/delete-account-confirm', [
        'uses' => 'AuthController@deleteAccountConfimation',
        'as' => 'delete-account-confirm'
    ]);


    $router->get('/security', [
        'uses' => 'AuthController@getSecurity',
        'as' => 'security'
    ])->middleware('auth.customer');

    $router->get('/subscriptions', [
        'uses' => 'AuthController@getSubscriptions',
        'as' => 'subscriptions'
    ])->middleware('auth.customer');

    $router->get('/language', [
        'uses' => 'AuthController@getLanguage',
        'as' => 'language'
    ])->middleware('auth.customer');

    $router->post('/language/save', [
        'uses' => 'AuthController@setLanguage',
        'as' => 'language.save'
    ])->middleware('auth.customer');


    // setAccountSettings

    $router->get('/sheets', [
        'uses' => 'AuthController@getSheets',
        'as' => 'sheets'
    ])->middleware('auth.customer');

    $router->post('/sheets', [
        'uses' => 'GoogleSheet@boot',
        'as' => 'sheets.boot'
    ])->middleware('auth.customer');

});
Route::group(
    ['as' => 'coupon.', 'namespace' => 'Frontend', 'middleware' => ['language', 'auth.customer']], function (Router $router) {
    $router->get('/coupon/add-coupon', [
        'uses' => 'CouponController@addCouponAjax',
        'as' => 'add-coupon.ajax'
    ]);
    $router->get('/coupon/get-coupons', [
        'uses' => 'CouponController@getCouponsAjax',
        'as' => 'get-coupons.ajax'
    ]);
    $router->get('/coupon/check-coupons', [
        'uses' => 'CouponController@checkCouponsAjax',
        'as' => 'check-coupons.ajax'
    ]);
});

/* Dynamic Pages */
if (DB::connection()->getDatabaseName()) {
    if (Schema::hasTable('pages')) {
        $pages = Cache::remember('pages', 5, function () {
            return \App\Models\Pages::all()->pluck('slug');
        });
        if ($pages) {
            foreach ($pages as $page) {
                Route::get('/{slug}', ['as' => 'f.' . $page, 'uses' => 'Frontend\PageController@getPage']);
            }
        }
    }
}
