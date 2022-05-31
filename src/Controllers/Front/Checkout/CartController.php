<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $res['list'] = (new Cart)->getProducts();
        return $this->makeView('laravel-shop::front.checkout.cart',['res'=>$res]);
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
                    throw new ApiException(['code'=>1,'msg'=>$val['option_value']['name'].'required']);
                }
            }
            (new Cart)->add($res['info']->id, $quantity, $option);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }
    }



}
