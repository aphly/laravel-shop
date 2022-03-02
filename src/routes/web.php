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
Route::middleware(['throttle:5,10'])->match(['get', 'post'],'/admin/test', 'Aphly\LaravelShop\Controllers\IndexController@test');

//Route::get('/admin/init', 'Aphly\LaravelShop\Controllers\InitController@index');

Route::middleware(['web'])->group(function () {

    Route::prefix('admin')->middleware(['managerAuth'])->group(function () {
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelShop\Controllers\IndexController@login');
        Route::get('/index', 'Aphly\LaravelShop\Controllers\IndexController@layout');
        Route::get('/logout', 'Aphly\LaravelShop\Controllers\IndexController@logout');
        Route::get('/cache', 'Aphly\LaravelShop\Controllers\IndexController@cache');

        Route::middleware(['rbac'])->group(function () {
            Route::get('/index/index', 'Aphly\LaravelShop\Controllers\IndexController@index');

        });
    });

});
