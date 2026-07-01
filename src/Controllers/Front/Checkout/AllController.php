<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Form;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\RemoteEmail;
use Aphly\Laravel\Models\CommonUserAuth;
use Aphly\Laravel\Requests\FormRequest;
use Aphly\LaravelPayment\Models\Paypal;
use Aphly\LaravelPayment\Services\Paypal\Client;
use Aphly\LaravelShop\Mail\Account\GuestPassword;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Models\PaymentMethod;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Account\UserAddress;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderOption;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\OrderTotal;
use Aphly\LaravelShop\Models\Setting\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AllController extends Controller
{
    public function email(FormRequest $request)
    {
        $input = $request->all();
        $request->validate($input, [
            'email' => 'required|email',
        ]);
        $UserAuth = CommonUserAuth::where(['id_type'=>'email','id'=>$input['email']])->first();
        if(!empty($UserAuth)){
            Form::throwErr('email','This email has been registered, please use this email to log in.');
        }else{
            throw new ApiException(['code' => 0, 'msg' => 'Success']);
        }
    }

    public function payment(FormRequest $request)
    {
        $cart = new Cart;
        list($res['count'], $res['list'], $res['total_data']) = $cart->totalData();
        if (!$res['count']) {
            throw new ApiException(['code' => 11, 'msg' => 'no cart', 'data' => ['redirect' => '/cart']]);
        }
        $userAddressModel = (new UserAddress);
        $input = $request->all();
        $request->validate($input, [
            'address_id' => 'required|numeric',
            'shipping_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'same' => 'required|in:0,1',
        ]);

        if($this->user){
            if($input['address_id']>0){
                $userAddress = $userAddressModel->getAddress($input['address_id']);
            }else{
                $request->validate($input, [
                    'firstname' => 'required|between:2,32',
                    'lastname' => 'required|between:2,32',
                    'address_1' => 'required|between:2,255',
                    'city' => 'required|between:2,128',
                    'postcode' => 'required|numeric',
                    'telephone' => 'required|numeric',
                    'country_id' => 'required|numeric',
                    'zone_id' => 'required|numeric',
                ]);
                $input['uid'] = $this->user->uid;
                $userAddress = $userAddressModel->create($input);
                $userAddress = $userAddressModel->getAddress($userAddress['id']);
            }
            if(!$input['same']){
                $request->validate($input, [
                    'billing_firstname' => 'required|between:2,32',
                    'billing_lastname' => 'required|between:2,32',
                    'billing_address_1' => 'required|between:2,255',
                    'billing_city' => 'required|between:2,128',
                    'billing_postcode' => 'required|numeric',
                    'billing_country_id' => 'required|numeric',
                    'billing_zone_id' => 'required|numeric',
                ]);
            }
        }else{
            $request->validate($input, [
                'email' => 'required|email',
                'firstname' => 'required|between:2,32',
                'lastname' => 'required|between:2,32',
                'address_1' => 'required|between:2,255',
                'city' => 'required|between:2,128',
                'postcode' => 'required|numeric',
                'telephone' => 'required|numeric',
                'country_id' => 'required|numeric',
                'zone_id' => 'required|numeric',
            ]);
            if(!$input['same']){
                $request->validate($input, [
                    'billing_firstname' => 'required|between:2,32',
                    'billing_lastname' => 'required|between:2,32',
                    'billing_address_1' => 'required|between:2,255',
                    'billing_city' => 'required|between:2,128',
                    'billing_postcode' => 'required|numeric',
                    'billing_country_id' => 'required|numeric',
                    'billing_zone_id' => 'required|numeric',
                ]);
            }

            $post['id_type'] = 'email';
            $post['id'] = $input['email'];
            $UserAuth = CommonUserAuth::where($post)->first();
            if(!empty($UserAuth)){
                Form::throwErr('email','This email has been registered, please use this email to log in.');
            }
            $post['uid'] = app('Snowflake')->nextId();
            $password = str::random(8);
            $post['password'] = Hash::make($password);
            $post['last_ip'] = $request->ip();
            $post['last_time'] = time();
            $post['user_agent'] = $request->header('user-agent');
            $post['accept_language'] = $request->header('accept-language');
            $userAuth = CommonUserAuth::create($post);
            if ($userAuth->uid) {
                $user = CommonUser::create([
                    'nickname' => str::random(8),
                    'uid' => $userAuth->uid,
                    'token' => Str::random(64),
                    'token_expire' => time() + 86400,
                ]);
                Auth::guard('user')->login($user);
                (new RemoteEmail())->send([
                    'email'=>$userAuth->id,
                    'title'=>'Aphly Account Password',
                    'content'=>(new GuestPassword($userAuth->id,$password))->render()
                ]);
                $this->user = $user;
                (new Wishlist)->afterRegister();
                (new Cart)->afterRegister();
                $user->id = $userAuth->id;
                $input['uid'] = $userAuth->uid;
                $userAddressInfo = $userAddressModel->create($input);
                $userAddress = $userAddressModel->getAddress($userAddressInfo['id']);
            }else{
                throw new ApiException(['code' => 3, 'msg' => 'UserAuth Error']);
            }
        }

        $input['id'] = app('Snowflake')->nextId();
        $input['uid'] = $this->user->uid;
        $input['email'] = $this->user->getEmail();
        if($cart->hasShipping()) {
            $input['address_id'] = $userAddress['id'];
            $input['delivery_firstname'] = $userAddress['firstname'];
            $input['delivery_lastname'] = $userAddress['lastname'];
            $input['delivery_address_1'] = $userAddress['address_1'];
            $input['delivery_address_2'] = $userAddress['address_2'];
            $input['delivery_city'] = $userAddress['city'];
            $input['delivery_postcode'] = $userAddress['postcode'];
            $input['delivery_country'] = $userAddress['country_name'];
            $input['delivery_country_id'] = $userAddress['country_id'];
            $input['delivery_zone'] = $userAddress['zone_name'];
            $input['delivery_zone_id'] = $userAddress['zone_id'];
            $input['delivery_telephone'] = $userAddress['telephone'];
            if($input['shipping_id']){
                $shipping_id = $input['shipping_id'];
            }else{
                $shipping_id = session('shop_shipping_id');
            }
            $res['shipping'] = (new Shipping)->getListGuest($shipping_id);
            if(!$res['shipping']){
                throw new ApiException(['code'=>13,'msg'=>'no shipping','data'=>['redirect'=>'/checkout/all']]);
            }
            $input['shipping_id'] = $res['shipping']['id'];
            $input['shipping_name'] = $res['shipping']['name'];
            $input['shipping_desc'] = $res['shipping']['desc'];
            $input['shipping_cost'] = $res['shipping']['cost'];
            $input['shipping_free_cost'] = $res['shipping']['free_cost'];
            $input['shipping_geo_group_id'] = $res['shipping']['geo_group_id'];

            if($input['same']) {
                $input['billing_firstname'] = $input['delivery_firstname'];
                $input['billing_lastname'] = $input['delivery_lastname'];
                $input['billing_address_1'] = $input['delivery_address_1'];
                $input['billing_address_2'] = $input['delivery_address_2'];
                $input['billing_city'] = $input['delivery_city'];
                $input['billing_postcode'] = $input['delivery_postcode'];
                $input['billing_country'] = $input['delivery_country'];
                $input['billing_country_id'] =  $input['delivery_country_id'];
                $input['billing_zone'] = $input['delivery_zone'];
                $input['billing_zone_id'] = $input['delivery_zone_id'];
            }else{
                $country_info = (new Country)->findOne($input['billing_country_id']);
                $input['billing_country'] = $country_info['name'];
                $zone_info = (new Zone)->findOne($input['billing_zone_id']);
                $input['billing_zone'] = $zone_info['name'];
            }
        }

        $input['items'] = $res['count'];
        $input['total'] = $res['total_data']['totals']['total']['value'];
        $input['currency_code'] = $res['total_data']['payment_currency_code'];
        $input['total_format'] = $res['total_data']['totals']['total']['value_format'];

        $input['comment'] = '';
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
            $payment_input['amount'] = $res['total_data']['payment_total'];
            $payment_input['currency_code'] =  $res['total_data']['payment_currency_code'];
            $payment_input['cancel_url'] = url('/checkout/all');
            $payment_input['notify_func'] = '\Aphly\LaravelShop\Models\Sale\Order@notify';
            $payment_input['success_url'] = url('/checkout/success?redirect='.urlencode(url('/account_ext/order')));
            $payment_input['fail_url'] = url('/checkout/fail?redirect='.urlencode($payment_input['cancel_url']));
            $payment = (new Payment)->make($payment_input);
            if($payment->id){
                $order->payment_id = $payment->id;
                $order->payment_method_name = $payment->method_name;
                if($order->save()){
                    //throw new ApiException(['code' => 1, 'msg' => 'payment hhh']);
                    $cart->clear();
                    $payment->pay(false);
                }
            }else{
                throw new ApiException(['code' => 2, 'msg' => 'payment fail']);
            }
        }
        throw new ApiException(['code' => 1, 'msg' => 'payment method fail']);
    }

    public function index(FormRequest $request)
    {
        $cart = new Cart;
        //shipping
        $res['shipping'] = (new Shipping)->getListGuest();
        $res['shipping_first'] = [];
        foreach ($res['shipping'] as $element) {
            if(!$element['disabled']){
                $res['shipping_first'] = $element;
                session(['shop_shipping_id'=> $element['id']]);
                break;
            }
        }
        //dd($res['shipping']);
        list($res['count'], $res['list'], $res['total_data']) = $cart->totalData();
        if (!$res['count']) {
            throw new ApiException(['code' => 11, 'msg' => 'no cart', 'data' => ['redirect' => '/cart']]);
        }
        $res['title'] = 'Checkout Payment';
        $res['breadcrumb'] = Breadcrumb::render([
            ['name' => 'Home', 'href' => '/'],
            ['name' => 'Cart', 'href' => '/cart'],
            ['name' => 'Payment', 'href' => '']
        ], false);

        $res['my_address'] = (new UserAddress)->getAddresses(false,3);
        $res['my_address_first'] = ['id'=>0];
        foreach ($res['my_address'] as $element) {
            $res['my_address_first'] = $element;
            break;
        }

        $res['country'] = (new Country)->findAll();
        $res['country_first'] = [];
        foreach ($res['country'] as $element) {
            $res['country_first'] = $element;
            break;
        }
        $res['zone'] = (new Zone)->findAllByCountry($res['country_first']['id']);

        //payment
        $res['paymentMethod'] = (new PaymentMethod)->findAll();
        //$res['stripe'] =  new Stripe;

        return $this->makeView('laravel-shop::front.checkout.all', ['res' => $res]);
    }



}
