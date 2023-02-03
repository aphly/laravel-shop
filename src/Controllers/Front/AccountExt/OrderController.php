<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Mail\MailSend;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelPayment\Models\PaymentRefund;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Mail\Order\Status\Processing;
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
        $res['cancel_fee_24'] = $this->shop_setting['order_cancel_fee_24'];
        $res['cancel_fee'] = $this->shop_setting['order_cancel_fee'];
//        foreach ($res['list'] as $val){
//            list($val->cancelAmount,$val->cancelAmountFormat) = Currency::codeFormat((100 - $cancel_fee)/100*$val->total,$val->currency_code);
//        }
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
        $cancel_fee = $this->shop_setting['order_cancel_fee'];
        foreach ($res['orderHistory'] as $val){
            if($val->order_status_id==2 && $val->created_at->timestamp+24*3600>time()){
                $cancel_fee = $this->shop_setting['order_cancel_fee_24'];
            }
        }
        list($res['cancelAmount'],$res['cancelAmountFormat']) = Currency::codeFormat((100 - $cancel_fee)/100*$res['info']->total,$res['info']->currency_code);
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
        $orderHistory = OrderHistory::where(['order_id'=>$res['info']->id,'order_status_id'=>2])->first();
        if($res['info']->order_status_id==2 && !empty($orderHistory)){
            $cancel_fee = $this->shop_setting['order_cancel_fee'];
            if($orderHistory->created_at->timestamp+24*3600>time()){
                $cancel_fee = $this->shop_setting['order_cancel_fee_24'];
            }
            list($amount) = Currency::codeFormat((100 - $cancel_fee)/100*$res['info']->total,$res['info']->currency_code);
            (new Payment)->refund_api($res['info']->payment_id,$amount,'Customer cancel -'.$cancel_fee.'% fee');
            $res['info']->addOrderHistory($res['info'], 6);
            if($this->shop_setting['order_status_canceled_notify']==1){
                //send email
                (new MailSend())->do($res['info']->email, new Processing($res['info']));
            }
            throw new ApiException(['code'=>0,'msg'=>'order option success','data'=>['redirect'=>'/account_ext/order']]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'order status error','data'=>['redirect'=>'/account_ext/order']]);
        }
    }



}
