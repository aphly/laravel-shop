<?php

namespace Aphly\LaravelShop\Controllers\Front;


class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';

        return $this->makeView('laravel-novel::front.home.index',['res'=>$res]);
    }


}
