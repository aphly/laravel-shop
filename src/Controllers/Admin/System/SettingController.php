<?php

namespace Aphly\LaravelShop\Controllers\Admin\System;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\System\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $index_url='/shop_admin/setting/index';

    private $currArr = ['name'=>'设置','key'=>'setting'];

    public function index(Request $request)
    {
        $res['setting'] = Setting::get()->keyBy('key')->toArray();
        $res['currency'] = (new Currency)->findAll();
        $res['country'] = (new Country)->findAll();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url]
        ]);
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
