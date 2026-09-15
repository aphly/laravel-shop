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

Route::get('paypal/index', 'Aphly\LaravelShop\Controllers\Front\PaypalController@index');
Route::post('paypal/order', 'Aphly\LaravelShop\Controllers\Front\PaypalController@order');
Route::post('paypal/capture', 'Aphly\LaravelShop\Controllers\Front\PaypalController@capture');

Route::get('mail/render', 'Aphly\LaravelShop\Controllers\Front\MailController@render');
Route::get('sitemap', 'Aphly\LaravelShop\Controllers\Front\SitemapController@index');

Route::middleware(['web'])->group(function () {

    Route::middleware(['userAuth'])->group(function () {
        Route::get('oauth/{driver}', 'Aphly\LaravelShop\Controllers\Front\Account\OauthController@redirect')->name('oauth');
        Route::get('oauth/{driver}/callback', 'Aphly\LaravelShop\Controllers\Front\Account\OauthController@handleCallback')->name('oauthCallback');
    });

    //Subscribe
    Route::post('subscribe/ajax', 'Aphly\LaravelShop\Controllers\Front\AccountExt\SubscribeController@ajax');

    //404
    Route::get('404', 'Aphly\LaravelShop\Controllers\Front\Common\StatusController@notfound');
    Route::get('blocked','Aphly\LaravelShop\Controllers\Front\Common\StatusController@blocked')->name('blocked');

//    Route::get('/eyeglasses/index', 'Aphly\LaravelShop\Controllers\Front\Product\GlassesController@index');
//    Route::get('/eyeglasses/detail', 'Aphly\LaravelShop\Controllers\Front\Product\GlassesController@detail');
//    Route::get('/eyeglasses/lens', 'Aphly\LaravelShop\Controllers\Front\Product\GlassesController@lens');

    Route::prefix('account')->group(function () {
        Route::match(['get'],'autologin/{token}','Aphly\LaravelShop\Controllers\Front\Account\AccountController@autoLogin');
        Route::match(['get'],'blocked','Aphly\LaravelShop\Controllers\Front\Account\AccountController@blocked')->name('accountBlocked');
        Route::match(['get'],'email-verify','Aphly\LaravelShop\Controllers\Front\Account\AccountController@emailVerify')->name('emailVerify');
        Route::match(['get'],'email-verify/send','Aphly\LaravelShop\Controllers\Front\Account\AccountController@emailVerifySend');
        Route::get('email-verify/{token}','Aphly\LaravelShop\Controllers\Front\Account\AccountController@emailVerifyCheck');

        Route::match(['get', 'post'],'forget','Aphly\LaravelShop\Controllers\Front\Account\AccountController@forget');
        Route::match(['get'],'forget/confirmation','Aphly\LaravelShop\Controllers\Front\Account\AccountController@forgetConfirmation');
        Route::match(['get', 'post'],'forget-password/{token}','Aphly\LaravelShop\Controllers\Front\Account\AccountController@forgetPassword');

        Route::get('logout','Aphly\LaravelShop\Controllers\Front\Account\AccountController@logout');

        Route::middleware(['userAuth'])->group(function () {
            Route::match(['get', 'post'],'register','Aphly\LaravelShop\Controllers\Front\Account\AccountController@register')->name('register');
            Route::match(['get', 'post'],'login','Aphly\LaravelShop\Controllers\Front\Account\AccountController@login')->name('login');
            Route::match(['get', 'post'],'index','Aphly\LaravelShop\Controllers\Front\Account\AccountController@index');
            Route::post('avatar','Aphly\LaravelShop\Controllers\Front\Account\AccountController@avatar');

        });
    });

    //currency
    Route::get('currency/{id}', 'Aphly\LaravelShop\Controllers\Front\Common\CurrencyController@ajax')->where('id', '[0-9]+');
    //country
    Route::get('country/{id}/zone', 'Aphly\LaravelShop\Controllers\Front\Common\CountryController@zone')->where('id', '[0-9]+');
    //checkout
    Route::get('checkout/success', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@success');
    Route::get('checkout/fail', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@fail');

    //wishlist
    Route::post('wishlist/product/{id}', 'Aphly\LaravelShop\Controllers\Front\AccountExt\WishlistController@product')->where('id', '[0-9]+');


    Route::middleware(['userAuth'])->group(function () {
        //account
        Route::prefix('account_ext')->group(function () {
            Route::match(['get', 'post'],'subscribe', 'Aphly\LaravelShop\Controllers\Front\AccountExt\SubscribeController@index');

            Route::get('address', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AddressController@index');
            Route::match(['get', 'post'],'address/save', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AddressController@save');
            Route::get('address/{id}/remove', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AddressController@remove')->where('id', '[0-9]+');

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

            //after sales
            Route::get('after_sales', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AfterSalesController@index');
            Route::get('after_sales/detail', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AfterSalesController@detail');
            Route::get('after_sales/form', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AfterSalesController@form');
            Route::post('after_sales/save', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AfterSalesController@save');
            Route::post('after_sales/save_history', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AfterSalesController@saveHistory');
            Route::post('after_sales/del', 'Aphly\LaravelShop\Controllers\Front\AccountExt\AfterSalesController@del');

            Route::post('service/return_exchange3', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@returnExchange3');
            Route::post('service/return_exchange4', 'Aphly\LaravelShop\Controllers\Front\AccountExt\ServiceController@returnExchange4');
        });

        //Checkout
//        Route::match(['get', 'post'],'checkout/address', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@address');
//        Route::match(['get', 'post'],'checkout/shipping', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@shipping');
//        Route::match(['get', 'post'],'checkout/payment', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@payment');

        //review
        Route::post('product/{id}/review/add', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@reviewAdd')->where('id', '[0-9]+');

        //cart
        Route::post('cart/{id}/wishlist', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@addWishlist')->where('id', '[0-9]+');

        //card create
        Route::post('card/create', 'Aphly\LaravelShop\Controllers\Front\Checkout\CheckoutController@cardCreate');
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/', 'Aphly\LaravelShop\Controllers\Front\Common\HomeController@index');
        Route::match(['post'],'contact_us', 'Aphly\LaravelShop\Controllers\Front\Common\ContactUsController@index');
        Route::match(['get'],'information/index', 'Aphly\LaravelShop\Controllers\Front\Common\InformationController@index');
        Route::match(['get'],'information/{id}', 'Aphly\LaravelShop\Controllers\Front\Common\InformationController@detail');
        Route::match(['get'],'size_guide', 'Aphly\LaravelShop\Controllers\Front\Product\AphlyController@sizeGuide');

        //product
        Route::get('product', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@index');
        Route::get('product/{id}', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@detail');
        Route::redirect('product/new', '/product?sort=sale');
        Route::redirect('product/best', '/product?sort=new');

        //cart
        Route::get('cart', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@index');
        Route::post('cart/add', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@add');
        Route::post('cart/edit', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@edit');
        Route::post('cart/remove', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@remove');
        Route::post('cart/coupon', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@coupon');
        Route::get('cart/coupon_remove', 'Aphly\LaravelShop\Controllers\Front\Checkout\CartController@couponRemove');

        //all

        //payment
//        Route::get('checkout/all', 'Aphly\LaravelShop\Controllers\Front\Checkout\AllController@index');
//        Route::post('checkout/payment', 'Aphly\LaravelShop\Controllers\Front\Checkout\AllController@payment');


        //payment paypal
        Route::get('checkout/email', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@email');
        Route::get('checkout/all_paypal', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@index');
        Route::post('checkout/payment_paypal', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@payment');
        Route::post('checkout/capture_paypal', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@capture');
        Route::post('checkout/shipping', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@shipping');
        Route::post('checkout/coupon', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@coupon');
        Route::post('checkout/coupon_remove', 'Aphly\LaravelShop\Controllers\Front\Checkout\PaypalController@couponRemove');

        //Tracking
        Route::match(['get', 'post'],'tracking/index', 'Aphly\LaravelShop\Controllers\Front\Common\TrackingController@index');
    });
});

Route::middleware(['web'])->group(function () {

    Route::prefix('shop_admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {

            $route_arr = [
                ['attribute','\Catalog\AttributeController'],['option','\Catalog\OptionController'],['filter','\Catalog\FilterController'],
                ['shipping','\Catalog\ShippingController'],['coupon','\Sale\CouponController'],['order','\Sale\OrderController'],['service','\Sale\ServiceController'],['after_sales','\Sale\AfterSalesController'],
                ['information','\Common\InformationController'],['information_category','\Common\InformationCategoryController'],['contact_us','\Common\ContactUsController'],
                ['country','\Setting\CountryController'],['geo','\Setting\GeoController'],['zone','\Setting\ZoneController'],
                ['group','\Account\GroupController'],['user_address','\Account\UserAddressController'],
                ['review','\Account\ReviewController'],['wishlist','\Account\WishlistController'],['subscribe','\Account\SubscribeController'],
                ['banner','\Common\BannerController'],['salesperson','\Sale\SalespersonController'],
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

            Route::get('config/index', 'Aphly\LaravelShop\Controllers\Admin\Setting\ConfigController@index');
            Route::post('config/save', 'Aphly\LaravelShop\Controllers\Admin\Setting\ConfigController@save');

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
            Route::get('product/set_price', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@setPrice');

            Route::get('attribute/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\AttributeController@ajax');
            Route::get('option/ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\OptionController@ajax');

            Route::get('order/view', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@view');
            Route::post('order/history_save', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@historySave');
            Route::post('order/download', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@download');
            Route::post('order/shipped', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@shipped');
            Route::get('order/sync', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@sync');
            //Route::get('order/shipping', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@shipping');
            Route::post('order/save_shipping', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@saveShipping');
            Route::get('order/shipping_label', 'Aphly\LaravelShop\Controllers\Admin\Sale\OrderController@shippingLabel');

            Route::get('service/view', 'Aphly\LaravelShop\Controllers\Admin\Sale\ServiceController@view');
            Route::post('service/history_save', 'Aphly\LaravelShop\Controllers\Admin\Sale\ServiceController@historySave');

            Route::get('after_sales/view', 'Aphly\LaravelShop\Controllers\Admin\Sale\AfterSalesController@view');
            Route::post('after_sales/history_save', 'Aphly\LaravelShop\Controllers\Admin\Sale\AfterSalesController@historySave');

            Route::match(['get', 'post'],'product/sync', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@sync');

        });
    });
});
