<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Models\Setting\Currency;
use Illuminate\Http\Request;
use Aphly\LaravelShop\Controllers\Front\Controller;

class CurrencyController extends Controller
{

    public function ajax(Request $request)
    {
        $res['info'] = Currency::where('id',$request->id)->firstOrError();
        if($res['info']->status==1){
            session(['currency_id'=>$res['info']->id]);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }
    }


}
