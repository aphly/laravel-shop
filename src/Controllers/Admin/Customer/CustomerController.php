<?php

namespace Aphly\LaravelShop\Controllers\Admin\Customer;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Account\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public $index_url='/shop_admin/customer/index';

    public function index(Request $request)
    {
        $res['filter']['email'] = $email = $request->query('email',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Customer::leftjoin('')
            ->when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.customer.group.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['customer'] = Customer::where('uuid',$request->query('uuid',0))->firstOrNew();
        return $this->makeView('laravel-shop::admin.customer.group.form',['res'=>$res]);
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
