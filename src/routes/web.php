<?php


use Aphly\LaravelShop\Models\Common\Attribute;
use Aphly\LaravelShop\Models\Common\Filter;
use Aphly\LaravelShop\Models\Common\FilterGroup;
use Aphly\LaravelShop\Models\Common\Option;
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


//    Route::get('/eyeglasses', 'Aphly\LaravelShop\Controllers\ProductController@index');
//    Route::get('/eyeglasses/{sku}', 'Aphly\LaravelShop\Controllers\ProductController@detail')->where('sku', '[0-9a-zA-Z]+');
//    Route::get('/eyeglasses/{sku}/lens', 'Aphly\LaravelShop\Controllers\ProductController@lens')->where('sku', '[0-9a-zA-Z]+');

});


Route::middleware(['web'])->group(function () {

    Route::get('/test', function (){
        $name = request()->query('name',false);
        $list = Option::where('status',1)->when($name,function($query,$name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })->with('value')->get()->keyBy('id')->toArray();
        dd($list);
        return view('welcome');
    });


});


Route::middleware(['web'])->group(function () {

    Route::prefix('shop_admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {
//            Route::get('/product/index', 'Aphly\LaravelShop\Controllers\Admin\ProductController@index');
//            Route::match(['get', 'post'],'/product/add', 'Aphly\LaravelShop\Controllers\Admin\ProductController@add');
//            Route::match(['get', 'post'],'/product/{id}/edit', 'Aphly\LaravelShop\Controllers\Admin\ProductController@edit')->where('id', '[0-9]+');
//            Route::post('/product/del', 'Aphly\LaravelShop\Controllers\Admin\ProductController@del');
//
            Route::get('/category/index', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@index');
            Route::post('/category/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@del');
            Route::get('/category/show', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@show');
            Route::post('/category/save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\CategoryController@save');

            $route_arr = [
                    ['filter','\Catalog\FilterController'],['country','\System\CountryController'],
                    ['zone','\System\ZoneController'],['currency','\System\CurrencyController'],
                    ['attribute','\Catalog\AttributeController'],['option','\Catalog\OptionController'],
                ];
            foreach ($route_arr as $val){
                Route::get('/'.$val[0].'/index', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@index');
                Route::get('/'.$val[0].'/form', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@form');
                Route::post('/'.$val[0].'/save', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@save');
                Route::post('/'.$val[0].'/del', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@del');
            }

            Route::get('/product/index', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@index');
            Route::get('/product/form', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@form');
            Route::post('/product/save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@save');
            Route::match(['get', 'post'],'/product/desc', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@desc');
            Route::match(['get', 'post'],'/product/attribute', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@attribute');
            Route::get('/product/attribute_ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@attributeAjax');
            Route::match(['get', 'post'],'/product/option', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@option');
            Route::get('/product/option_ajax', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@optionAjax');

            Route::match(['get', 'post'],'/product/{id}/img', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@img')->where('id', '[0-9]+');
            Route::match(['post'],'/product/{id}/img_save', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgSave')->where('id', '[0-9]+');
            Route::match(['get'],'/product_img/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\Catalog\ProductController@imgDel')->where('id', '[0-9]+');



        });
    });
});
