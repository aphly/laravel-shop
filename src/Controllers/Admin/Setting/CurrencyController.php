<?php

namespace Aphly\LaravelShop\Controllers\Admin\Setting;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelShop\Models\Setting\Currency;
use DateTimeZone;
use Illuminate\Http\Request;
use Aphly\LaravelShop\Controllers\Admin\Controller;

class CurrencyController extends Controller
{
    public $index_url='/shop_admin/currency/index';

    private $currArr = ['name'=>'货币','key'=>'currency'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Currency::when($res['search'],
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
        return $this->makeView('laravel-shop::admin.setting.currency.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Currency::where('id',$request->query('id',0))->firstOrNew();
        $res['timezone_identifiers'] = DateTimeZone::listIdentifiers();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.setting.currency.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        if($input['default']==1){
            Currency::whereRaw('1')->update(['default'=>2]);
        }
        Currency::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Currency::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
