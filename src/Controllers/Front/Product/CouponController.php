<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CouponController extends Controller
{

    public function ajax(Request $request)
    {
        $res['info'] = (new Coupon)->getCoupon($request->code);
        if(!empty($res['info'])){
            Cookie::queue('coupon',$res['info']['code']);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            Cookie::queue('coupon', null , -1);
            throw new ApiException(['code'=>1,'msg'=>'fail']);
        }
    }


}
