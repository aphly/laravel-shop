<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;

use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\ReturnExchange;
use Aphly\LaravelShop\Models\Sale\ReturnExchangeAction;
use Aphly\LaravelShop\Models\Sale\ReturnExchangeHistory;
use Illuminate\Http\Request;

class ReturnExchangeController extends Controller
{
    public function index()
    {
        $res['list'] = ReturnExchange::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('orderReturnReason')->with('orderReturnAction')->with('orderReturnStatus')
            ->with('product')->with('order')
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account_ext.return_exchange.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = ReturnExchange::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('OrderReturnStatus')
            ->firstOrError();
        $res['OrderReturnHistory'] = ReturnExchangeHistory::where('OrderReturn_id',$res['info']->id)->with('OrderReturnStatus')->OrderReturnBy('created_at','asc')->get();
        return $this->makeView('laravel-shop-front::account_ext.return_exchange.detail',['res'=>$res]);
    }

    public function form(Request $request){
        $res['orderInfo'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['orderInfo']->id)->where('product_id',$request->query('product_id',0))->with('orderOption')->firstOrError();
        $res['returnExchangeAction'] = ReturnExchangeAction::findAll();
        $order_id = $request->query('id',0);
        $res['info'] = ReturnExchange::where('id',$order_id)->firstOrNew();
        return $this->makeView('laravel-shop-front::account_ext.return_exchange.form',['res'=>$res]);

    }

    public function save(Request $request){
        $res['orderInfo'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['orderInfo']->id)->where('product_id',$request->query('product_id',0))->with('orderOption')->firstOrError();
        $input = $request->all();
        $input['email'] = User::initId();
        $input['product_name'] = $res['orderProduct']->name;
        $info = ReturnExchange::create($input);
        $info->addOrderHistory($info,1);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'']]);
    }

}
