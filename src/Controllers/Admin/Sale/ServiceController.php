<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\Service;
use Aphly\LaravelShop\Models\Sale\ServiceHistory;
use Aphly\LaravelShop\Models\Sale\ServiceProduct;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public $index_url='/shop_admin/service/index';

    public function index(Request $request)
    {
        $res['search']['id'] = $id = $request->query('id',false);
        $res['search']['order_id'] = $order_id = $request->query('order_id',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Service::when($id,
                function($query,$id) {
                    return $query->where('id', $id);
                })->when($order_id,
                function($query,$order_id) {
                    return $query->where('order_id', $order_id);
                })
            ->where('delete_at',0)
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.sale.service.index',['res'=>$res]);
    }

    public function view(Request $request)
    {
        $res['info'] = Service::where(['id'=>$request->query('id',0)])->with('order')->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['info']->order->id)->with('orderOption')->get();
        $res['serviceHistory'] = ServiceHistory::where('service_id',$res['info']->id)->orderBy('created_at','desc')->get();
        $res['serviceProduct'] = ServiceProduct::where('service_id',$res['info']->id)->with('orderProduct')->get();
        $res['shipping_method'] = Shipping::get();
        return $this->makeView('laravel-shop::admin.sale.service.view',['res'=>$res]);
    }

    public function historySave(Request $request)
    {
        $input = $request->all();
        $res['info'] = Service::where(['id'=>$request->input('service_id',0)])->firstOrError();
        $res['orderInfo'] = Order::where('id',$res['info']->order_id)->firstOrError();
        $res['info']->addServiceHistory($res['info'], $input['service_status_id'],$input);
        if($input['service_status_id']==2){
            $orderInput['override'] = 1;
            $res['orderInfo']->addOrderHistory($res['orderInfo'],7,$orderInput);
        }else if($input['service_status_id']==3){
            $orderInput['override'] = 1;
            $res['orderInfo']->addOrderHistory($res['orderInfo'],3,$orderInput);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/service/view?id='.$res['info']->id]]);
    }

    public function form(Request $request)
    {
        $refund_id = $request->query('id',0);
        $res['refund'] = Service::where('id',$refund_id)->firstOrNew();
        return $this->makeView('laravel-shop::admin.sale.service.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['date_add'] = $input['date_add']??time();
        $input['date_start'] = $input['date_start']?strtotime($input['date_start']):0;
        $input['date_end'] = $input['date_end']?strtotime($input['date_end']):0;
        Service::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Service::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }



}
