<?php

namespace Aphly\LaravelShop\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public $index_url='/shop-admin/product/index';

    public function index(Request $request)
    {
        $res['title']='我的';
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Product::when($name,
            function($query,$name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->when($status,
                function($query,$status) {
                    return $query->where('status', '=', $status);
                })
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.product.index',['res'=>$res]);
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $post = $request->all();
            $product = Product::create($post);
            if($product->id){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title']='我的';
            return $this->makeView('laravel-shop::admin.product.add',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        if($request->isMethod('post')) {
            $manager = Product::find($request->id);
            $post = $request->all();
            if(!empty($post['password'])){
                $post['password'] = Hash::make($post['password']);
            }else{
                unset($post['password']);
            }
            if($manager->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['title']='我的';
            $res['info'] = Product::find($request->id);
            return $this->makeView('laravel-shop::admin.product.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Product::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
