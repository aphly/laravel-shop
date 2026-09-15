<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Sale\Salesperson;
use Illuminate\Http\Request;

class SalespersonController extends Controller
{
    public $index_url='/shop_admin/salesperson/index';

    public $currArr = ['name'=>'销售员','key'=>'salesperson','admin'=>'shop_admin'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Salesperson::when($res['search'],
            function($query,$search) {
                if($search['name']!==''){
                    $query->where('name', 'like', '%'.$search['name'].'%');
                }
            })
            ->orderBy('id','desc')
            ->Paginate(config('base.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.sale.salesperson.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $salesperson_id = $request->query('id',0);
        $res['salesperson'] = Salesperson::where('id',$salesperson_id)->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['salesperson']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['salesperson']->id?'/form?id='.$res['salesperson']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.sale.salesperson.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        Salesperson::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Salesperson::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }



}
