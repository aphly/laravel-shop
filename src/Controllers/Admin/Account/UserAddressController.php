<?php

namespace Aphly\LaravelShop\Controllers\Admin\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Account\UserAddress;
use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\LaravelShop\Models\Setting\Zone;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public $index_url='/shop_admin/user_address/index';

    private $currArr = ['name'=>'地址','key'=>'user_address'];

    public function index(Request $request)
    {
        $res['search']['uuid'] = $request->query('uuid','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = UserAddress::when($res['search']['uuid'],
            function($query,$search) {
                if($search['uuid']!==''){
                    $query->where('uuid', $search['uuid']);
                }
            })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.account.user_address.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = UserAddress::where('id',$request->query('id',0))->firstOrNew();
        $res['country'] = (new Country)->findAll();
        //$country_keys = array_keys($res['country']);
        if($res['info']->id){
            $res['zone'] = (new Zone)->findAllByCountry($res['info']->country_id);
        }else{
            $res['zone'] = [];
        }
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.account.user_address.form',['res'=>$res]);
    }

    public function save(Request $request){
        UserAddress::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            UserAddress::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
