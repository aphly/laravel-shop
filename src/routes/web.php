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

    //wishlist
    Route::post('wishlist/product/{id}', 'Aphly\LaravelShop\Controllers\Front\AccountExt\WishlistController@product')->where('id', '[0-9]+');

    Route::middleware(['userAuth'])->group(function () {
        //account
        Route::prefix('account_ext')->group(function () {

            //wishlist
            Route::get('wishlist', 'Aphly\LaravelShop\Controllers\Front\AccountExt\WishlistController@index');
            Route::post('wishlist/{id}/remove', 'Aphly\LaravelShop\Controllers\Front\AccountExt\WishlistController@remove')->where('id', '[0-9]+');

            //order
            Route::get('order', 'Aphly\LaravelShop\Controllers\Front\AccountExt\OrderController@index');
            Route::get('order/detail', 'Aphly\LaravelShop\Controllers\Front\AccountExt\OrderController@detail');
            Route::get('order/pay', 'Aphly\LaravelShop\Controllers\Front\AccountExt\OrderController@pay');
            Route::post('order/close', 'Aphly\LaravelShop\Controllers\Front\AccountExt\OrderController@close');
            Route::post('order/cancel', 'Aphly\LaravelShop\Controllers\Front\AccountExt\OrderController@cancel');

            //review
            Route::get('review', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ReviewController@index');
            Route::get('review/detail', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ReviewController@detail');

            //service
            Route::get('service', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@index');
            Route::get('service/detail', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@detail');
            Route::get('service/form', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@form');
            Route::post('service/save', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@save');
            Route::post('service/del', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@del');

            Route::post('service/return_exchange3', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@returnExchange3');
            Route::post('service/return_exchange4', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@returnExchange4');
        });

        //Checkout
        Route::match(['get', 'post'],'checkout/address', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@address');
        Route::match(['get', 'post'],'checkout/shipping', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@shipping');
        Route::match(['get', 'post'],'checkout/payment', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@payment');

        //review
        Route::post('product/{id}/review/add', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@reviewAdd')->where('id', '[0-9]+');

        //cart
        Route::post('cart/{id}/wishlist', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@addWishlist')->where('id', '[0-9]+');

        //card create
        Route::post('card/create', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@cardCreate');
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('index', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@index');
        Route::match(['post'],'contact_us', 'Aphly\LaravelShop\Controllers\Front\Common\ContactUsController@index');
        Route::match(['get'],'information/{id}', 'Aphly\LaravelShop\Controllers\Front\Common\InformationController@detail');

        //common
        Route::get('coupon/{code}', 'Aphly\LaravelShop\Controllers\Front\Common\CouponController@ajax');

        //product
        Route::get('product', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@index');
        Route::get('product/{id}', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@detail')->where('id', '[0-9]+');
        Route::redirect('product/new', '/product?sort=sale');
        Route::redirect('product/best', '/product?sort=new');

        //cart
        Route::get('cart', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@index');
        Route::post('cart/add', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@add');
        Route::post('cart/edit', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@edit');
        Route::post('cart/remove', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@remove');
        Route::post('cart/coupon', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@coupon');
        Route::get('cart/coupon_remove', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@couponRemove');

    });
});

Route::middleware(['web'])->group(function () {

    Route::prefix('shop_admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {

            $route_arr = [
                ['attribute','\Catalog\AttributeController'],['option','\Catalog\OptionController'],['review','\Catalog\ReviewController'],['filter','\Catalog\FilterController'],
                ['shipping','\Catalog\ShippingController'],['coupon','\Sale\CouponController'],['order','\Sale\OrderController'],['service','\Sale\ServiceController'],
                ['information','\Common\InformationController'],['contact_us','\Common\ContactUsController']
            ];

            foreach ($route_arr as $val){
                Route::get($val[0].'/index', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@index');
                Route::get($val[0].'/form', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@form');
                Route::post($val[0].'/save', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@save');
                Route::post($val[0].'/del', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@del');
            }

            Route::match(['post'],'information/img', 'Aphly\LaravelShop\Controllers\Admin\Common\InformationController@uploadImg');
            Route::match(['post'],'contact_us/reply', 'Aphly\LaravelShop\Controllers\Admin\Common\ContactUsController@reply');

            $route_arr = [
                ['category','\Catalog\CategoryController']
            ];

            foreach ($route_arr as $val){
                Route::get($val[0].'/index', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@index');
                Route::match(['get', 'post'],$val[0].'/add', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@add');
                Route::match(['get', 'post'],$val[0].'/edit', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@edit');
                Route::post($val[0].'/del', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@del');
            }

            Route::get('filter/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\FilterController@ajax');
            Route::get('category/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@ajax');
            Route::get('category/tree', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@tree');

            Route::get('setting/index', 'Aphly\LaravelShop\Controllers\Admin\System\SettingController@index');
            Route::post('setting/save', 'Aphly\LaravelShop\Controllers\Admin\System\SettingController@save');

            Route::get('product/index', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@index');
            Route::match(['get', 'post'],'product/add', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@add');
            Route::match(['get', 'post'],'product/edit', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@edit');
            Route::post('product/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@del');
            Route::match(['get', 'post'],'product/desc', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@desc');
            Route::match(['get', 'post'],'product/attribute', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@attribute');
            Route::match(['get', 'post'],'product/option', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@option');
            Route::match(['get', 'post'],'product/links', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@links');

            Route::match(['get', 'post'],'product/img', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@img');
            Route::match(['post'],'product/img_save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgSave');
            Route::match(['get'],'product_img/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgDel')->where('id', '[0-9]+');

            Route::match(['get', 'post'],'product/video', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@video');
            Route::match(['post'],'product/video_save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@videoSave');
            Route::match(['get'],'product_video/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@videoDel')->where('id', '[0-9]+');

            Route::match(['get', 'post'],'product/special', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@special');
            Route::match(['get', 'post'],'product/discount', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@discount');

            Route::get('coupon/history', 'Aphly\LaravelShop\Controllers\Admin\Sale\CouponController@history');

            Route::get('product/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@ajax');
            Route::get('attribute/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\AttributeController@ajax');
            Route::get('option/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\OptionController@ajax');

            Route::get('order/view', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@view');
            Route::post('order/history_save', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@historySave');
            Route::post('order/download', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@download');
            Route::post('order/shipped', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@shipped');
            Route::get('order/sync', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@sync');

            Route::get('service/view', 'Aphly\LaravelShop\Controllers\Admin\Sale\ServiceController@view');
            Route::post('service/history_save', 'Aphly\LaravelShop\Controllers\Admin\Sale\ServiceController@historySave');

            Route::match(['get', 'post'],'product/sync', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@sync');

        });
    });
});
