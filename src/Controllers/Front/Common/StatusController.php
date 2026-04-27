<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\LaravelShop\Controllers\Front\Controller;

class StatusController extends Controller
{

    public function notfound()
    {
        $res['title'] = '404';
        return $this->makeView('laravel-shop::front.common.notfound',['res'=>$res]);
    }


    public function blocked()
    {
        $res['title'] = 'blocked';
        return $this->makeView('laravel-shop::front.common.blocked',['res'=>$res]);
    }

}
