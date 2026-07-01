<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Seccode;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('post')) {
            if(!((new Seccode())->check($request->input('code')))){
                throw new ApiException(['code'=>11000,'msg'=>'Incorrect Code','data'=>['code'=>['Incorrect Code']]]);
            }
            $input = $request->all();
            $input['uid'] = CommonUser::uid();
            if(empty($input['content']) || str_contains($input['content'], 'http') || str_contains($input['content'], 'href')){
                throw new ApiException(['code'=>1,'msg'=>'The content contains sensitive words']);
            }
            ContactUs::create($input);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }

    }



}
