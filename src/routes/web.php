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

});
