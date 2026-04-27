<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('post')) {
            $input = $request->all();
            $input['uid'] = CommonUser::uid();
            ContactUs::create($input);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }

    }



}
