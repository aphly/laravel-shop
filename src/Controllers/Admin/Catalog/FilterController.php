<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Filter;
use Aphly\LaravelShop\Models\Common\FilterGroup;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public $index_url='/shop-admin/filter/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = FilterGroup::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->when($status,
                function($query,$status) {
                    return $query->where('status', $status);
                })
            ->orderBy('sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        //$res['fast_save'] = Category::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-shop::admin.catalog.filter.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['filterGroup'] = FilterGroup::where('id',$request->query('id',0))->firstOrNew();
        if($res['filterGroup']->id){
            $res['filter'] = Filter::where('filter_group_id',$res['filterGroup']->id)->first();
        }
        return $this->makeView('laravel-shop::admin.catalog.filter.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $filterGroup = FilterGroup::updateOrCreate(['id'=>$id],$request->all());
        if($filterGroup->id){
            $arr = $request->input('value');
            $update_arr = [];
            foreach ($arr as $key=>$val){
                if(intval($key)){
                    $update_arr[$key] = $val;
                }
            }
            Filter::updateOrCreate(['filter_group_id'=>$filterGroup->id],$request->all());
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Filter::where('pid',$post)->get();
            if($data->isEmpty()){
                Filter::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的菜单','data'=>['redirect'=>$redirect]]);
            }
        }
    }

}
