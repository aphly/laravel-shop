<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public $index_url='/shop_admin/information/index';

    public function index(Request $request)
    {
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Information::orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.catalog.information.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['information'] = Information::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-shop::admin.catalog.information.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        Information::updateOrCreate(['id'=>$id],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Information::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
