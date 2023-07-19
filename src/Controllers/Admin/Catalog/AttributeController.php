<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Attribute;
use Aphly\LaravelShop\Models\Catalog\AttributeGroup;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public $index_url='/shop_admin/attribute/index';

    private $currArr = ['name'=>'属性','key'=>'attribute'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = AttributeGroup::when($res['search'],
                function($query,$search) {
                    if($search['name']!==''){
                        $query->where('name', 'like', '%'.$search['name'].'%');
                    }
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.catalog.attribute.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['attribute'] = [];
        $res['attributeGroup'] = AttributeGroup::where('id',$request->query('id',0))->firstOrNew();
        if($res['attributeGroup']->id){
            $res['attribute'] = Attribute::where('attribute_group_id',$res['attributeGroup']->id)->orderBy('sort','desc')->get();
        }
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['attributeGroup']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['attributeGroup']->id?'/form?id='.$res['attributeGroup']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.catalog.attribute.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $attributeGroup = AttributeGroup::updateOrCreate(['id'=>$id],$request->all());
        if($attributeGroup->id){
            $val_arr = $request->input('value',[]);
            $attribute = Attribute::where('attribute_group_id',$attributeGroup->id)->pluck('id')->toArray();
            $val_arr_keys = array_keys($val_arr);
            $update_arr = $delete_arr = [];
            foreach ($attribute as $val){
                if(!in_array($val,$val_arr_keys)){
                    $delete_arr[] = $val;
                }
            }
            Attribute::whereIn('id',$delete_arr)->delete();
            foreach ($val_arr as $key=>$val){
                foreach ($val as $k=>$v){
                    $update_arr[$key][$k]=$v;
                }
                $update_arr[$key]['id'] = intval($key);
                $update_arr[$key]['attribute_group_id'] = $attributeGroup->id;
            }
            Attribute::upsert($update_arr,['id'],['attribute_group_id','name','sort']);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            AttributeGroup::whereIn('id',$post)->delete();
            Attribute::whereIn('attribute_group_id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function ajax(Request $request){
        $name = $request->query('name',false);
        $list = AttributeGroup::leftJoin('shop_attribute','shop_attribute_group.id','=','shop_attribute.attribute_group_id')
            ->when($name,function($query,$name) {
                return $query->where('shop_attribute.name', 'like', '%'.$name.'%');
            })
            ->select('shop_attribute.*','shop_attribute_group.name as groupname')
            ->where('shop_attribute_group.status',1)->get()->toArray();
        $attr_res = [];
        foreach ($list as $val){
            $attr_res[$val['attribute_group_id']]['groupname'] = $val['groupname'];
            $attr_res[$val['attribute_group_id']]['child'][$val['id']] = $val['name'];
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$attr_res]]);
    }

}
