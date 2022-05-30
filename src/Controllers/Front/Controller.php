<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Controller extends \Aphly\LaravelShop\Controllers\Controller
{

    public function __construct()
    {
        View::share("category",(new Category)->findAll());
        View::share("currency",(new Currency)->findAll(1));
        $guest = Cookie::get('guest');
        if(!$guest){
            Cookie::queue('guest',Str::random(32),24*3600);
        }
        $currency = Cookie::get('currency');
        if(!$currency){
            $setting = Setting::findAll();
            Cookie::queue('currency',$setting['config']['currency']??'');
        }
        parent::__construct();
    }


}
