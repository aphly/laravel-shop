<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Func;
use Aphly\Laravel\Libs\Snowflake;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Requests\FormRequest;
use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\LaravelShop\Models\Setting\Currency;
use Aphly\Laravel\Models\User;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Models\PaymentMethod;
use Aphly\LaravelPayment\Models\Stripe;
use Aphly\LaravelPayment\Models\StripeCard;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Account\UserAddress;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderOption;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\OrderTotal;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{

    public function address(FormRequest $request)
    {
        $res['title'] = 'Checkout Address';
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>'Home','href'=>'/'],
            ['name'=>'Cart','href'=>'/cart'],
            ['name'=>'Address','href'=>'']
        ],false);
        $cart = new Cart;
        if($cart->hasShipping()) {
            list($res['count'], $res['list'], $res['total_data']) = $cart->totalData();
            if (!$res['count']) {
                throw new ApiException(['code' => 11, 'msg' => 'no cart', 'data' => ['redirect' => '/cart']]);
            }
            if ($request->isMethod('post')) {
                $input = $request->all();
                $request->validate($input,[
                    'firstname' => 'required|between:2,32',
                    'lastname' => 'required|between:2,32',
                    'address_1' => 'required|between:2,255',
                    'city' => 'required|between:2,128',
                    'postcode' => 'required|numeric',
                    'telephone' => 'required|numeric',
                    'country_id' => 'required|numeric',
                    'zone_id' => 'required|numeric',
                ]);
                $input['uuid'] = User::uuid();
                $userAddress = UserAddress::updateOrCreate(['id' => $request->input('address_id', 0)], $input);
                session(['shop_address_id' => $userAddress->id]);
                $shipping_method = (new Shipping)->getList($userAddress->id);
                throw new ApiException(['code' => 0, 'msg' => 'shipping address success', 'data' => ['redirect' => '/checkout/shipping', 'list' => $shipping_method]]);
            } else {
                $request->session()->forget('shop_shipping_id');
                $res['curr_address_id'] = session('shop_address_id', 0);
                $res['my_address'] = (new UserAddress)->getAddresses();
                $res['country'] = (new Country)->findAll();
                return $this->makeView('laravel-front::checkout.address', ['res' => $res]);
            }
        }else{
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/checkout/payment']]);
        }
    }

    public function shipping(Request $request)
    {
        session()->forget('shop_shipping_id');
        $res['title'] = 'Checkout Shipping';
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>'Home','href'=>'/'],
            ['name'=>'Cart','href'=>'/cart'],
            ['name'=>'Address','href'=>'/checkout/address'],
            ['name'=>'Shipping','href'=>'']
        ],false);
        $cart = new Cart;
        list($res['count'],$res['list'],$res['total_data']) = $cart->totalData();
        if(!$res['count']){
            throw new ApiException(['code'=>11,'msg'=>'no cart','data'=>['redirect'=>'/cart']]);
        }
        $address_id = session('shop_address_id');
        $res['address'] = (new UserAddress)->getAddress($address_id);
        if(!$res['address']){
            throw new ApiException(['code'=>12,'msg'=>'no address','data'=>['redirect'=>'/checkout/address']]);
        }
		if($request->isMethod('post')) {
			$shipping_method_all = (new Shipping)->getList();
			if ($shipping_method_all) {
				foreach ($shipping_method_all as $key => $val) {
					if ($key == $request->input('shipping_id')) {
						session(['shop_shipping_id'=> $key]);
						$payment_method = (new PaymentMethod)->findAll();
						throw new ApiException(['code' => 0, 'msg' => 'shipping method success', 'data' => ['redirect'=>'/checkout/payment','list' => $payment_method]]);
					}
				}
			}
			throw new ApiException(['code' => 1, 'msg' => 'shipping method fail']);
		}else{
			$res['shipping'] = (new Shipping)->getList();
            $res['shipping_default_id'] = Func::defaultId($res['shipping']);
            $res['free_shipping'] = Cart::$free_shipping;
			return $this->makeView('laravel-front::checkout.shipping',['res'=>$res]);
		}
    }

    public function payment(Request $request)
    {
        $res['title'] = 'Checkout Pay';
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>'Home','href'=>'/'],
            ['name'=>'Cart','href'=>'/cart'],
            ['name'=>'Address','href'=>'/checkout/address'],
            ['name'=>'Shipping','href'=>'/checkout/shipping'],
            ['name'=>'Payment','href'=>''],
        ],false);
        $cart = new Cart;
        list($res['count'],$res['list'],$res['total_data']) = $cart->totalData();
        if(!$res['count']){
            throw new ApiException(['code'=>20,'msg'=>'no cart','data'=>['redirect'=>'/cart']]);
        }
        $res['hasShipping'] = $cart->hasShipping();
        if($res['hasShipping']){
            if(!$res['count']){
                throw new ApiException(['code'=>11,'msg'=>'no cart','data'=>['redirect'=>'/cart']]);
            }
            $address_id = session('shop_address_id');
            $res['address'] = (new UserAddress)->getAddress($address_id);
            if(!$res['address']){
                throw new ApiException(['code'=>12,'msg'=>'no address','data'=>['redirect'=>'/checkout/address']]);
            }
            $shipping_id = session('shop_shipping_id');
            $res['shipping'] = (new Shipping)->getList($address_id,$shipping_id);
            if(!$res['shipping']){
                throw new ApiException(['code'=>13,'msg'=>'no shipping','data'=>['redirect'=>'/checkout/shipping']]);
            }
        }


        list(,,$currency) = Currency::allDefaultCurr();
        if(!$currency){
            throw new ApiException(['code' => 4, 'msg' => 'currency error','data'=>['redirect'=>'/cart']]);
        }
        $res['currency'] = $currency;
        $res['success_url'] = url('/checkout/success?redirect='.urlencode(url('/account_ext/order')));
		if($request->isMethod('post')) {
            $input['payment_method_id'] = $request->input('payment_method_id');
            if(!intval($input['payment_method_id'])){
                throw new ApiException(['code' => 2, 'msg' => 'payment method fail','data'=>['redirect'=>'/checkout/payment']]);
            }
            if($input['payment_method_id']==3) {
                $card_payment_intent = session('card_payment_intent', '');
                if(!$card_payment_intent){
                    throw new ApiException(['code' => 1, 'msg' => 'card_payment_intent error']);
                }
            }
            $input['id'] = Snowflake::incrId();
            $input['uuid'] = $this->user->uuid;
            $input['email'] = $this->user->initId();
            if($res['hasShipping']) {
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
            }
            $input['items'] = $res['count'];
            $input['total'] = $res['total_data']['total'];
            $input['total_format'] = $res['total_data']['total_format'];

            $input['comment'] = '';

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
                OrderTotal::insert($orderTotal_input);
                foreach ($res['list'] as $val){
                    $orderProduct_input = $val;
                    $orderProduct_input['order_id'] = $order->id;
                    $orderProduct_input['name'] = $val['product']['name'];
                    $orderProduct_input['sku'] = $val['product']['sku'];
                    $orderProduct_input['image'] = $val['product']['image_src'];
                    $orderProduct = OrderProduct::create($orderProduct_input);
                    if($orderProduct->id){
                        foreach ($val['option'] as $v){
                            $orderOption = $v;
                            $orderOption['order_id'] = $order->id;
                            $orderOption['order_product_id'] = $orderProduct->id;
                            $orderOption['product_option_id'] = $v['option_id'];
                            $orderOption['name'] = $v['option']['name'];
                            $orderOption['type'] = $v['option']['type'];
                            if($v['option']['type']=='radio' || $v['option']['type']=='select'){
                                $orderOption['product_option_value_id'] = $v['product_option_value']['id'];
                                $orderOption['value'] = $v['product_option_value']['option_value']['name'];
                                OrderOption::create($orderOption);
                            }else if($v['option']['type']=='checkbox'){
                                foreach ($v['product_option_value'] as $v1){
                                    $orderOption['product_option_value_id'] = $v1['id'];
                                    $orderOption['value'] = $v1['option_value']['name'];
                                    OrderOption::create($orderOption);
                                }
                            }else{
                                $orderOption['product_option_value_id'] = 0;
                                $orderOption['value'] = $v['product_option_value'];
                                OrderOption::create($orderOption);
                            }
                        }
                    }
                }
                $order->addOrderHistory($order, 1);
                $payment_input['method_id'] = $input['payment_method_id'];
                $payment_input['amount'] = $res['total_data']['total'];
                $payment_input['currency_code'] = $currency['code'];
                $payment_input['cancel_url'] = url('/checkout/payment');
                $payment_input['notify_func'] = '\Aphly\LaravelShop\Models\Sale\Order@notify';
                $payment_input['success_url'] = $res['success_url'];
                $payment_input['fail_url'] = url('/checkout/fail?redirect='.urlencode($payment_input['cancel_url']));
                $payment = (new Payment)->make($payment_input);
                if($payment->id){
                    $order->payment_id = $payment->id;
                    $order->payment_method_name = $payment->method_name;
                    if($order->save()){
                        //throw new ApiException(['code' => 1, 'msg' => 'payment hhh']);
                        $cart->clear();
                        if($input['payment_method_id']==3){
                            session(['card_payment_id'=>$payment->id]);
                            $payment->transaction_id = $card_payment_intent;
                            $payment->save();
                            throw new ApiException(['code' => 0, 'msg' => 'success','data'=>['card'=>1,'payment_id'=>$payment->id]]);
                        }else{
                            $payment->pay(false);
                        }
                    }
                }else{
                    throw new ApiException(['code' => 2, 'msg' => 'payment fail']);
                }
            }
			throw new ApiException(['code' => 1, 'msg' => 'payment method fail']);
		}else{
			$res['paymentMethod'] = (new PaymentMethod)->findAll();
            $res['paymentMethod_default_id'] = Func::defaultId($res['paymentMethod']);
            $res['stripe'] =  new Stripe;
			return $this->makeView('laravel-front::checkout.payment_method',['res'=>$res]);
		}
    }


    function cardCreate(Request $request){
        $amount = floatval($request->input('amount',0));
        $currency = $request->input('currency','');
        (new StripeCard)->create($amount,$currency);
    }

    public function success(Request $request)
    {
        $res['title'] = 'Checkout Success';
        //$res['payment'] = Payment::where('id',$request->query('payment_id',0))->first();
        $res['redirect'] = $request->query('redirect','');
        if($res['redirect']){
            $res['redirect']= urldecode($res['redirect']);
        }
        return $this->makeView('laravel-front::checkout.success',['res'=>$res]);
    }

    public function fail(Request $request)
    {
        $res['title'] = 'Checkout Fail';
        //$res['payment'] = Payment::where('id',$request->query('payment_id',0))->first();
        $res['redirect'] = $request->query('redirect','');
        if($res['redirect']){
            $res['redirect']= urldecode($res['redirect']);
        }
        return $this->makeView('laravel-front::checkout.fail',['res'=>$res]);
    }
}
