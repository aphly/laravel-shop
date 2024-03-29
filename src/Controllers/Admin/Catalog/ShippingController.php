<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public $index_url='/shop_admin/shipping/index';

    private $currArr = ['name'=>'物流','key'=>'shipping'];

    public function index(Request $request)
    {
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Shipping::orderBy('id','desc')->with('geoGroup')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.catalog.shipping.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Shipping::where('id',$request->query('id',0))->firstOrNew();
        $res['geoGroup'] = GeoGroup::where('status',1)->get()->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.catalog.shipping.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        if($input['default']==1){
            Shipping::whereRaw('1')->update(['default'=>2]);
        }
        $input['cost'] = floatval($input['cost']);
        $input['free_cost'] = floatval($input['free_cost']);
        Shipping::updateOrCreate(['id'=>$id],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Shipping::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
