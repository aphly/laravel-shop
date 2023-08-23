<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home';
        $res['data_products'] = [
            ['title'=>'Top','product_ids'=>[
                1,2,3
            ]],
            ['title'=>'New','product_ids'=>[
                1,2,3
            ]],
        ];

        $product_ids = [];
        foreach ($res['data_products'] as $val){
            foreach ($val['product_ids'] as $v){
                $product_ids[$v] = $v;
            }
        }
        $product = new Product;
        $products = $product->getByids($product_ids);
        $res['products'] = $products;
        foreach ($products as $key=>$val){
            $res['products'][$key]->image_src= UploadFile::getPath($val->image,true);
            $res['products'][$key]->price = Currency::format($val->price);
            $res['products'][$key]->special = $val->special?Currency::format($val->special):0;
            $res['products'][$key]->discount =  $val->discount?Currency::format($val->discount):0;
        }
        return $this->makeView('laravel-shop-front::common.home.index',['res'=>$res]);
    }

}
