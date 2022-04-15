<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $res['title'] = '';

        return $this->makeView('laravel-shop::product.index',['res'=>$res]);
    }


}
