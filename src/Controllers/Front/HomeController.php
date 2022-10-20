<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';

        return $this->makeView('laravel-novel::front.home.index',['res'=>$res]);
    }


}
