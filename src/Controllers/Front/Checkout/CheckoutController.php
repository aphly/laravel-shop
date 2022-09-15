<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Customer\Address;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Extension\Payment\Payment;
use Aphly\LaravelShop\Models\Extension\Shipping\Shipping;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
            $res['customer_address'] = (new Address)->getAddresses();
            return $this->makeView('laravel-shop::front.checkout.checkout',['res'=>$res]);
        }else{
            return redirect('cart');
        }
    }

    public function setShippingAddress(Request $request)
    {
        $res['info'] = (new Address)->getAddress($request->input('address_id'));
        if($res['info']){
            Cookie::queue('shipping_address',json_encode($res['info']));
            $total = $request->query('total',0);
            $shipping_method = (new Shipping)->checkout($total);
            Cookie::queue('shipping_method_all',json_encode($shipping_method));
            throw new ApiException(['code'=>0,'msg'=>'shipping address success','data'=>['list'=>$shipping_method]]);
        }else{
            Cookie::queue('shipping_address', null , -1);
            throw new ApiException(['code'=>1,'msg'=>'shipping address fail']);
        }
    }

    public function setShippingMethod(Request $request)
    {
        $shipping_method_all = Cookie::get('shipping_method_all');
        if($shipping_method_all){
            $shipping_method_all = json_decode($shipping_method_all,true);
            foreach ($shipping_method_all as $key=>$val){
                if($key==$request->input('shipping_code')){
                    Cookie::queue('shipping_method',json_encode($val));
                    $total = $request->query('total',0);
                    $payment_method = (new Payment)->checkout($total);
                    Cookie::queue('payment_method_all',json_encode($payment_method));
                    throw new ApiException(['code'=>0,'msg'=>'shipping method success','data'=>['list'=>$payment_method]]);
                }
            }
        }
        Cookie::queue('shipping_method', null , -1);
        throw new ApiException(['code'=>1,'msg'=>'shipping method fail']);
    }

    public function setPaymentMethod(Request $request)
    {
        $payment_method_all = Cookie::get('payment_method_all');
        if($payment_method_all){
            $payment_method_all = json_decode($payment_method_all,true);
            foreach ($payment_method_all as $key=>$val){
                if($key==$request->input('payment_code')){
                    Cookie::queue('payment_method',json_encode($val));
                    throw new ApiException(['code'=>0,'msg'=>'payment method success']);
                }
            }
        }
        Cookie::queue('payment_method', null , -1);
        throw new ApiException(['code'=>1,'msg'=>'payment method fail']);
    }

    public function confirm(Request $request)
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
            $shipping_address = Cookie::get('shipping_address');
            $shipping_method = Cookie::get('shipping_method');
            $payment_method = Cookie::get('payment_method');

            return $this->makeView('laravel-shop::front.checkout.checkout',['res'=>$res]);
        }else{
            return redirect('cart');
        }
    }




}
