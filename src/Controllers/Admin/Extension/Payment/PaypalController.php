<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Payment;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Customer\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{
    public function install() {
        $data=[];
        $data[] =['code' => 'payment','key'=>'paypal_cost','value'=>'0'];
        $data[] =['code' => 'payment','key'=>'paypal_status','value'=>'1'];
        $data[] =['code' => 'payment','key'=>'paypal_sort','value'=>'1'];
        return DB::table('shop_setting')->insert($data);
    }

    public function uninstall() {
        $data=[];
        $data[] =['code' => 'payment','key'=>'paypal_cost','value'=>'0'];
        $data[] =['code' => 'payment','key'=>'paypal_status','value'=>'1'];
        $data[] =['code' => 'payment','key'=>'paypal_sort','value'=>'1'];
        return DB::table('shop_setting')->insert($data);
    }

}
