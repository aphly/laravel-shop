<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Payment;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{

    public function install() {
        $this->uninstall();
        $data=[];
        $data[] =['code' => 'payment_paypal','key'=>'name','value'=>'paypal'];
        $data[] =['code' => 'payment_paypal','key'=>'min_total','value'=>'0.01'];
        $data[] =['code' => 'payment_paypal','key'=>'status','value'=>'1'];
        $data[] =['code' => 'payment_paypal','key'=>'sort','value'=>'1'];
        $data[] =['code' => 'payment_paypal','key'=>'geo_group_id','value'=>'0'];
        $data[] =['code' => 'payment_paypal','key'=>'order_status','value'=>'8'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'payment','code'=>'paypal'];
        DB::table('shop_extension')->insert($data);
    }

    public function uninstall() {
        DB::table('shop_setting')->where(['code' => 'payment_paypal'])->delete();
        DB::table('shop_extension')->where(['type' => 'payment','code'=>'paypal'])->delete();

    }


}
