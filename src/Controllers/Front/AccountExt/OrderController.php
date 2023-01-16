<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Models\PaymentRefund;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderHistory;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $res['list'] = Order::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('orderStatus')
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        $cancel_fee = $this->shop_setting['order_cancel_fee'];
        foreach ($res['list'] as $val){
            $val->cancelAmount = ceil((100 - $cancel_fee)/100*$val->total*100)/100;
            $val->cancelAmountFormat = Currency::codeFormat($val->cancelAmount,$val->currency_code);
        }
        return $this->makeView('laravel-shop-front::account_ext.order.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('orderStatus')
            ->with(['orderTotal'=>function ($query) {
                    $query->orderBy('sort', 'asc');
                }])->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['info']->id)->with('orderOption')->get();
        $res['orderHistory'] = OrderHistory::where('order_id',$res['info']->id)->with('orderStatus')->orderBy('created_at','asc')->get();
        $res['orderRefund'] = PaymentRefund::where('payment_id',$res['info']->payment_id)->get();
        foreach ($res['orderRefund'] as $val){
            $val->amountFormat = Currency::codeFormat($val->amountFormat,$val->currency_code);
        }
        return $this->makeView('laravel-shop-front::account_ext.order.detail',['res'=>$res]);
    }

    public function pay(Request $request)
    {
        $res['info'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->where('order_status_id',1)->firstOrError();
        if($res['info']->payment_id){
            (new Payment)->pay(true,$res['info']->payment_id);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'order error']);
        }
    }

    public function close(Request $request)
    {
        $res['info'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->firstOrError();
        if($res['info']->order_status_id==1) {
            $res['info']->addOrderHistory($res['info'], 5);
            throw new ApiException(['code'=>0,'msg'=>'order option success','data'=>['redirect'=>'/account_ext/order']]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'order status error','data'=>['redirect'=>'/account_ext/order']]);
        }
    }

    public function cancel(Request $request)
    {
        $res['info'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->firstOrError();
        if($res['info']->order_status_id==2){
            $cancel_fee = $this->shop_setting['order_cancel_fee'];
            $amount = ceil((100 - $cancel_fee)/100*$res['info']->total*100)/100;
            (new Payment)->cancel($res['info']->payment_id,$amount);
            $res['info']->addOrderHistory($res['info'], 6);
            if($this->shop_setting['order_status_canceled_notify']==1){
                //send email
            }
            throw new ApiException(['code'=>0,'msg'=>'order option success','data'=>['redirect'=>'/account_ext/order']]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'order status error','data'=>['redirect'=>'/account_ext/order']]);
        }
    }



}
