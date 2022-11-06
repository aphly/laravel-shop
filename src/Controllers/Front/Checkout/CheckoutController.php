<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelPayment\Models\PaymentMethod;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelCommon\Models\Address;
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
    	if($request->isMethod('post')){
			$res['info'] = (new Address)->getAddress($request->input('address_id'));
			if($res['info']){
				Cookie::queue('shop_address_id',$res['info']['id']);
				$shipping_method = (new Shipping)->getList($res['info']['id']);
				throw new ApiException(['code'=>0,'msg'=>'shipping address success','data'=>['list'=>$shipping_method]]);
			}else{
				Cookie::queue('shop_address_id', null , -1);
				throw new ApiException(['code'=>1,'msg'=>'shipping address fail']);
			}
		}else{
			$res['address'] = (new Address)->getAddresses();
			return $this->makeView('laravel-shop::front.checkout.address',['res'=>$res]);
		}
    }

    public function shipping(Request $request)
    {
		if($request->isMethod('post')) {
			$shipping_method_all = (new Shipping)->getList();
			if ($shipping_method_all) {
				foreach ($shipping_method_all as $key => $val) {
					if ($key == $request->input('shipping_id')) {
						Cookie::queue('shop_shipping_id', $key);
						$payment_method = (new PaymentMethod)->findAll();
						throw new ApiException(['code' => 0, 'msg' => 'shipping method success', 'data' => ['list' => $payment_method]]);
					}
				}
			}
			Cookie::queue('shop_shipping_id', null, -1);
			throw new ApiException(['code' => 1, 'msg' => 'shipping method fail']);
		}else{
			$res['address'] = (new Address)->getAddresses();
			$res['shipping'] = (new Shipping)->getList();
			return $this->makeView('laravel-shop::front.checkout.shipping',['res'=>$res]);
		}
    }

    public function paymentMethod(Request $request)
    {
		if($request->isMethod('post')) {
			$payment_method_all = (new PaymentMethod)->findAll();
			if ($payment_method_all) {
				foreach ($payment_method_all as $key => $val) {
					if ($key == $request->input('payment_method_id')) {
						Cookie::queue('payment_method_id', $key);
						throw new ApiException(['code' => 0, 'msg' => 'payment method success']);
					}
				}
			}
			Cookie::queue('payment_method_id', null, -1);
			throw new ApiException(['code' => 1, 'msg' => 'payment method fail']);
		}else{
			$res['address'] = (new Address)->getAddresses();
			$res['shipping'] = (new Shipping)->getList();
			$res['paymentMethod'] = (new PaymentMethod)->findAll();
			return $this->makeView('laravel-shop::front.checkout.payment',['res'=>$res]);
		}
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
