<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Services\Yuntu;
use Illuminate\Http\Request;

class TrackingController extends Controller
{

    public function index(Request $request)
    {
        $res['title'] = 'Tracking Information';
        $input = $request->all();
        $res['order_number'] = $input['order_number']??'';
        if($request->isMethod('post')) {
            if($res['order_number']){
                $order = Order::where('tracking_number',$res['order_number'])->first();
                if(!$order){
                    throw new ApiException(['code' => 3, 'msg' => 'Order does not exist']);
                }
                $orderInfo['addr'] =  $order->delivery_address_1.' '.$order->delivery_address_2.' , '.$order->delivery_city.' , '.$order->delivery_zone.' , '.$order->delivery_country.' , '.$order->delivery_postcode;
                $tracking = (new Yuntu)->createTrack($res['order_number']);
                throw new ApiException(['code' => 0, 'msg' => 'Success','data'=>['tracking'=>$tracking,'orderInfo'=>$orderInfo]]);
            }else{
                throw new ApiException(['code' => 1, 'msg' => 'Fail']);
            }
        }else{
            return $this->makeView('laravel-shop::front.common.tracking.index',['res'=>$res]);
        }
    }



}
