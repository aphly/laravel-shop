<?php

use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelShop\Models\Common\Country;
use Illuminate\Support\Facades\DB;
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
    //install
    Route::get('/shop/install', 'Aphly\LaravelShop\Controllers\Front\InstallController@index');

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

            Route::get('wishlist', 'Aphly\LaravelShop\Controllers\Front\Account\WishlistController@index');
            Route::get('wishlist/product/{id}', 'Aphly\LaravelShop\Controllers\Front\Account\WishlistController@product')->where('id', '[0-9]+');

            Route::get('address', 'Aphly\LaravelShop\Controllers\Front\Account\AddressController@index');
            Route::match(['get', 'post'],'address/save', 'Aphly\LaravelShop\Controllers\Front\Account\AddressController@save');
            Route::get('address/remove/{id}', 'Aphly\LaravelShop\Controllers\Front\Account\AddressController@remove')->where('id', '[0-9]+');
            Route::get('address/country/{id}', 'Aphly\LaravelShop\Controllers\Front\Account\AddressController@country')->where('id', '[0-9]+');


        });


    });


//    Route::get('/eyeglasses', 'Aphly\LaravelShop\Controllers\ProductController@index');
//    Route::get('/eyeglasses/{sku}', 'Aphly\LaravelShop\Controllers\ProductController@detail')->where('sku', '[0-9a-zA-Z]+');
//    Route::get('/eyeglasses/{sku}/lens', 'Aphly\LaravelShop\Controllers\ProductController@lens')->where('sku', '[0-9a-zA-Z]+');

});


Route::middleware(['web'])->group(function () {

    Route::get('/test', function (){
        $data = Menu::where('status',1)->orderBy('sort', 'desc')->get();
    });

});


Route::middleware(['web'])->group(function () {

    Route::prefix('shop-admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {
            Route::get('/product/index', 'Aphly\LaravelShop\Controllers\Admin\ProductController@index');
            Route::match(['get', 'post'],'/product/add', 'Aphly\LaravelShop\Controllers\Admin\ProductController@add');
            Route::match(['get', 'post'],'/product/{id}/edit', 'Aphly\LaravelShop\Controllers\Admin\ProductController@edit')->where('id', '[0-9]+');
            Route::post('/product/del', 'Aphly\LaravelShop\Controllers\Admin\ProductController@del');
            Route::match(['get', 'post'],'/product/{id}/img', 'Aphly\LaravelShop\Controllers\Admin\ProductController@img')->where('id', '[0-9]+');
            Route::match(['post'],'/product/{id}/imgsave', 'Aphly\LaravelShop\Controllers\Admin\ProductController@imgSave')->where('id', '[0-9]+');
            Route::match(['get'],'/product-img/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\ProductController@imgDel')->where('id', '[0-9]+');

            Route::get('/category/index', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@index');
        });
    });
});
