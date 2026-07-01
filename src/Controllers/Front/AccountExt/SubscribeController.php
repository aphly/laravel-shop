<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function index(Request $request)
    {
        $res['email'] = CommonUser::getEmail();
        $res['info'] = Subscribe::where(['email'=>$res['email']])->first();
        if($request->isMethod('post')){
            $res['email'] = $res['email']?:$request->input('email','');
            if(!$res['email']){
                throw new ApiException(['code'=>1,'msg'=>'email error']);
            }
            $status = $request->input('status',0);
            $status = $status?1:0;
            if(!empty($res['info'])){
                $res['info']->status = $status;
                $res['info']->save();
            }else{
                Subscribe::create(['email'=>$res['email'],'status'=>$status]);
            }
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            $res['title'] = 'Subscribe';
            return $this->makeView('laravel-shop::front.account_ext.subscribe.index',['res'=>$res]);
        }
    }

    public function ajax(Request $request)
    {
        $input = $request->all();
        if(filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
            $res['info'] = Subscribe::where('email',$input['email'])->first();
            if(empty($res['info'])){
                Subscribe::create($input);
            }
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'Email Error']);
        }
    }


}
