<?php

namespace Aphly\LaravelShop\Controllers\Admin\System;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\Group;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Common\ExtensionParams;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $index_url='/shop_admin/setting/index';

    public function index(Request $request)
    {
        $res['config'] = ExtensionParams::where('code','config')->get()->keyBy('key')->toArray();
        $res['currency'] = (new Currency)->findAll();
        $res['country'] = (new Country)->findAll();
        $res['group'] = (new Group)->findAll();
        return $this->makeView('laravel-shop::admin.system.setting.index',['res'=>$res]);
    }

    public function save(Request $request){
        $config = $request->input('config',[]);
        $update = [];
        foreach ($config as $key=>$val){
            $update[] = ['code'=>'config','key'=>$key,'value'=>$val];
        }
        ExtensionParams::upsert($update,['code','key'],['value']);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

}
