<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';
        return $this->makeView('laravel-shop-front::home.index',['res'=>$res]);
    }

    public function home1(Request $request)
    {
        $filter_data = [
            'name'      => $request->query('name',false),
            'sort'      => $request->query('sort',false),
        ];
        $product = new Product;
        $res['list'] = $product->getList($filter_data,true);
        dd($res['list']);
        $cart = new Cart;
        $res['list'] = $cart->getList();
        $res['total_data'] = $cart->totalData();

        dd($res['list']);
        $shipping = (new Shipping())->getTotal();
        dd($shipping);
    }

}
