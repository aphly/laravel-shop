<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $res['title'] = '';
        //$res['user'] = session('user');
        return $this->makeView('laravel-shop::account.index',['res'=>$res]);
    }




}
