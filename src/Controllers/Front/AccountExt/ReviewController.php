<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Review;
use Aphly\LaravelShop\Models\Catalog\ReviewImage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $res['list'] = Review::where(['uuid'=>User::uuid()])->with('product')->with('img')->orderBy('created_at','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['title'] = 'Review';
        $res['list']->transform(function ($item) {
            $item->img->transform(function ($i) {
                $i->image_src = UploadFile::getPath($i->image,$i->remote);
                return $i;
            });
            $item->product->image_src = UploadFile::getPath($item->product->image,$item->product->remote);
            return $item;
        });
        return $this->makeView('laravel-shop-front::account_ext.review.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Review::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->with('product')->firstOrError();
        $res['title'] = 'Review Detail';
        $res['reviewImage'] = ReviewImage::where('review_id',$res['info']->id)->get();
        foreach ($res['reviewImage'] as $val){
            $val->image_src = UploadFile::getPath($val->image,$val->remote);
        }
        return $this->makeView('laravel-shop-front::account_ext.review.detail',['res'=>$res]);
    }

}
