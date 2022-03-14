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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test','ApiController@test');

Route::group([

    'prefix' => 'auth'

], function () {

    Route::post('check-duplicate-number', 'AuthController@check_duplicate_number');
    Route::post('login', 'AuthController@login');
    Route::post('reg', 'AuthController@register')->name('register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('edit-profile', 'AuthController@edit_profile');

});
Route::post('get-banner', 'ApiController@get_banner');
Route::post('product-detail', 'ApiController@product_detail');
Route::post('sendOTP', 'ApiController@sendOTP');
Route::post('verifyOTP', 'ApiController@verifyOTP');
Route::post('save_UserAddress', 'AuthController@save_user_address');
Route::post('get_UserAddress', 'AuthController@get_user_address');
Route::post('delete_UserAddress', 'AuthController@delete_user_address');
Route::post('categories_products', 'ApiController@categories');
Route::post('get_alldeals', 'ApiController@get_alldeals');
Route::post('checkCoupon', 'ApiController@checkCoupon');
Route::post('CalculatePrice', 'ApiController@CalculatePrice');
Route::post('branches', 'ApiController@AllBranches');
Route::post('search_products', 'ApiController@search_products');

Route::get('send_test', 'ApiController@FunctionName');
Route::post('get_allorders', 'AuthController@get_allorders');

Route::post('get_current_orders', 'AuthController@get_current_orders');
Route::post('create_order_feedback', 'AuthController@create_order_feedback');
Route::post('get_order', 'AuthController@get_order');
Route::post('Order', 'AuthController@Order');
Route::post('password/reset', 'ForgotPasswordAPIController@reset');
Route::post('password/email', 'ForgotPasswordAPIController@sendResetLinkEmail')->name('password.email');