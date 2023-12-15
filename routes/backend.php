<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Middlewares\CreateDefaultFolder;
use UniSharp\LaravelFilemanager\Middlewares\MultiUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Admin
 */
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function (Router $router) {
    # Login
    $router->get('login', ['as' => 'auth.login', 'uses' => 'AuthController@getLogin']);
    $router->post(
        'login', [
        'as' => 'auth.login.post',
        'uses' => 'AuthController@postLogin',
        'middleware' => ['XSS']
    ]);
    # Reset password // !TODO yapılacak
    /*    $router->get('reset', ['as' => 'auth.reset', 'uses' => 'AuthController@getReset']);
        $router->post('reset', ['as' => 'reset.post', 'uses' => 'AuthController@postReset']);
        $router->get('reset/{id}/{code}', ['as' => 'reset.complete', 'uses' => 'AuthController@getResetComplete']);
        $router->post('reset/{id}/{code}', ['as' => 'reset.complete.post', 'uses' => 'AuthController@postResetComplete']);*/

    Route::group(['middleware' => 'auth.admin'], function (Router $router) {
        # Logout
        $router->get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
        # Dashboard
        $router->get(
            '/', [
            'as' => 'index',
            'uses' => 'DashboardController@index',
        ]);
        $router->get(
            '/dashboard', [
            'as' => 'dashboard',
            'uses' => 'DashboardController@index'
        ]);
        $router->get(
            '/settings', [
            'as' => 'settings',
            'uses' => 'SettingsController@index'
        ]);
        $router->post(
            '/settings/save', [
            'as' => 'settings.save',
            'uses' => 'SettingsController@save',
        ]);
        $router->get(
            '/calendar', [
            'as' => 'calendar',
            'uses' => 'DashboardController@calendar'
        ]);

        # File Manager Page
        $router->get(
            '/file-manager', [
            'as' => 'file-manager',
            'uses' => 'GeneralController@filemanager',
        ]);
        # File Manager
        Route::group(
            ['prefix' => 'filemanager'], function () {
            $middleware = [CreateDefaultFolder::class, MultiUser::class];
            $as = 'unisharp.lfm.';
            $namespace = '\\UniSharp\\LaravelFilemanager\\Controllers\\';

            // upload
            Route::any('/upload', [
                'uses' => 'UploadController@upload',
                'as' => $as . 'upload',
            ]);
            Route::group(compact('middleware', 'as', 'namespace'), function () {

                // display main layout
                Route::get('/', [
                    'uses' => 'LfmController@show',
                    'as' => 'show',
                ]);

                // display integration error messages
                Route::get('/errors', [
                    'uses' => 'LfmController@getErrors',
                    'as' => 'getErrors',
                ]);

                // list images & files
                Route::get('/jsonitems', [
                    'uses' => 'ItemsController@getItems',
                    'as' => 'getItems',
                ]);

                Route::get('/move', [
                    'uses' => 'ItemsController@move',
                    'as' => 'move',
                ]);

                Route::get('/domove', [
                    'uses' => 'ItemsController@domove',
                    'as' => 'domove'
                ]);

                // folders
                Route::get('/newfolder', [
                    'uses' => 'FolderController@getAddfolder',
                    'as' => 'getAddfolder',
                ]);

                // list folders
                Route::get('/folders', [
                    'uses' => 'FolderController@getFolders',
                    'as' => 'getFolders',
                ]);

                // crop
                Route::get('/crop', [
                    'uses' => 'CropController@getCrop',
                    'as' => 'getCrop',
                ]);
                Route::get('/cropimage', [
                    'uses' => 'CropController@getCropimage',
                    'as' => 'getCropimage',
                ]);
                Route::get('/cropnewimage', [
                    'uses' => 'CropController@getNewCropimage',
                    'as' => 'getCropnewimage',
                ]);

                // rename
                Route::get('/rename', [
                    'uses' => 'RenameController@getRename',
                    'as' => 'getRename',
                ]);

                // scale/resize
                Route::get('/resize', [
                    'uses' => 'ResizeController@getResize',
                    'as' => 'getResize',
                ]);
                Route::get('/doresize', [
                    'uses' => 'ResizeController@performResize',
                    'as' => 'performResize',
                ]);

                // download
                Route::get('/download', [
                    'uses' => 'DownloadController@getDownload',
                    'as' => 'getDownload',
                ]);

                // delete
                Route::get('/delete', [
                    'uses' => 'DeleteController@getDelete',
                    'as' => 'getDelete',
                ]);
            });
        });
        # Profile
        Route::group(['prefix' => 'profile', 'as' => 'auth.profile.'], function (Router $router) {
            $router->get(
                '/edit', [
                'as' => 'edit',
                'uses' => 'AuthController@profile',
            ]);
            $router->post(
                '/save', [
                'as' => 'save',
                'uses' => 'AuthController@profileSave',
            ]);
            $router->post(
                '/security/save', [
                'as' => 'security.save',
                'uses' => 'AuthController@profileSecuritySave',
            ]);
        });
        # Feature Categories
        Route::group(['prefix' => 'feature-categories', 'as' => 'feature_categories.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'HotelFeatureCategoriesController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'HotelFeatureCategoriesController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'HotelFeatureCategoriesController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'HotelFeatureCategoriesController@save',
            ]);
            # !TODO yapılacak
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'HotelFeatureCategoriesController@add',
            ]);
            # !TODO yapılacak
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'HotelFeatureCategoriesController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'HotelFeatureCategoriesController@remove',
            ]);
            # !TODO Kategorinin özellik gruplarını listeleme
            $router->get(
                '/{id}/groups', [
                'as' => 'groups',
                'uses' => 'HotelFeatureCategoriesController@groups',
            ]);
            $router->get(
                '/getAjaxGroups', [
                'as' => 'groups.ajax',
                'uses' => 'HotelFeatureCategoriesController@indexAjaxGroups',
            ]);
        });
        # Feature Groups
        Route::group(['prefix' => 'feature-groups', 'as' => 'feature_groups.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'HotelFeaturesGroupsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'HotelFeaturesGroupsController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'HotelFeaturesGroupsController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'HotelFeaturesGroupsController@save',
            ]);
            # !TODO yapılacak
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'HotelFeaturesGroupsController@add',
            ]);
            # !TODO yapılacak
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'HotelFeaturesGroupsController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'HotelFeaturesGroupsController@remove',
            ]);
            # !TODO Gruba ait özellikler
            $router->get(
                '/{id}/features', [
                'as' => 'features',
                'uses' => 'HotelFeaturesController@features',
            ]);
        });
        # Features
        Route::group(['prefix' => 'features', 'as' => 'features.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'HotelFeaturesController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'HotelFeaturesController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'HotelFeaturesController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'HotelFeaturesController@save',
            ]);
            # !TODO yapılacak
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'HotelFeaturesController@add',
            ]);
            # !TODO yapılacak
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'HotelFeaturesController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'HotelFeaturesController@remove',
            ]);
        });
        # Hotels
        Route::group(['prefix' => 'hotels', 'as' => 'hotels.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'HotelsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'HotelsController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'HotelsController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'HotelsController@save',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'HotelsController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'HotelsController@addPost',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'HotelsController@remove',
            ]);
            $router->post(
                '/{id}/invite', [
                'as' => 'invite',
                'uses' => 'HotelsController@inviteHotel',
            ]);
        });
        # Hotel Users
        Route::group(['prefix' => 'users', 'as' => 'users.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'UsersController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'UsersController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'UsersController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'UsersController@save',
            ]);
            # !TODO: Sosyal ağ bağlantıları yönetimi
            $router->post(
                '/{id}/edit/socials', [
                'as' => 'socials.save',
                'uses' => 'UsersController@socialsSave',
            ]);
            $router->post(
                '/{id}/edit/security', [
                'as' => 'security.save',
                'uses' => 'UsersController@securitySave',
            ]);
            # !TODO: Yeni hotel kullanıcısı ekleme
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'UsersController@add',
            ]);
            # !TODO: Yeni hotel kullanıcısı ekleme
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'UsersController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'UsersController@remove',
            ]);
            $router->get(
                '/{id}/hotels', [
                'as' => 'hotels',
                'uses' => 'UsersController@hotels',
            ]);
            $router->get(
                '/{id}/hotels/ajax', [
                'as' => 'hotels.ajax',
                'uses' => 'UsersController@hotelsAjax',
            ]);
        });
        # Customers
        Route::group(['prefix' => 'customers', 'as' => 'customers.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'CustomersController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'CustomersController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'CustomersController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'CustomersController@save',
            ]);
            $router->post(
                '/{id}/edit/security', [
                'as' => 'security.save',
                'uses' => 'CustomersController@securitySave',
            ]);
            # !TODO: Yeni migoda kullanıcısı ekleme
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'CustomersController@add',
            ]);
            # !TODO: Yeni migoda kullanıcısı ekleme
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'CustomersController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'CustomersController@remove',
            ]);
        });
        # Contact Form
        Route::group(['prefix' => 'contact', 'as' => 'contact.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'ContactFormController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'ContactFormController@indexAjax',
            ]);
            $router->get(
                '/{id}/show', [
                'as' => 'show',
                'uses' => 'ContactFormController@show',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'ContactFormController@remove',
            ]);
        });
        # Newsletter Subscriptions
        Route::group(['prefix' => 'newsletter-subscriptions', 'as' => 'newsletter_subscriptions.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'NewslettersController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'NewslettersController@indexAjax',
            ]);
            $router->get(
                '/{id}/show', [
                'as' => 'show',
                'uses' => 'NewslettersController@show',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'NewslettersController@remove',
            ]);
        });
        # Pages
        Route::group(['prefix' => 'pages', 'as' => 'pages.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'PagesController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'PagesController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'PagesController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'PagesController@save',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'PagesController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'PagesController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'PagesController@remove',
            ]);
        });
        # FAQ
        Route::group(['prefix' => 'faq', 'as' => 'faq.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'FaqController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'FaqController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'FaqController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'FaqController@save',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'FaqController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'FaqController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'FaqController@remove',
            ]);
        });
        # Reservations
        Route::group(['prefix' => 'reservations', 'as' => 'reservations.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'ReservationsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'ReservationsController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'ReservationsController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'ReservationsController@save',
            ]);
            $router->get(
                '/{id}/show', [
                'as' => 'show',
                'uses' => 'ReservationsController@show',
            ]);
            $router->get(
                '/updateReservationStatus', [
                'as' => 'setReservationStatus',
                'uses' => 'ReservationsController@setReservationStatus',
            ]);
            $router->get(
                '/{id}/cancel', [
                'as' => 'cancel',
                'uses' => 'ReservationsController@cancelReservation',
            ]);
            $router->get(
                '/testing', [
                'as' => 'testing',
                'uses' => 'ReservationsController@testing'
            ]);
        });
        # Payments
        Route::group(['prefix' => 'payments', 'as' => 'payments.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'PaymentsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'PaymentsController@indexAjax',
            ]);
            $router->get(
                '/{id}/show', [
                'as' => 'show',
                'uses' => 'PaymentsController@show',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'PaymentsController@save',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'PaymentsController@remove',
            ]);
        });
        # Coupon Rules
        Route::group(['prefix' => 'coupon-rules', 'as' => 'coupon-rules.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'CouponRuleController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'CouponRuleController@indexAjax',
            ]);
            $router->post(
                '/getCoupons', [
                'as' => 'index.getCoupons',
                'uses' => 'CouponRuleController@getCoupons',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'CouponRuleController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'CouponRuleController@save',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'CouponRuleController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'CouponRuleController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'CouponRuleController@remove',
            ]);
        });
        # Coupons
        # !INFO Buna bakacağım. Belki olmayabilir mantık gereği.
        /*Route::group(['prefix' => 'coupons', 'as' => 'coupons.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'CouponController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'CouponController@indexAjax',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'CouponController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'CouponController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'CouponController@remove',
            ]);
        });*/
        # Admins
        Route::group(['prefix' => 'admin_users', 'as' => 'admin_users.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'AdminsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'AdminsController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'AdminsController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'AdminsController@save',
            ]);
            $router->post(
                '/{id}/edit/security', [
                'as' => 'security.save',
                'uses' => 'AdminsController@securitySave',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'AdminsController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'AdminsController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'AdminsController@remove',
            ]);
        });


    });
    # Documents
    Route::group(['prefix' => 'documents', 'as' => 'documents.'], function (Router $router) {
        $router->get(
            '/', [
            'as' => 'index',
            'uses' => 'DocumentsController@index',
        ]);
        $router->get(
            '/getAjax', [
            'as' => 'index.ajax',
            'uses' => 'DocumentsController@indexAjax',
        ]);
        $router->post(
            '/store', [
            'as' => 'store',
            'uses' => 'DocumentsController@store',
        ]);
        $router->post(
            '/{id}/update', [
            'as' => 'update',
            'uses' => 'DocumentsController@update',
        ]);
        $router->get(
            '/{id}/edit', [
            'as' => 'edit',
            'uses' => 'DocumentsController@edit',
        ]);
        $router->get(
            '/add/document', [
            'as' => 'add.document',
            'uses' => 'DocumentsController@add',
        ]);
        $router->get(
            '/{id}/remove', [
            'as' => 'remove',
            'uses' => 'DocumentsController@remove',
        ]);
    });
});

/*
 * Hotel
 */
Route::group(
    ['prefix' => 'hotel', 'namespace' => 'Hotel', 'as' => 'hotel_admin.'], function (Router $router) {
    # Login
    $router->get('login', ['as' => 'auth.login', 'uses' => 'AuthController@getLogin']);
    $router->post(
        'login', [
        'as' => 'auth.login.post',
        'uses' => 'AuthController@postLogin',
        'middleware' => ['XSS']
    ]);

    $router->post('/forgot-password', [
        'as' => 'auth.forgot-password.submit',
        'uses' => 'GeneralController@postResetPassword',
        'middleware' => ['XSS']
    ]);

    $router->get('/forgot-password', [
        'as' => 'auth.forgot-password',
        'uses' => 'GeneralController@forgotPassword',
    ]);


    $router->get('/password-reset', [
        'uses' => 'GeneralController@createNewPassword',
        'as' => 'create_new_password'
    ]);
    $router->post('/password-reset', [
        'uses' => 'GeneralController@saveNewPassword',
        'as' => 'create_new_password.submit',
        'middleware' => ['XSS']
    ]);



    # Reset password // !TODO yapılacak
    // $router->get('reset', ['as' => 'auth.reset', 'uses' => 'AuthController@postResetPassword']);
    // $router->post('password-reset', ['as' => 'auth.reset.post', 'uses' => 'AuthController@createReset', 'middleware' => ['XSS']]);
    // $router->get('reset/{id}/{code}', ['as' => 'reset.complete', 'uses' => 'AuthController@getResetComplete']);
    // $router->post('reset/{id}/{code}', ['as' => 'reset.complete.post', 'uses' => 'AuthController@postResetComplete']);

    Route::group(['middleware' => ['auth.hotel', 'auth.hotel_register']], function (Router $router) {
        # Logout
        $router->get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
        # Dashboard
        $router->get(
            '/', [
            'as' => 'index',
            'uses' => 'DashboardController@index',
        ]);
        $router->get(
            '/dashboard', [
            'as' => 'dashboard',
            'uses' => 'DashboardController@index'
        ]);
        $router->get(
            '/calendar', [
            'as' => 'calendar',
            'uses' => 'DashboardController@calendar'
        ]);
        $router->post(
            '/calendar/setUnavailableDates', [
            'as' => 'setUnavailableDates',
            'uses' => 'DashboardController@setUnavailableDates'
        ]);

        // setUnavalibleDates
        # File Manager
        Route::group(
            ['prefix' => 'filemanager'], function () {
            $middleware = [CreateDefaultFolder::class, MultiUser::class];
            $as = 'unisharp.lfm.';
            $namespace = '\\UniSharp\\LaravelFilemanager\\Controllers\\';

            // upload
            Route::any('/upload', [
                'uses' => 'UploadController@upload',
                'as' => $as . 'upload',
            ]);
            Route::group(compact('middleware', 'as', 'namespace'), function () {

                // display main layout
                Route::get('/', [
                    'uses' => 'LfmController@show',
                    'as' => 'show',
                ]);

                // display integration error messages
                Route::get('/errors', [
                    'uses' => 'LfmController@getErrors',
                    'as' => 'getErrors',
                ]);

                // list images & files
                Route::get('/jsonitems', [
                    'uses' => 'ItemsController@getItems',
                    'as' => 'getItems',
                ]);

                Route::get('/move', [
                    'uses' => 'ItemsController@move',
                    'as' => 'move',
                ]);

                Route::get('/domove', [
                    'uses' => 'ItemsController@domove',
                    'as' => 'domove'
                ]);

                // folders
                Route::get('/newfolder', [
                    'uses' => 'FolderController@getAddfolder',
                    'as' => 'getAddfolder',
                ]);

                // list folders
                Route::get('/folders', [
                    'uses' => 'FolderController@getFolders',
                    'as' => 'getFolders',
                ]);

                // crop
                Route::get('/crop', [
                    'uses' => 'CropController@getCrop',
                    'as' => 'getCrop',
                ]);
                Route::get('/cropimage', [
                    'uses' => 'CropController@getCropimage',
                    'as' => 'getCropimage',
                ]);
                Route::get('/cropnewimage', [
                    'uses' => 'CropController@getNewCropimage',
                    'as' => 'getCropnewimage',
                ]);

                // rename
                Route::get('/rename', [
                    'uses' => 'RenameController@getRename',
                    'as' => 'getRename',
                ]);

                // scale/resize
                Route::get('/resize', [
                    'uses' => 'ResizeController@getResize',
                    'as' => 'getResize',
                ]);
                Route::get('/doresize', [
                    'uses' => 'ResizeController@performResize',
                    'as' => 'performResize',
                ]);

                // download
                Route::get('/download', [
                    'uses' => 'DownloadController@getDownload',
                    'as' => 'getDownload',
                ]);

                // delete
                Route::get('/delete', [
                    'uses' => 'DeleteController@getDelete',
                    'as' => 'getDelete',
                ]);
            });
        });
        # Profile
        Route::group(['prefix' => 'profile', 'as' => 'auth.profile.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'edit',
                'uses' => 'AuthController@profile',
            ]);
            $router->post(
                '/save', [
                'as' => 'save',
                'uses' => 'AuthController@profileSave',
            ]);
            $router->post(
                '/security/save', [
                'as' => 'security.save',
                'uses' => 'AuthController@profileSecuritySave',
            ]);
        });
        # Faq
        Route::group(['prefix' => 'faq', 'as' => 'faq.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'FaqController@index',
            ]);
        });
        # Data Privacy
        Route::group(['prefix' => 'data-privacy', 'as' => 'data-privacy.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'FaqController@data_privacy',
            ]);
        });
        # Payments
        Route::group(['prefix' => 'payments', 'as' => 'payments.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'PaymentsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'PaymentsController@indexAjax',
            ]);
            $router->get(
                '/{id}/show', [
                'as' => 'show',
                'uses' => 'PaymentsController@show',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'PaymentsController@save',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'PaymentsController@remove',
            ]);
        });
        # Hotels
        Route::group(['prefix' => 'hotels', 'as' => 'hotels.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'HotelsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'HotelsController@indexAjax',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'HotelsController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'HotelsController@save',
            ]);
            $router->get(
                '/add', [
                'as' => 'add',
                'uses' => 'HotelsController@add',
            ]);
            $router->post(
                '/add/post', [
                'as' => 'add.post',
                'uses' => 'HotelsController@add',
            ]);
            $router->get(
                '/{id}/remove', [
                'as' => 'remove',
                'uses' => 'HotelsController@remove',
            ]);
            $router->post(
                '/createNewPassword', [
                'as' => 'create-new-password',
                'uses' => '\App\Http\Controllers\Hotel\AuthController@createNewPasswordHotel',
            ]);

        });
        # Reservations
        Route::group(['prefix' => 'reservations', 'as' => 'reservations.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'ReservationsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'ReservationsController@indexAjax',
            ]);
            /*$router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'ReservationsController@edit',
            ]);
            $router->post(
                '/{id}/edit', [
                'as' => 'save',
                'uses' => 'ReservationsController@save',
            ]);*/

            $router->get(
                '/{id}/show', [
                'as' => 'show',
                'uses' => 'ReservationsController@show',
            ]);
            $router->get(
                '/updateReservationStatus', [
                'as' => 'setReservationStatus',
                'uses' => 'ReservationsController@setReservationStatus',
            ]);

        });
        # Documents
        Route::group(['prefix' => 'documents', 'as' => 'documents.'], function (Router $router) {
            $router->get(
                '/', [
                'as' => 'index',
                'uses' => 'DocumentsController@index',
            ]);
            $router->get(
                '/getAjax', [
                'as' => 'index.ajax',
                'uses' => 'DocumentsController@indexAjax',
            ]);
            $router->post(
                '/store', [
                'as' => 'store',
                'uses' => 'DocumentsController@store',
            ]);
            $router->post(
                '/{id}/update', [
                'as' => 'update',
                'uses' => 'DocumentsController@update',
            ]);
            $router->get(
                '/{id}/edit', [
                'as' => 'edit',
                'uses' => 'DocumentsController@edit',
            ]);
            $router->get(
                '/add/document', [
                'as' => 'add.document',
                'uses' => 'DocumentsController@add',
            ]);
        });


    });


});


