<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;


use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;


class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home';
        $res['data_products'] = [
            ['title'=>'Best Sellers','product_ids'=>[
                1,2,3
            ]],
            ['title'=>'New Arrivals','product_ids'=>[
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
            $res['products'][$key]->image_src= UploadFile::getPath($val->image,$val->remote);
            $res['products'][$key]->price = Currency::format($val->price);
            $res['products'][$key]->special = $val->special?Currency::format($val->special):0;
            $res['products'][$key]->discount =  $val->discount?Currency::format($val->discount):0;
        }
        $res['product_option'] = $product->optionValueColor($product_ids);
        $res['product_option_value_image'] = [];
        foreach ($res['product_option'] as $val){
            foreach ($val['product_option_value'] as $v){
                if(!empty($v['product_image_id'])){
                    $res['product_option_value_image'][$val['product_id']][$v['product_image_id']] = $v['product_image']['image_src'];
                }
            }
        }
        //$res['product_image'] = $product->imgByIds($product_ids);
        return $this->makeView('laravel-shop-front::common.home.index',['res'=>$res]);
    }

}
