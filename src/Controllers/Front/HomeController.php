<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelCommon\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';
        return $this->makeView('laravel-shop::front.home.index',['res'=>$res]);
    }


}
