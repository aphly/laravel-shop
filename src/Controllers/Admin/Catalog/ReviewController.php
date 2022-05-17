<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Product\Product;
use Aphly\LaravelShop\Models\Product\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public $index_url='/shop_admin/review/index';

    public function index(Request $request)
    {
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Review::orderBy('id','desc')
            ->with('product')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.catalog.review.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['review'] = Review::where('id',$request->query('id',0))->firstOrNew();
        if($res['review']->id){
            $res['product'] = Product::where('id',$res['review']->product_id)->select('name','id')->first();
        }else{
            $res['product'] = [];
        }
        return $this->makeView('laravel-shop::admin.catalog.review.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $input['date_add'] = strtotime($input['date_add']);
        Review::updateOrCreate(['id'=>$id],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Review::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
