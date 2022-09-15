<?php

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Models\UserViewChapter;
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

    Route::get('/', 'Aphly\LaravelShop\Controllers\Front\HomeController@index');

    Route::middleware(['userAuth'])->prefix('account')->group(function () {

    });


});


Route::middleware(['web'])->group(function () {

    Route::prefix('shop_admin')->middleware(['managerAuth'])->group(function () {

        Route::middleware(['rbac'])->group(function () {

            $route_arr = [
                ['novel','\NovelController'],['chapter','\ChapterController'],['book','\BookController']
            ];

            foreach ($route_arr as $val){
                Route::get('/'.$val[0].'/index', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@index');
                Route::get('/'.$val[0].'/form', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@form');
                Route::post('/'.$val[0].'/save', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@save');
                Route::post('/'.$val[0].'/del', 'Aphly\LaravelShop\Controllers\Admin'.$val[1].'@del');
            }

        });
    });

});
