<?php

namespace Aphly\LaravelShop\Controllers\Admin\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelShop\Models\Common\InformationCategory;
use Illuminate\Http\Request;
use Aphly\LaravelShop\Controllers\Admin\Controller;

class InformationCategoryController extends Controller
{
    public $index_url='/shop_admin/information_category/index';

    public $currArr = ['name'=>'信息分类','key'=>'information_category','admin'=>'shop_admin'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = InformationCategory::when($res['search'],
            function($query,$search) {
                if($search['name']!==''){
                    $query->where('name', 'like', '%'.$search['name'].'%');
                }
            })
            ->Paginate(config('base.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.common.information_category.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = InformationCategory::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.common.information_category.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $info = InformationCategory::where('id',$id)->first();
        if(!empty($info)){
            $info->update($input);
        }else{
            InformationCategory::create($input);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            InformationCategory::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }


}
