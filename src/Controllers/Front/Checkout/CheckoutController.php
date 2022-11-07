<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Models\PaymentMethod;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelCommon\Models\Address;
use Aphly\LaravelShop\Models\Sale\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
    public function index()
    {
		$res['title'] = 'Checkout';
    	$cart = new Cart;
        $res['list'] = $cart->getProducts();
        $res['items'] = 0;
        if($res['list']){
            foreach ($res['list'] as $cart1) {
                $product_total = 0;
                foreach ($res['list'] as $cart2) {
                    if ($cart2['product_id'] == $cart1['product_id']) {
                        $product_total += $cart2['quantity'];
                    }
                }
                if ($cart1['product']['minimum'] > $product_total) {
                    return redirect('cart');
                }
                $res['items'] += $cart1['quantity'];
            }
            $res['total_data'] = $cart->totalData();
            $res['address'] = (new Address)->getAddresses();
			$res['shipping'] = (new Shipping)->getList();
			$res['paymentMethod'] = (new PaymentMethod)->findAll();
            return $this->makeView('laravel-shop::front.checkout.checkout',['res'=>$res]);
        }else{
            return redirect('cart');
        }
    }

    public function address(Request $request)
    {
        $res['title'] = 'Checkout Address';
    	if($request->isMethod('post')){
			$res['info'] = (new Address)->getAddress($request->input('address_id'));
			if($res['info']){
				Cookie::queue('shop_address_id',$res['info']['id']);
				$shipping_method = (new Shipping)->getList($res['info']['id']);
				throw new ApiException(['code'=>0,'msg'=>'shipping address success','data'=>['redirect'=>'/checkout/shipping','list'=>$shipping_method]]);
			}else{
				Cookie::queue('shop_address_id', null , -1);
				throw new ApiException(['code'=>1,'msg'=>'shipping address fail']);
			}
		}else{
            Cookie::queue('shop_address_id', null , -1);
            Cookie::queue('shop_shipping_id', null, -1);
            Cookie::queue('payment_method_id', null, -1);
            $cart = new Cart;
            $res['list'] = $cart->getProducts();
            $res['total_data'] = $cart->totalData();
			$res['address'] = (new Address)->getAddresses();
			return $this->makeView('laravel-shop::front.checkout.address',['res'=>$res]);
		}
    }

    public function shipping(Request $request)
    {
        $res['title'] = 'Checkout Shipping';
        $address_id = Cookie::get('shop_address_id');
        $res['address'] = (new Address)->getAddress($address_id);
        if(!$res['address']){
            return redirect('/checkout/address');
        }
		if($request->isMethod('post')) {
			$shipping_method_all = (new Shipping)->getList();
			if ($shipping_method_all) {
				foreach ($shipping_method_all as $key => $val) {
					if ($key == $request->input('shipping_id')) {
						Cookie::queue('shop_shipping_id', $key);
						$payment_method = (new PaymentMethod)->findAll();
						throw new ApiException(['code' => 0, 'msg' => 'shipping method success', 'data' => ['redirect'=>'/checkout/payment_method','list' => $payment_method]]);
					}
				}
			}
			Cookie::queue('shop_shipping_id', null, -1);
			throw new ApiException(['code' => 1, 'msg' => 'shipping method fail']);
		}else{
            Cookie::queue('shop_shipping_id', null, -1);
            Cookie::queue('payment_method_id', null, -1);
            $cart = new Cart;
            $res['list'] = $cart->getProducts();
            $res['total_data'] = $cart->totalData();
			$res['shipping'] = (new Shipping)->getList();
			return $this->makeView('laravel-shop::front.checkout.shipping',['res'=>$res]);
		}
    }

    public function pay(Request $request)
    {
        $res['title'] = 'Checkout Pay';
        $address_id = Cookie::get('shop_address_id');
        $res['address'] = (new Address)->getAddress($address_id);
        if(!$res['address']){
            return redirect('/checkout/address');
        }
        $shipping_id = Cookie::get('shop_shipping_id');
        $res['shipping'] = (new Shipping)->getList($address_id,$shipping_id);
        if(!$res['shipping']){
            return redirect('/checkout/shipping');
        }
        $cart = new Cart;
        $res['list'] = $cart->getProducts();
        $res['total_data'] = $cart->totalData();
		if($request->isMethod('post')) {
            $input['amount'] = $res['total_data']['total'];
            $input['method_id'] = $request->input('payment_method_id');
            $input['cancel_url'] = url('/checkout/payment_method');
            $input['notify_func'] = '\Aphly\LaravelShop\Models\Sale\Order@notify';
            $input['success_url'] = url('/checkout/success');
            $input['fail_url'] = url('/checkout/fail');
            $payment = (new Payment)->make($input);
            if($payment->id){
                $input['uuid'] = $this->user->uuid;
                $input['payment_id'] = $payment->id;
                $order = Order::create($input);
                if($order->id){
                    $payment->pay(false);
                }
            }

			throw new ApiException(['code' => 1, 'msg' => 'payment method fail']);
		}else{
			$res['paymentMethod'] = (new PaymentMethod)->findAll();
			return $this->makeView('laravel-shop::front.checkout.payment_method',['res'=>$res]);
		}
    }






}
