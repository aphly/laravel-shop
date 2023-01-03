<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Sale\OrderReturn;
use Aphly\LaravelShop\Models\Sale\OrderReturnHistory;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $res['list'] = OrderReturn::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('orderReturnReason')->with('orderReturnAction')->with('orderReturnStatus')
            ->with('product')->with('order')
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account_ext.return.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = OrderReturn::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('OrderReturnStatus')
            ->with(['OrderReturnTotal'=>function ($query) {
                    $query->OrderReturnBy('sort', 'asc');
                }])->firstOrError();
        $res['OrderReturnHistory'] = OrderReturnHistory::where('OrderReturn_id',$res['info']->id)->with('OrderReturnStatus')->OrderReturnBy('created_at','asc')->get();
        return $this->makeView('laravel-shop-front::account_ext.return.detail',['res'=>$res]);
    }

}
