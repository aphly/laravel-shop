<?php

namespace Aphly\LaravelShop\Controllers\Front;

class StatusController extends Controller
{

    public function notfound()
    {
        $res['title'] = '404';
        return $this->makeView('laravel-front::common.notfound',['res'=>$res]);
    }


    public function blocked()
    {
        $res['title'] = 'blocked';
        return $this->makeView('laravel-front::common.blocked',['res'=>$res]);
    }

}
