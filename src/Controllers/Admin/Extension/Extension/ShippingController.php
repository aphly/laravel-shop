<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Extension;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index() {
        $files = glob(dirname(__DIR__) . '/Shipping/*.php');
        //Extension
        $res['extension'] = [];
        if ($files) {
            foreach ($files as $file) {
                $filename = basename($file, '.php');
                $res['extension'][] = [
                    'name'       => str_replace('Controller','',$filename),
                    'status'     => 1,
                    'sort_order' => 1 ,
                    'install'    => 1,
                    'uninstall'  => 1,
                    'installed'  => 1,
                    'edit'       => 1,
                ];
            }
        }
        dd($res['extension']);
        return $this->makeView('laravel-shop::admin.extension.extension.shipping',['res'=>$res]);
    }

    function ss(){
//        if(class_exists($extension=1)) {
//            (new ($extension)->ss());
//        }
    }


}
