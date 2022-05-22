<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\Common\Category;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Controller extends \Aphly\LaravelShop\Controllers\Controller
{

    public function __construct()
    {
        View::share("category",(new Category)->findAll());
        $visitor = Cookie::get('visitor');
        if(!$visitor){
            Cookie::queue('visitor',Str::random(32),24*3600);
        }
        parent::__construct();
    }


}
