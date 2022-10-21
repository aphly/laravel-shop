<?php

namespace Aphly\LaravelShop\Controllers\Front\Customer;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $res['title'] = '';
        //$res['user'] = session('user');
        return $this->makeView('laravel-shop::front.customer.account',['res'=>$res]);
    }




}
