<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Costomer facing routes
 * No authentication required
 */

Route::get('/sellers/{char}', 'RetailerController@getByChar');
Route::get('/page/{page}', 'PageController@show');
Route::get('/offers-by-retailer/{mid}', 'VoucherController@getRetailerOffers');
Route::get('/restuarant-offers', 'VoucherController@getResturantOffers');
Route::get('/top-20-offers', 'VoucherController@getTop20Offers');
Route::get('/featured-offers', 'VoucherController@featuredOffers');
Route::get('/student-offers', 'VoucherController@getStudentOffers');
Route::get('/nhs-offers', 'VoucherController@getNHSOffers');
Route::get('/exclusive-offers', 'VoucherController@getExclusiveOffers');
Route::get('/offers-by-category/{slug}', 'VoucherController@getCategoryOffers');
Route::get('/retailers/{slug}','RetailerController@index');
Route::get('/retailer/{slug}','RetailerController@show');
Route::get('/cats','CategoryController@getAll');
Route::post('/subscribe','ListController@store');
Route::post('/send-message','MessageController@store');
Route::get('/live-search/{query}', 'SearchController@liveSearch');




/**
 * Customer account routes /
 * Requires Authentication
 */
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});
/**
 * Admin account routes /
 * Requires Authentication
 */
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //count records
    Route::get('/admin/users-mumber', 'AdminController@users');
    Route::get('/admin/clicks-mumber', 'AdminController@clicks');
    Route::get('/admin/vouchers-mumber', 'AdminController@vouchers');
    Route::get('/admin/retailers-mumber', 'AdminController@retailers');
    
    Route::post('/admin/retailers-csv/{prefix}', 'RetailerController@csvProcess');
    Route::post('/admin/vouchers-csv/{prefix}', 'VoucherController@csvProcess');
    Route::post('/admin/categories-csv', 'CategoryController@csvProcess');
    
    Route::post('/admin/logo-upload/{mid}', 'RetailerController@upload');
    Route::get('/admin/vouchers', 'VoucherController@adminIndex');
    Route::get('/admin/categories/index', 'CategoryController@adminIndex');
    Route::get('/admin/retailers/index', 'RetailerController@adminIndex');

    Route::resource('/admin/retailers', 'RetailerController');
    Route::resource('/admin/feeds', 'FeedController');
    Route::get('/admin/feed-test/{id}', 'FeedController@test');
    Route::get('/admin/feed-run/{id}', 'FeedController@run');
    Route::resource('/admin/feed-params', 'FeedParamsController');
    Route::resource('/admin/pages', 'PageController');
    Route::resource('/admin/vouchers', 'VoucherController');
    Route::resource('/admin/categories', 'CategoryController');
    Route::patch('admin/dashboard', 'Settings\ProfileController@update');
    Route::patch('admin/password', 'Settings\PasswordController@update');
});
/**
 * Login logout routes
 */
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
