<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $res['title'] = '';
        $cart = new Cart;
        $res['list'] = $cart->getProducts();
        $res['items'] = 0;
        if($res['list']){
            foreach ($res['list'] as $product) {
                $product_total = 0;
                foreach ($res['list'] as $product2) {
                    if ($product2['product_id'] == $product['product_id']) {
                        $product_total += $product2['quantity'];
                    }
                }
                if ($product['product']['minimum'] > $product_total) {
                    $res['error'][] = 'minimum';
                }
                $res['items'] += $product['quantity'];
            }
        }
        $res['total_data'] = $cart->totalData();
        return $this->makeView('laravel-shop-front::checkout.cart',['res'=>$res]);
    }

    public function add(Request $request)
    {
        $res['info'] = Product::where('id',$request->input('product_id',0))->where('status',1)->first();
        if(!empty($res['info'])){
            $quantity = (int)$request->input('quantity',1);
            $option = array_filter($request->input('option',[]));
            $product_options = $res['info']->findOption($res['info']->id);
            foreach ($product_options as $val) {
                if ($val['required'] && empty($option[$val['id']])) {
                    throw new ApiException(['code'=>1,'msg'=>$val['option']['name'].' required']);
                }
            }
            $Cart = new Cart;
            $Cart->add($res['info']->id, $quantity, $option);
            list($count,$list) = $Cart->countProducts();
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['count'=>$count,'list'=>$list]]);
        }
    }



}
