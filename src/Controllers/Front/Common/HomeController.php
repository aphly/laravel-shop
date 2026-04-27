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


class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home';
        $res['data_products'] = [
            ['title'=>$this->shop_config['index1_k'],'product_ids'=>explode(',',$this->shop_config['index1_v'])],
            ['title'=>$this->shop_config['index2_k'],'product_ids'=>explode(',',$this->shop_config['index2_v'])],
            ['title'=>$this->shop_config['index3_k'],'product_ids'=>explode(',',$this->shop_config['index3_v'])],
            ['title'=>$this->shop_config['index4_k'],'product_ids'=>explode(',',$this->shop_config['index4_v'])],
        ];

        $res['banner'] = Banner::findAll();
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

    function tracking(Request $request)
    {
        if($request->isMethod('post')) {
            $input = $request->all();
            $orderInfo = Order::where('id',$input['order_id'])->firstOrError();

            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            $res['title'] = 'Contact Us';
            return $this->makeView('laravel-shop::front.common.contact_us.index',['res'=>$res]);
        }
    }

}
