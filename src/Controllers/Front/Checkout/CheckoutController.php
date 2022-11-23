<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Models\PaymentMethod;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderOption;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\OrderTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{

    public function address(Request $request)
    {
        $res['title'] = 'Checkout Address';
    	if($request->isMethod('post')){
			$res['info'] = (new UserAddress)->getAddress($request->input('address_id'));
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
            $cart = new Cart;
            list($res['count'],$res['list']) = $cart->countList();
            if($res['list']) {
                $res['total_data'] = $cart->totalData();
                $res['address'] = (new UserAddress)->getAddresses();
                return $this->makeView('laravel-shop-front::checkout.address', ['res' => $res]);
            }else{
                return redirect('cart');
            }
		}
    }

    public function shipping(Request $request)
    {
        $res['title'] = 'Checkout Shipping';
        $address_id = Cookie::get('shop_address_id');
        $res['address'] = (new UserAddress)->getAddress($address_id);
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
						throw new ApiException(['code' => 0, 'msg' => 'shipping method success', 'data' => ['redirect'=>'/checkout/pay','list' => $payment_method]]);
					}
				}
			}
			Cookie::queue('shop_shipping_id', null, -1);
			throw new ApiException(['code' => 1, 'msg' => 'shipping method fail']);
		}else{
            Cookie::queue('shop_shipping_id', null, -1);
            $cart = new Cart;
            $res['list'] = $cart->getList();
            $res['total_data'] = $cart->totalData();
			$res['shipping'] = (new Shipping)->getList();
			return $this->makeView('laravel-shop-front::checkout.shipping',['res'=>$res]);
		}
    }

    public function pay(Request $request)
    {
        $res['title'] = 'Checkout Pay';
        $address_id = Cookie::get('shop_address_id');
        $res['address'] = (new UserAddress)->getAddress($address_id);
        if(!$res['address']){
            return redirect('/checkout/address');
        }
        $shipping_id = Cookie::get('shop_shipping_id');
        $res['shipping'] = (new Shipping)->getList($address_id,$shipping_id);
        if(!$res['shipping']){
            return redirect('/checkout/shipping');
        }
        $cart = new Cart;
        $res['list'] = $cart->getList();
        $res['total_data'] = $cart->totalData();
		if($request->isMethod('post')) {
            $input['uuid'] = $this->user->uuid;

            $input['address_id'] = $res['address']['id'];
            $input['address_firstname'] = $res['address']['firstname'];
            $input['address_lastname'] = $res['address']['lastname'];
            $input['address_address_1'] = $res['address']['address_1'];
            $input['address_address_2'] = $res['address']['address_2'];
            $input['address_city'] = $res['address']['city'];
            $input['address_postcode'] = $res['address']['postcode'];
            $input['address_country'] = $res['address']['country_name'];
            $input['address_country_id'] = $res['address']['country_id'];
            $input['address_zone'] = $res['address']['zone_name'];
            $input['address_zone_id'] = $res['address']['zone_id'];
            $input['address_telephone'] = $res['address']['telephone'];

            $input['shipping_id'] = $res['shipping']['id'];
            $input['shipping_name'] = $res['shipping']['name'];
            $input['shipping_desc'] = $res['shipping']['desc'];
            $input['shipping_cost'] = $res['shipping']['cost'];
            $input['shipping_free_cost'] = $res['shipping']['free_cost'];
            $input['shipping_geo_group_id'] = $res['shipping']['geo_group_id'];

            $input['payment_method_id'] = $request->input('payment_method_id');
            if(!intval($input['payment_method_id'])){
                throw new ApiException(['code' => 2, 'msg' => 'payment method fail']);
            }

            $input['total'] = $res['total_data']['total'];
            if($input['total']>0){
            }else{
                throw new ApiException(['code' => 3, 'msg' => 'amount error']);
            }
            $input['comment'] = '';
            $currency = Currency::defaultCurr(true);
            if(!$currency){
                throw new ApiException(['code' => 4, 'msg' => 'currency error']);
            }
            $input['currency_id'] = $currency['id'];
            $input['currency_code'] = $currency['code'];
            $input['currency_value'] = $currency['value'];

            $input['ip'] = $request->ip();
            $input['user_agent'] = $request->header('user-agent');
            $input['accept_language'] = $request->header('accept-language');
            $order = Order::create($input);
            if($order->id){
                $orderTotal_input = [];
                foreach ($res['total_data']['totals'] as $val){
                    $val['order_id'] = $order->id;
                    $orderTotal_input[] = $val;
                }
                $orderTotal_input[] = [
                    'order_id'=>$order->id,
                    "title" => "Total",
                    "value" => $res['total_data']['total'],
                    "value_format" => $res['total_data']['total_format'],
                    "sort" => 0,
                ];
                OrderTotal::insert($orderTotal_input);

                foreach ($res['list'] as $val){
                    $orderProduct_input = $val;
                    $orderProduct_input['order_id'] = $order->id;
                    $orderProduct_input['name'] = $val['product']['name'];
                    $orderProduct_input['sku'] = $val['product']['sku'];
                    $orderProduct = OrderProduct::create($orderProduct_input);
                    if($orderProduct->id){
                        foreach ($val['option'] as $v){
                            $orderOption = $v;
                            $orderOption['order_id'] = $order->id;
                            $orderOption['order_product_id'] = $orderProduct->id;
                            $orderOption['product_option_id'] = $v['option_id'];
                            $orderOption['product_option_value_id'] = $v['product_option_value']['id'];
                            $orderOption['name'] = $v['option']['name'];
                            $orderOption['value'] = $v['product_option_value']['option_value']['name'];
                            $orderOption['type'] = $v['option']['type'];
                            OrderOption::create($orderOption);
                        }
                    }
                }

                $payment_input['amount'] = $res['total_data']['total'];
                $payment_input['currency_code'] = $currency['code'];
                $payment_input['cancel_url'] = url('/checkout/payment_method');
                $payment_input['notify_func'] = '\Aphly\LaravelShop\Models\Sale\Order@notify';
                $payment_input['success_url'] = url('/checkout/success');
                $payment_input['fail_url'] = url('/checkout/fail');
                $payment = (new Payment)->make($payment_input);
                if($payment->id){
                    $order->payment_id = $payment->id;
                    if($order->save()){
                        $cart->delUuid();
                        throw new ApiException(['code' => 1, 'msg' => 'payment hhh']);
                        //$payment->pay(false);
                    }
                }
            }
			throw new ApiException(['code' => 1, 'msg' => 'payment method fail']);
		}else{
			$res['paymentMethod'] = (new PaymentMethod)->findAll();
			return $this->makeView('laravel-shop-front::checkout.payment_method',['res'=>$res]);
		}
    }






}
