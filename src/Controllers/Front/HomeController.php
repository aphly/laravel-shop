<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\Review;
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

        $cart = new Cart;
        $res['list'] = $cart->getList();
        dd($res['list']);
//        $res['total_data'] = $cart->totalData();
        throw new ApiException(['code'=>1,'msg'=>'cccc','data'=>['redirect'=>'/aaa']]);
        $shipping = (new Shipping())->getTotal();
        dd($shipping);
    }

}
