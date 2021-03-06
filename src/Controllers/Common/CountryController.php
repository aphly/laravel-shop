<?php

namespace Aphly\LaravelShop\Controllers\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\Zone;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function zone(Request $request){
        $list = (new Zone)->findAllByCountry($request->id);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$list]);
    }
}
