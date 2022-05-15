<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['list'] = Product::where()->orderBy('date_add','desc')->Paginate(config('shop.perPage'))->withQueryString();

        return $this->makeView('laravel-shop::product.index',['res'=>$res]);
    }


}
