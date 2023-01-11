<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Admin\Controller;
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
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.sale.service.index',['res'=>$res]);
    }

    public function view(Request $request)
    {
        $res['info'] = Service::where(['id'=>$request->query('id',0)])->firstOrError();
        $res['serviceHistory'] = ServiceHistory::where('service_id',$res['info']->id)->get();
        $res['serviceProduct'] = ServiceProduct::where('service_id',$res['info']->id)->with('product')->get();
        return $this->makeView('laravel-shop::admin.sale.service.view',['res'=>$res]);
    }

    public function historySave(Request $request)
    {
        $input = $request->all();
        $res['info'] = Service::where(['id'=>$request->input('refund_id',0)])->firstOrError();
        if($request->input('override',0)){
            ServiceHistory::where(['refund_id'=>$res['info']->id,'refund_status_id'=>$input['refund_status_id']])->delete();
        }
        $res['info']->addOrderReturnHistory($res['info'], $input['refund_status_id'],$input['comment']);
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
