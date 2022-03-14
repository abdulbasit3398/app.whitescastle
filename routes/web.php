<?php

use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\TwilioSMSController;
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

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth');

Auth::routes();

// Route::get('/', 'HomeController@index')->name('dashboard');
// Route::get('/dashboard', 'HomeController@index')->name('dashboard');
// Route::get('/pricing', 'HomeController@pricing')->name('pricing');
// Route::get('/contact', 'HomeController@contact')->name('contact');
// Route::get('/my-account', 'HomeController@my_account')->name('my-account');
// Route::post('/send_contact', 'HomeController@send_contact')->name('send_contact');

Route::get('/test', 'Admin\CategoryController@test');

//Admin Routes 
Route::group(['prefix' => 'admin','middleware' => ['admin.manager.access','auth'],'namespace' => 'Admin'], function(){
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('orders', 'OrdersController@index')->name('admin.orders');
    Route::get('order/show/{order}', 'OrdersController@show')->name('admin.order.show');
    Route::get('CheckNewOrders', 'OrdersController@CheckNewOrders')->name('admin.CheckNewOrders');
    Route::post('orders/update-status', 'OrdersController@UpdateStatus')->name('admin.orders.statusupdate');
    Route::get('order-summary', 'AdminController@order_summary')->name('admin.order-summary');

});

Route::group(['prefix' => 'admin','middleware' => ['admin.access','auth'],'namespace' => 'Admin'], function(){
	
	Route::resource('categories', 'CategoryController');
    Route::post('categories/store', 'CategoryController@store')->name('admin.categories.store');
    Route::get('categories/{id}', 'CategoryController@show')->where('id', '[0-9]+')->name('admin.subcategories');
    Route::post('subcategories/store', 'CategoryController@subcategorystore')->name('admin.subcategories.store');
    Route::get('menu', 'MenuController@index')->name('admin.menu');
    Route::get('menu/edit/{id}', 'MenuController@edit_menu')->name('admin.editmenu');
    Route::post('menu/store', 'MenuController@store')->name('admin.menu.store');
    Route::delete('menu/delete', 'MenuController@delete')->name('admin.menu.delete');

    Route::get('deals', 'DealsController@index')->name('admin.deals');
    Route::post('deals/update-status', 'DealsController@UpdateStatus')->name('admin.deals.statusupdate');
    Route::get('deals/new', 'DealsController@new_deal')->name('admin.newdeal');
    Route::get('deals/edit/{id}', 'DealsController@edit_deal')->name('admin.editdeal');
    Route::post('deals/store', 'DealsController@store')->name('admin.deals.store');
    Route::post('deals/update', 'DealsController@update')->name('admin.deals.update');

    Route::get('discounts', 'DiscountController@index')->name('admin.discounts');
    Route::post('discounts/store', 'DiscountController@store')->name('admin.discount.store');

    Route::get('banner', 'BannerController@index')->name('admin.banner');
    Route::post('banner/store', 'BannerController@store')->name('admin.banner.store');
    Route::get('banner/delete/{banner}', 'BannerController@delete')->name('admin.banner.delete');

    Route::get('branches', 'BranchesController@index')->name('admin.branches');
    Route::post('branches/store', 'BranchesController@store')->name('admin.branches.store');
});

Route::group(['prefix' => 'admin','middleware' => ['admin.access','auth']], function(){
    Route::get('customers', 'UserController@customers')->name('admin.customers');
    Route::post('customers/store', 'UserController@customer_store')->name('admin.customers.store');
    Route::get('staff', 'UserController@staff')->name('admin.staff');
    Route::post('staff/store', 'UserController@staff_store')->name('admin.staff.store');

});
Route::get('/categories', 'ApiController@categories');

// Route::post('/payment', 'PaymentController@paymentProcess')->name('payment');
Route::get('/sendOTP', 'ApiController@sendsms');

Route::get('/logout', function(){
    Artisan::call('cache:clear');
    return App::call('\App\Http\Controllers\Auth\LoginController@logout');
});