<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;


use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\CommonUploadFile;
use Aphly\LaravelPayment\Models\Currency;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Common\Banner;
use Aphly\LaravelShop\Models\Sale\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller
{
    public function index()
    {
        $res['title_full'] = config('base.title').' | Handcrafted S925 Silver 14K Gold‑Plated Jewelry Online';
        $res['description'] = 'Aphly fine jewelry features handcrafted S925 sterling silver plated in 14K gold. Shop necklaces, rings, bracelets, anklet, earrings and gemstone sets for daily wear, weddings and special occasions.';
        $product = new Product;
        $latest = Cache::remember('home_latest', 3600, function () use($product) {
            return $product->where('status',1)->where('date_available','<=',time())->orderBy('id',"desc")->select('id')->limit(8)->get()->toArray();
        });
        if($latest){
            $latest = array_column($latest,'id');
            $res['data_products'] = [
                ['title'=>'Latest','product_ids'=>$latest],
                ['title'=>$this->shop_config['index1_k'],'product_ids'=>explode(',',$this->shop_config['index1_v'])],
                ['title'=>$this->shop_config['index2_k'],'product_ids'=>explode(',',$this->shop_config['index2_v'])],
                ['title'=>$this->shop_config['index3_k'],'product_ids'=>explode(',',$this->shop_config['index3_v'])],
                ['title'=>$this->shop_config['index4_k'],'product_ids'=>explode(',',$this->shop_config['index4_v'])],
            ];
        }else{
            $res['data_products'] = [
                ['title'=>$this->shop_config['index1_k'],'product_ids'=>explode(',',$this->shop_config['index1_v'])],
                ['title'=>$this->shop_config['index2_k'],'product_ids'=>explode(',',$this->shop_config['index2_v'])],
                ['title'=>$this->shop_config['index3_k'],'product_ids'=>explode(',',$this->shop_config['index3_v'])],
                ['title'=>$this->shop_config['index4_k'],'product_ids'=>explode(',',$this->shop_config['index4_v'])],
            ];
        }

        $res['banner'] = Banner::findAll();
        $product_ids = [];
        foreach ($res['data_products'] as $val){
            foreach ($val['product_ids'] as $v){
                $product_ids[$v] = $v;
            }
        }

        $products = $product->getByids($product_ids);
        $res['products'] = $products;
        foreach ($products as $key=>$val){
            $res['products'][$key]->image_src= CommonUploadFile::getPath($val->image,$val->disk);
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
        return $this->makeView('laravel-shop::front.common.home.index',['res'=>$res]);
    }



}
