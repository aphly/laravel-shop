<?php

namespace Aphly\LaravelShop\Controllers\Admin\Customer;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Customer\Address;
use Aphly\LaravelShop\Models\Customer\Customer;
use Aphly\LaravelShop\Models\Customer\Group;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public $index_url='/shop_admin/customer/index';

    public function index(Request $request)
    {
        $res['filter']['uuid'] = $uuid = $request->input('uuid',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Customer::with('user')->with('user_auth')
            ->when($uuid,
                function($query,$uuid) {
                    return $query->where('uuid', 'like', '%'.$uuid.'%');
                })
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.customer.customer.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['customer'] = Customer::where('uuid',$request->query('uuid',0))->firstOrNew();
        $res['customer_group'] = Group::get()->toArray();
        if($res['customer']->uuid){
            $res['customer_addr'] = (new Address)->getAddresses($res['customer']->uuid);
        }else{
            $res['customer_addr'] = [];
        }
        return $this->makeView('laravel-shop::admin.customer.customer.form',['res'=>$res]);
    }

    public function save(Request $request){
        Customer::updateOrCreate(['uuid'=>$request->query('uuid',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Customer::whereIn('uuid',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
