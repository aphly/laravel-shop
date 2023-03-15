<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\UploadFile;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\Review;
use Aphly\LaravelShop\Models\Catalog\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public $index_url='/shop_admin/review/index';
    public function index(Request $request)
    {
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Review::orderBy('id','desc')
            ->with('product')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $review_ids = $res['reviewImage'] = [];
        foreach ($res['list'] as $val){
            $review_ids[] = $val->id;
        }
        $reviewImage = ReviewImage::whereIn('review_id',$review_ids)->get();
        foreach ($reviewImage as $val){
            $res['reviewImage'][$val->review_id][] = UploadFile::getPath($val->image);
        }
        return $this->makeView('laravel-shop::admin.catalog.review.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['review'] = Review::where('id',$request->query('id',0))->firstOrNew();
        if($res['review']->id){
            $res['product'] = Product::where('id',$res['review']->product_id)->select('name','id')->first();
            $res['reviewImage'] = ReviewImage::where('review_id',$res['review']->id)->get();
            foreach ($res['reviewImage'] as $val){
                $val->image_src = UploadFile::getPath($val->image);
            }
        }else{
            $res['product'] = $res['reviewImage'] = [];
        }
        return $this->makeView('laravel-shop::admin.catalog.review.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        Review::updateOrCreate(['id'=>$id],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Review::whereIn('id',$post)->delete();
            $reviewImageObj = ReviewImage::whereIn('review_id',$post);
            $reviewImage = $reviewImageObj->get();
            foreach ($reviewImage as $val){
                Storage::delete($val->image);
            }
            $reviewImageObj->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
