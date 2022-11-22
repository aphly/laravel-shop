<?php

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

Route::middleware(['web'])->group(function () {

    Route::get('/home1', 'Aphly\LaravelShop\Controllers\Front\HomeController@home1');

    Route::post('wishlist/product/{id}', 'Aphly\LaravelShop\Controllers\Front\Account\WishlistController@product')->where('id', '[0-9]+');

    Route::middleware(['userAuth'])->group(function () {
        //account
        Route::prefix('account')->group(function () {
            //wishlist
            Route::get('wishlist', 'Aphly\LaravelShop\Controllers\Front\Account\WishlistController@index');
            Route::post('wishlist/{id}/remove', 'Aphly\LaravelShop\Controllers\Front\Account\WishlistController@remove')->where('id', '[0-9]+');

            //cart
            Route::post('cart/{id}/wishlist', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@addWishlist')->where('id', '[0-9]+');

            //order
            Route::get('order', 'Aphly\LaravelShop\Controllers\Front\Account\OrderController@index');
            Route::get('order/{id}/detail', 'Aphly\LaravelShop\Controllers\Front\Account\OrderController@detail')->where('id', '[0-9]+');
        });

        //Checkout
        Route::get('/checkout', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@index');
        Route::match(['get', 'post'],'/checkout/address', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@address');
        Route::match(['get', 'post'],'/checkout/shipping', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@shipping');
        Route::match(['get', 'post'],'/checkout/pay', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@pay');
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/index', 'Aphly\LaravelShop\Controllers\Front\HomeController@index');

        //common
        Route::get('/coupon/{code}', 'Aphly\LaravelShop\Controllers\Front\Common\CouponController@ajax');

        //product
        Route::get('/product/category', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@category');
        Route::get('/product/{id}', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@detail')->where('id', '[0-9]+');

        //cart
        Route::post('/cart/add', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@add');
        Route::post('/cart/edit', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@edit');
        Route::get('/cart', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@index');
        Route::post('/cart/coupon', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@coupon');
        Route::get('/cart/coupon_remove', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@couponRemove');

    });
});

Route::middleware(['web'])->group(function () {

    Route::prefix('shop_admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {

            $route_arr = [
                ['attribute','\Catalog\AttributeController'],['option','\Catalog\OptionController'],['review','\Catalog\ReviewController'],
                ['shipping','\Catalog\ShippingController'],['coupon','\Sale\CouponController']
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
            Route::match(['get', 'post'],'/product/add', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@add');
            Route::match(['get', 'post'],'/product/edit', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@edit');
            Route::post('/product/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@del');
            Route::match(['get', 'post'],'/product/desc', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@desc');
            Route::match(['get', 'post'],'/product/attribute', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@attribute');
            Route::match(['get', 'post'],'/product/option', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@option');
            Route::match(['get', 'post'],'/product/links', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@links');

            Route::match(['get', 'post'],'/product/img', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@img');
            Route::match(['post'],'/product/img_save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgSave');
            Route::match(['get'],'/product_img/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgDel')->where('id', '[0-9]+');

            Route::match(['get', 'post'],'/product/reward', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@reward');
            Route::match(['get', 'post'],'/product/special', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@special');
            Route::match(['get', 'post'],'/product/discount', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@discount');

            Route::get('/coupon/history', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@history');

            Route::get('/product/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@ajax');
            Route::get('/attribute/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\AttributeController@ajax');
            Route::get('/option/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\OptionController@ajax');
        });
    });
});
