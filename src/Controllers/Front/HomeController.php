<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Aphly\LaravelCommon\Models\Address;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';
        return $this->makeView('laravel-shop::front.home.index',['res'=>$res]);
    }

    public function home1()
    {
        //$Shipping = new Shipping;
        $shipping = (new Shipping())->getTotal();
        dd($shipping);
    }
}
