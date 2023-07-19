<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelPayment\Models\Payment;
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

    private $currArr = ['name'=>'售后','key'=>'service'];

    public function index(Request $request)
    {
        $res['search']['id'] = $request->query('id','');
        $res['search']['order_id'] = $request->query('order_id','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Service::when($res['search']['id'],
                function($query,$search) {
                    if($search['id']!==''){
                        $query->where('id', $search['id']);
                    }
                    if($search['order_id']!==''){
                        $query->where('order_id', $search['order_id']);
                    }
                })
            ->where('delete_at',0)
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.sale.service.index',['res'=>$res]);
    }

    public function view(Request $request)
    {
        $res['info'] = Service::where(['id'=>$request->query('id',0)])->with('order')->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['info']->order->id)->with('orderOption')->get();
        $res['serviceHistory'] = ServiceHistory::where('service_id',$res['info']->id)->orderBy('created_at','asc')->get();
        $res['serviceProduct'] = ServiceProduct::where('service_id',$res['info']->id)->with('orderProduct')->get();
        $res['shipping_method'] = Shipping::get();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'详情','href'=>'/shop_admin/'.$this->currArr['key'].'/view?id='.$res['info']->id]
        ]);
        return $this->makeView('laravel-shop::admin.sale.service.view',['res'=>$res]);
    }

    public function historySave(Request $request)
    {
        $input = $request->all();
        $res['info'] = Service::where(['id'=>$request->input('service_id',0)])->with('order')->firstOrError();
        $res['info']->addServiceHistory($res['info'], $input['service_status_id'],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/service/view?id='.$res['info']->id]]);
    }

    public function form(Request $request)
    {
        $res['refund'] = Service::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['refund']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['refund']->id?'/form?id='.$res['refund']->id:'/form')]
        ]);
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
