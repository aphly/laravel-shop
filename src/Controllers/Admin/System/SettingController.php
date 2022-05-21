<?php

namespace Aphly\LaravelShop\Controllers\Admin\System;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Country;
use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $index_url='/shop_admin/setting/index';

    public function index(Request $request)
    {
        $res['config'] = Setting::where('code','config')->get()->keyBy('key')->toArray();
        $res['currency'] = (new Currency)->findAll();
        $res['country'] = (new Country)->findAll();
        return $this->makeView('laravel-shop::admin.system.setting.index',['res'=>$res]);
    }

    public function save(Request $request){
        $config = $request->input('config',[]);
        $update = [];
        foreach ($config as $key=>$val){
            $update[] = ['code'=>'config','key'=>$key,'value'=>$val];
        }
        Setting::upsert($update,['code','key'],['value']);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

}
