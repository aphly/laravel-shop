<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';
        return $this->makeView('laravel-shop::front.home.index',['res'=>$res]);
    }

    public function home1(Request $request)
    {

        $cart = new Cart;
        $res['list'] = $cart->getProducts();
        $res['total_data'] = $cart->totalData();

        dd($res['list']);
        $shipping = (new Shipping())->getTotal();
        dd($shipping);
    }

}
