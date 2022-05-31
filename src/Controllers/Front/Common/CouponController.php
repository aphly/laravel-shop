<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CouponController extends Controller
{

    public function ajax(Request $request)
    {
        $res['info'] = Coupon::where('code',$request->code)->first();
        if(!empty($res['info']) && $res['info']->status==1){
            Cookie::queue('coupon',$res['info']->code);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'fail']);
        }
    }


}
