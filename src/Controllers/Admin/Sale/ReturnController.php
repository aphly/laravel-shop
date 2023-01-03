<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Sale\OrderReturn;
use Aphly\LaravelShop\Models\Sale\OrderReturnHistory;
use Aphly\LaravelShop\Models\Sale\OrderReturnStatus;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public $index_url='/shop_admin/return/index';

    public function index(Request $request)
    {
        $res['search']['id'] = $id = $request->query('id',false);
        $res['search']['email'] = $email = $request->query('email',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = OrderReturn::when($id,
                function($query,$id) {
                    return $query->where('id', $id);
                })->when($email,
                function($query,$email) {
                    return $query->where('email', $email);
                })
            ->with('OrderReturnStatus')->OrderReturnBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.sale.return.index',['res'=>$res]);
    }

    public function view(Request $request)
    {
        $res['info'] = OrderReturn::where(['id'=>$request->query('id',0)])->with('orderReturnStatus')->firstOrError();
        $res['OrderReturnHistory'] = OrderReturnHistory::where('order_return_id',$res['info']->id)->with('orderReturnStatus')->OrderReturnBy('created_at','asc')->get();
        $res['OrderReturnStatus'] = OrderReturnStatus::get();
        return $this->makeView('laravel-shop::admin.sale.return.view',['res'=>$res]);
    }

    public function historySave(Request $request)
    {
        $input = $request->all();
        $res['info'] = OrderReturn::where(['id'=>$request->input('OrderReturn_id',0)])->firstOrError();
        if($request->input('override',0)){
            OrderReturnHistory::where(['OrderReturn_id'=>$res['info']->id,'OrderReturn_status_id'=>$input['OrderReturn_status_id']])->delete();
        }
        $res['info']->addOrderReturnHistory($res['info'], $input['OrderReturn_status_id'],$input['comment']);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/return/view?id='.$res['info']->id]]);
    }

    public function form(Request $request)
    {
        $OrderReturn_id = $request->query('id',0);
        $res['OrderReturn'] = OrderReturn::where('id',$OrderReturn_id)->firstOrNew();
        return $this->makeView('laravel-shop::admin.sale.return.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['date_add'] = $input['date_add']??time();
        $input['date_start'] = $input['date_start']?strtotime($input['date_start']):0;
        $input['date_end'] = $input['date_end']?strtotime($input['date_end']):0;
        OrderReturn::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            OrderReturn::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }



}
