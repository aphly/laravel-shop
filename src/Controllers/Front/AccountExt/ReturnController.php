<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Sale\Refund;
use Aphly\LaravelShop\Models\Sale\RefundHistory;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $res['list'] = Refund::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('orderReturnReason')->with('orderReturnAction')->with('orderReturnStatus')
            ->with('product')->with('order')
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account_ext.return.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Refund::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('OrderReturnStatus')
            ->firstOrError();
        $res['OrderReturnHistory'] = RefundHistory::where('OrderReturn_id',$res['info']->id)->with('OrderReturnStatus')->OrderReturnBy('created_at','asc')->get();
        return $this->makeView('laravel-shop-front::account_ext.return.detail',['res'=>$res]);
    }

    public function form(Request $request){
        if($request->isMethod('post')){

        }else{
            $res['info'] = Refund::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('OrderReturnStatus')->firstOrNew();
            return $this->makeView('laravel-shop-front::account_ext.return.form',['res'=>$res]);
        }
    }

}
