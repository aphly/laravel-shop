<?php

use Aphly\Laravel\Logs\Logs;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
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

    Route::get('/userauth/{id}/verify/{token}', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@mailVerifyCheck');

    Route::match(['get', 'post'],'/forget', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@forget');
    Route::match(['get', 'post'],'/forget-password/{token}', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@forgetPassword');

    Route::get('/index', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@index');
    Route::match(['get'],'/autologin/{token}', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@autoLogin');

    Route::middleware(['userAuth'])->group(function () {
        Route::match(['get'],'/email/verify', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@mailVerify');

        Route::match(['get', 'post'],'/register', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@register');
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@login');

        Route::get('/logout', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@logout');

        //account
        Route::prefix('customer')->group(function () {
            Route::get('account', 'Aphly\LaravelShop\Controllers\Front\Customer\AccountController@index');

            Route::get('wishlist', 'Aphly\LaravelShop\Controllers\Front\Customer\WishlistController@index');
            Route::get('wishlist/product/{id}', 'Aphly\LaravelShop\Controllers\Front\Customer\WishlistController@product')->where('id', '[0-9]+');

            Route::get('address', 'Aphly\LaravelShop\Controllers\Front\Customer\AddressController@index');
            Route::match(['get', 'post'],'address/save', 'Aphly\LaravelShop\Controllers\Front\Customer\AddressController@save');
            Route::get('address/remove/{id}', 'Aphly\LaravelShop\Controllers\Front\Customer\AddressController@remove')->where('id', '[0-9]+');
            Route::get('address/country/{id}', 'Aphly\LaravelShop\Controllers\Front\Customer\AddressController@country')->where('id', '[0-9]+');


        });

        Route::get('/checkout', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@index');

    });

    //common
    Route::get('/currency/{id}', 'Aphly\LaravelShop\Controllers\Front\Common\CurrencyController@ajax')->where('id', '[0-9]+');
    Route::get('/coupon/{code}', 'Aphly\LaravelShop\Controllers\Front\Common\CouponController@ajax');

    //product
    Route::get('/product/category', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@category');
    Route::get('/product/{id}', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@detail')->where('id', '[0-9]+');

    Route::post('/cart/add', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@add');
    Route::get('/cart', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@index');


});


Route::middleware(['web'])->group(function () {

    Route::get('/test', function (){
        $guest = Cookie::get('guest');
        dd($guest);
        $aa = (new Cart)->totalQuantity($guest);
        dd($aa);
        return view('welcome');
    });

    Route::get('/test1', function (){
        return view('welcome');
    });
});


Route::middleware(['web'])->group(function () {

    Route::prefix('shop_admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {

            Route::get('/category/index', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@index');
            Route::post('/category/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@del');
            Route::get('/category/show', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@show');
            Route::post('/category/save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@save');

            $route_arr = [
                    ['filter','\Catalog\FilterController'],['country','\System\CountryController'],
                    ['zone','\System\ZoneController'],['currency','\System\CurrencyController'],
                    ['attribute','\Catalog\AttributeController'],['option','\Catalog\OptionController'],
                    ['information','\Catalog\InformationController'],['review','\Catalog\ReviewController'],
                    ['group','\Customer\GroupController']
                ];
            foreach ($route_arr as $val){
                Route::get('/'.$val[0].'/index', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@index');
                Route::get('/'.$val[0].'/form', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@form');
                Route::post('/'.$val[0].'/save', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@save');
                Route::post('/'.$val[0].'/del', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@del');
            }

            Route::get('/customer/index', 'Aphly\LaravelShop\Controllers\Admin\Customer\CustomerController@index');
            Route::post('/customer/save', 'Aphly\LaravelShop\Controllers\Admin\Customer\CustomerController@save');
            Route::get('/customer/form', 'Aphly\LaravelShop\Controllers\Admin\Customer\CustomerController@form');

            Route::get('/setting/index', 'Aphly\LaravelShop\Controllers\Admin\System\SettingController@index');
            Route::post('/setting/save', 'Aphly\LaravelShop\Controllers\Admin\System\SettingController@save');

            Route::get('/product/index', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@index');
            Route::get('/product/form', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@form');
            Route::post('/product/save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@save');
            Route::match(['get', 'post'],'/product/desc', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@desc');
            Route::match(['get', 'post'],'/product/attribute', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@attribute');
            Route::match(['get', 'post'],'/product/option', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@option');
            Route::match(['get', 'post'],'/product/links', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@links');


            Route::match(['get', 'post'],'/product/{id}/img', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@img')->where('id', '[0-9]+');
            Route::match(['post'],'/product/{id}/img_save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgSave')->where('id', '[0-9]+');
            Route::match(['get'],'/product_img/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgDel')->where('id', '[0-9]+');

            Route::match(['get', 'post'],'/product/reward', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@reward');
            Route::match(['get', 'post'],'/product/special', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@special');
            Route::match(['get', 'post'],'/product/discount', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@discount');

            Route::get('/coupon/index', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@index');
            Route::post('/coupon/del', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@del');
            Route::get('/coupon/form', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@form');
            Route::post('/coupon/save', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@save');
            Route::get('/coupon/history', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@history');

            Route::get('/category/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@ajax');
            Route::get('/filter/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\FilterController@ajax');
            Route::get('/product/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@ajax');
            Route::get('/attribute/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\AttributeController@ajax');
            Route::get('/option/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\OptionController@ajax');

        });
    });
});
