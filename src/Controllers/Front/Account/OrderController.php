<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Sale\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $res['list'] = Order::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('product')->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account.order',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->id])->firstOrError();
        return $this->makeView('laravel-shop-front::account.order_detail',['res'=>$res]);
    }

    public function remove(Request $request){
        $info = Order::where(['uuid'=>User::uuid(),'id'=>$request->id])->first();
        if(!empty($info)){
            $info->delete_at = time();
            $info->save();
        }
        throw new ApiException(['code'=>0,'msg'=>'remove_success']);
    }

}
