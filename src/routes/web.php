<?php

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

    Route::prefix('shop-admin')->middleware(['managerAuth'])->group(function () {
        Route::middleware(['rbac'])->group(function () {
            Route::get('/product/index', 'Aphly\LaravelShop\Controllers\Admin\ProductController@index');
            Route::match(['get', 'post'],'/product/add', 'Aphly\LaravelShop\Controllers\Admin\ProductController@add');
            Route::match(['get', 'post'],'/product/{id}/edit', 'Aphly\LaravelShop\Controllers\Admin\ProductController@edit')->where('id', '[0-9]+');
            Route::post('/product/del', 'Aphly\LaravelShop\Controllers\Admin\ProductController@del');
            Route::match(['get', 'post'],'/product/{id}/img', 'Aphly\LaravelShop\Controllers\Admin\ProductController@img')->where('id', '[0-9]+');
            Route::match(['post'],'/product/{id}/imgsave', 'Aphly\LaravelShop\Controllers\Admin\ProductController@imgSave')->where('id', '[0-9]+');
            Route::match(['get'],'/product-img/{id}/del', 'Aphly\LaravelShop\Controllers\Admin\ProductController@imgDel')->where('id', '[0-9]+');
        });
    });

    Route::get('/eyeglasses', 'Aphly\LaravelShop\Controllers\ProductController@index');
    Route::get('/eyeglasses/{sku}', 'Aphly\LaravelShop\Controllers\ProductController@detail')->where('sku', '[0-9a-zA-Z]+');
    Route::get('/eyeglasses/{sku}/lens', 'Aphly\LaravelShop\Controllers\ProductController@lens')->where('sku', '[0-9a-zA-Z]+');


});
Route::get('/sql',function (){
    set_time_limit(0);
    for($i=1;$i<100000;$i++){
        DB::insert("INSERT INTO `product` (`id`, `sku`, `spu`, `cate_id`, `name`, `status`, `gender`, `size`, `frame_width`, `lens_width`, `lens_height`, `bridge_width`, `arm_length`, `shape`, `material`, `frame`, `color`, `feature`, `price`, `viewed`, `createtime`, `sale`) VALUES (".$i.", 'sku".$i."', 'spu".$i."', 14, 'Kissimmee', 1, '2,3', 3, 142, 51, 41, 21, 149, 6, '6', 1, '23,15', '3', 12.95, 0, 1647504759, 0);");
    }
});
