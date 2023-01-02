<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Catalog\Review;
use Aphly\LaravelShop\Models\Catalog\ReviewImage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $res['list'] = Review::where(['uuid'=>User::uuid()])->with('product')->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account_ext.review_index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Review::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->with('product')->firstOrError();
        $res['reviewImage'] = ReviewImage::where('review_id',$res['info']->id)->get();
        foreach ($res['reviewImage'] as $val){
            $val->image_src = ProductImage::render($val->image);
        }
        return $this->makeView('laravel-shop-front::account_ext.review_detail',['res'=>$res]);
    }

}