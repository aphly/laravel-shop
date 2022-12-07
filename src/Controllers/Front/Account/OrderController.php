<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\LaravelCommon\Models\User;
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
        return $this->makeView('laravel-shop-front::account_ext.order_index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->with('orderStatus')
            ->with(['orderTotal'=>function ($query) {
                    $query->orderBy('sort', 'asc');
                }])->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['info']->id)->with('orderOption')->get();
        $res['orderHistory'] = OrderHistory::where('order_id',$res['info']->id)->with('orderStatus')->get();
        return $this->makeView('laravel-shop-front::account_ext.order_detail',['res'=>$res]);
    }

}
