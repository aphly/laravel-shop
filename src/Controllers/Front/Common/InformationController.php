<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\ContactUs;
use Aphly\LaravelShop\Models\Common\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{

    function detail(Request $request){
        if($request->isMethod('post')) {
            $input = $request->all();
            $input['uuid'] = User::uuid();
            ContactUs::create($input);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            $res['info'] = Information::where('id',$request->id)->where('status',1)->firstOr404();
            $res['info']->content = str_replace('HOSTNAME',config('common.hostname'),$res['info']->content);
            $res['info']->content = str_replace('HOSTEMAIL',config('common.email'),$res['info']->content);
            $res['title'] = $res['info']->title;
            return $this->makeView('laravel-shop-front::common.information.detail',['res'=>$res]);
        }
    }

}
