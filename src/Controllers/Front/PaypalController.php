<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Services\Paypal\Client;
use Aphly\LaravelPayment\Services\Paypal\Order;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function index()
    {
        $paypalC = new Client();
        $res['title'] = 'xxx';
        $res['ClientID'] = $paypalC->client_id;
        return $this->makeView('laravel-shop::front.paypal',['res'=>$res]);
    }

    function order()
    {
        $payment_input['method_id'] = 1;
        $payment_input['amount'] = 10;
        $payment_input['currency_code'] =  'USD';
        $payment_input['cancel_url'] = url('/checkout/all');
        $payment_input['notify_func'] = '\Aphly\LaravelShop\Models\Sale\Order@notify';
        $payment_input['success_url'] = url('/checkout/success?redirect='.urlencode(url('/account_ext/order')));
        $payment_input['fail_url'] = url('/checkout/fail?redirect='.urlencode($payment_input['cancel_url']));
        $payment = (new Payment)->make($payment_input);
        $payment->pay(2);
    }

    function capture(Request $request)
    {
        $input = $request->all();
        $capture = (new Order)->capture($input['paypal_id']);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$capture]);
    }
}
