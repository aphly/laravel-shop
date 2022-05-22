<?php


use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Common\Setting;
use Aphly\LaravelShop\Models\Product\ProductOption;
use Aphly\LaravelShop\Models\Product\ProductOptionValue;
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

    //分类
    Route::get('/product/category', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@category');

    Route::get('/product/{id}', 'Aphly\LaravelShop\Controllers\Front\Product\ProductController@detail');

});


Route::middleware(['web'])->group(function () {

    Route::get('/test', function (){
        $productOption = ProductOption::where('product_id',2)->with('option')->get()->toArray();
        $product_option_ids = array_column($productOption,'id');
        $productOptionValue = ProductOptionValue::whereIn('product_option_id',$product_option_ids)->with('option_value')->get()->toArray();
        $productOptionValueGroup = [] ;
        foreach ($productOptionValue as $val){
            $val['price_format'] = Currency::format($val['price']);
            $productOptionValueGroup[$val['product_option_id']][] = $val;
        }
        $res = [];
        foreach ($productOption as $key=>$val){
            $res[$key] = $val;
            $res[$key]['product_option_value'] = $productOptionValueGroup[$val['id']];
        }
        dd($res);
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
            Route::get('/product/option_ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@optionAjax');
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

        });
    });
});
