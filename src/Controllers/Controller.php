<?php

namespace Aphly\LaravelShop\Controllers;

use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;

class Controller extends \Aphly\LaravelAdmin\Controllers\Controller
{

    public function __construct()
    {
        $currency = Cookie::get('currency');
        if(!$currency){
            $setting = Setting::findAll();
            Cookie::queue('currency',$setting['config']['currency']??'');
        }
        parent::__construct();
    }


}
