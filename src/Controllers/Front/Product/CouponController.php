<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function ajax(Request $request)
    {
        $res['info'] = (new Coupon)->getCoupon($request->code);
        if(!empty($res['info'])){
            session(['coupon'=>$res['info']['code']]);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            session()->forget('coupon');
            throw new ApiException(['code'=>1,'msg'=>'fail']);
        }
    }


}
