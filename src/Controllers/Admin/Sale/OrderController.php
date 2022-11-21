<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $index_url='/shop_admin/order/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Order::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.sale.order.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $order_id = $request->query('id',0);
        $res['order'] = Order::where('id',$order_id)->firstOrNew();
        return $this->makeView('laravel-shop::admin.sale.order.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['date_add'] = $input['date_add']??time();
        $input['date_start'] = $input['date_start']?strtotime($input['date_start']):0;
        $input['date_end'] = $input['date_end']?strtotime($input['date_end']):0;
        $order = Order::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Order::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function history(Request $request)
    {
        $res['list'] = OrderHistory::where('order_id',$request->query('id',0))->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.sale.order.history',['res'=>$res]);
    }

}
