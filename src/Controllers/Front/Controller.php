<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\UserNovelSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelCommon\Controllers\Front\Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $auth = Auth::guard('user');
            Global $novel_setting;
            if($auth->check()){
                $novel_setting = UserNovelSetting::where(['uuid'=>$auth->user()->uuid])->first();
                View::share("novel_setting",$novel_setting);
            }else{
                View::share("novel_setting",[]);
            }
            return $next($request);
        });
        parent::__construct();
    }
}
