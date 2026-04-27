<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Models\CommonUploadFile;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Review;
use Aphly\LaravelShop\Models\Account\ReviewImage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $res['list'] = Review::where(['uid'=>CommonUser::uid()])->with('product')->with('img')->orderBy('created_at','desc')
            ->Paginate(config('base.perPage'))->withQueryString();
        $res['title'] = 'Review';
        $res['list']->transform(function ($item) {
            $item->img->transform(function ($i) {
                $i->image_src = CommonUploadFile::getPath($i->image,$i->disk);
                return $i;
            });
            $item->product->image_src = CommonUploadFile::getPath($item->product->image,$item->product->disk);
            return $item;
        });
        return $this->makeView('laravel-shop::front.account_ext.review.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Review::where(['uid'=>CommonUser::uid(),'id'=>$request->query('id',0)])->with('product')->firstOrError();
        $res['title'] = 'Review Detail';
        $res['reviewImage'] = ReviewImage::where('review_id',$res['info']->id)->get();
        foreach ($res['reviewImage'] as $val){
            $val->image_src = CommonUploadFile::getPath($val->image,$val->disk);
        }
        return $this->makeView('laravel-shop::front.account_ext.review.detail',['res'=>$res]);
    }

}
