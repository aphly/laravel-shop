<?php

use Aphly\LaravelShop\Models\Common\Country;
use Illuminate\Support\Facades\Route;

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
//Route::middleware(['throttle:5,10'])->match(['get', 'post'],'/admin/test', 'Aphly\LaravelShop\Controllers\IndexController@test');
//
////Route::get('/admin/init', 'Aphly\LaravelShop\Controllers\InitController@index');
//
Route::middleware(['web'])->group(function () {
    //安装
    Route::get('/shop_install', 'Aphly\LaravelShop\Controllers\Front\InstallController@index');

    Route::get('/userauth/{id}/verify/{token}', 'Aphly\LaravelShop\Controllers\Front\HomeController@mailVerifyCheck');

    Route::match(['get', 'post'],'/forget', 'Aphly\LaravelShop\Controllers\Front\HomeController@forget');
    Route::match(['get', 'post'],'/forget-password/{token}', 'Aphly\LaravelShop\Controllers\Front\HomeController@forgetPassword');

    Route::get('/index', 'Aphly\LaravelShop\Controllers\Front\HomeController@index');
    Route::match(['get'],'/autologin/{token}', 'Aphly\LaravelShop\Controllers\Front\HomeController@autoLogin');

    Route::middleware(['userAuth'])->group(function () {
        Route::match(['get'],'/email/verify', 'Aphly\LaravelShop\Controllers\Front\HomeController@mailVerify');

        Route::match(['get', 'post'],'/register', 'Aphly\LaravelShop\Controllers\Front\HomeController@register');
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelShop\Controllers\Front\HomeController@login');

        Route::get('/logout', 'Aphly\LaravelShop\Controllers\Front\HomeController@logout');

        //account
        Route::prefix('account')->group(function () {
            Route::get('customer', 'Aphly\LaravelShop\Controllers\Front\Account\CustomerController@index');
            Route::get('wishlist', 'Aphly\LaravelShop\Controllers\Front\Account\CustomerWishlistController@index');

        });
    });





//    Route::get('/eyeglasses', 'Aphly\LaravelShop\Controllers\ProductController@index');
//    Route::get('/eyeglasses/{sku}', 'Aphly\LaravelShop\Controllers\ProductController@detail')->where('sku', '[0-9a-zA-Z]+');
//    Route::get('/eyeglasses/{sku}/lens', 'Aphly\LaravelShop\Controllers\ProductController@lens')->where('sku', '[0-9a-zA-Z]+');

});


Route::middleware(['web'])->group(function () {

    Route::get('/test', function (){

    });


});
