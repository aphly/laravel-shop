<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;

use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\Service;
use Aphly\LaravelShop\Models\Sale\ServiceHistory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $res['list'] = Service::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('orderReturnReason')->with('orderReturnAction')->with('orderReturnStatus')
            ->with('product')->with('order')
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account_ext.return_exchange.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Service::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('OrderReturnStatus')
            ->firstOrError();
        $res['OrderReturnHistory'] = ServiceHistory::where('OrderReturn_id',$res['info']->id)->with('OrderReturnStatus')->OrderReturnBy('created_at','asc')->get();
        return $this->makeView('laravel-shop-front::account_ext.return_exchange.detail',['res'=>$res]);
    }

    public function service_pre($request){
        $res['orderInfo'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['orderInfo']->id)->with('orderOption')->get();
        return $res;
    }

    public function refund(Request $request){
        $res = $this->service_pre($request);
        $input = $request->all();
        $input['uuid'] = User::uuid();
        $info = Service::create($input);
        $info->addOrderHistory($info,1);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'']]);
    }

    public function return_exchange(Request $request){
        $res = $this->service_pre($request);
        $input = $request->all();
        $info = Service::create($input);
        $info->addOrderHistory($info,1);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'']]);
    }

    public function form(Request $request){
        $res = $this->service_pre($request);
        $service_id = $request->query('id',0);
        $res['info'] = Service::where('id',$service_id)->firstOrNew();

        return $this->makeView('laravel-shop-front::account_ext.service.form',['res'=>$res]);
    }

    public function save(Request $request){
        $res['orderInfo'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['orderInfo']->id)->with('orderOption')->get();
        $input = $request->all();
        $info = Service::create($input);
        $info->addOrderHistory($info,1);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'']]);
    }

}
