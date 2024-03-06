<?php

namespace Aphly\LaravelShop\Controllers\Admin\Setting;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\LaravelShop\Models\Setting\Currency;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Setting\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public $index_url='/shop_admin/config/index';

    private $currArr = ['name'=>'设置','key'=>'setting'];

    public function index(Request $request)
    {
        $res['setting'] = Config::get()->keyBy('key')->toArray();
        $res['currency'] = (new Currency)->findAll();
        $res['country'] = (new Country)->findAll();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.setting.config.index',['res'=>$res]);
    }

    public function save(Request $request){
        $setting = $request->input('setting',[]);
        $update = [];
        foreach ($setting as $key=>$val){
            $update[] = ['key'=>$key,'value'=>$val];
        }
        Config::upsert($update,['key'],['value']);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

}
