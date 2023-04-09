<?php

namespace Aphly\LaravelShop\Controllers\Admin\System;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\System\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $index_url='/shop_admin/setting/index';

    public function index(Request $request)
    {
        $res['setting'] = Setting::get()->keyBy('key')->toArray();
        $res['currency'] = (new Currency)->findAll();
        $res['country'] = (new Country)->findAll();
        return $this->makeView('laravel-shop::admin.system.setting.index',['res'=>$res]);
    }

    public function save(Request $request){
        $setting = $request->input('setting',[]);
        $update = [];
        foreach ($setting as $key=>$val){
            $update[] = ['key'=>$key,'value'=>$val];
        }
        Setting::upsert($update,['key'],['value']);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

}
