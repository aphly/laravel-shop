<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Address;
use Aphly\LaravelShop\Models\Account\Customer;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $res['list'] = (new Cart)->getProducts();
        $res['items'] = 0;
        if($res['list']){
            foreach ($res['list'] as $cart) {
                $product_total = 0;
                foreach ($res['list'] as $cart2) {
                    if ($cart2['product_id'] == $cart['product_id']) {
                        $product_total += $cart2['quantity'];
                    }
                }
                if ($cart['product']['minimum'] > $product_total) {
                    return redirect('cart');
                }
                $res['items'] += $cart['quantity'];
            }
            $res['total_data'] = (new Extension)->total($res['list']);
            $res['customer_address'] = Address::where('uuid',Customer::uuid())->get()->toArray();

            return $this->makeView('laravel-shop::front.checkout.checkout',['res'=>$res]);
        }else{
            return redirect('cart');
        }
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
            $Cart = new Cart;
            $Cart->add($res['info']->id, $quantity, $option);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['count'=>$Cart->countProducts()]]);
        }
    }



}
