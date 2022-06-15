<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Extension;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $cname = 'payment';

    public function index() {
        $files = glob(dirname(__DIR__) . '/'.ucwords($this->cname).'/*.php');
        $shopSetting = Setting::findAll();
        $extension = Extension::findAll();
        $res['list'] = [];
        $res['cname'] = $this->cname;
        if ($files) {
            foreach ($files as $file) {
                $filename = basename($file, '.php');
                $name = strtolower(str_replace('Controller','',$filename));
                $res['list'][] = [
                    'name'       => $name,
                    'status'     => $shopSetting[$this->cname.'_'.$name]['status']??2,
                    'sort'       => $shopSetting[$this->cname.'_'.$name]['sort']??0 ,
                    'install'    => '/shop_admin/extension/'.$this->cname.'/install?name='.$filename,
                    'uninstall'  => '/shop_admin/extension/'.$this->cname.'/uninstall?name='.$filename,
                    'installed'  => isset($extension[$this->cname])?in_array($name,$extension[$this->cname]):false,
                    'edit'       => '/shop_admin/extension/'.$this->cname.'/edit?name='.$name,
                ];
            }
        }
        return $this->makeView('laravel-shop::admin.extension.extension.'.$this->cname,['res'=>$res]);
    }

    function install(Request $request){
        $name = $request->query('name');
        $extension = '\Aphly\LaravelShop\Controllers\Admin\Extension\\'.$this->cname.'\\'.$name;
        if(class_exists($extension)) {
            (new $extension)->install();
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/extension/'.$this->cname.'/index']]);
    }

    function uninstall(Request $request){
        $name = $request->query('name');
        $extension = '\Aphly\LaravelShop\Controllers\Admin\Extension\\'.$this->cname.'\\'.$name;
        if(class_exists($extension)) {
            (new $extension)->uninstall();
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/extension/'.$this->cname.'/index']]);
    }

    function edit(Request $request){
        $res['name'] = $request->query('name');
        $res['cname'] = $this->cname;
        if($res['name']){
            if($request->isMethod('post')){
                $update_arr = [];
                $input = $request->input('setting',[]);
                foreach ($input as $key=>$val){
                    $update_arr[] = [
                        'code' => $this->cname.'_'.$res['name'],
                        'key'  => $key,
                        'value' => $val
                    ];
                }
                Setting::upsert($update_arr,['code','key'],['value']);
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/extension/'.$this->cname.'/index']]);
            }else{
                $res['list'] = Setting::where(['code' => $this->cname.'_'.$res['name']])->get()->toArray();
                return $this->makeView('laravel-shop::admin.extension.extension.'.$this->cname.'_edit',['res'=>$res]);
            }
        }
    }

}
