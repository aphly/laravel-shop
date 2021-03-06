<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Payment;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CodController extends Controller
{

    public function install() {
        $this->uninstall();
        $data=[];
        $data[] =['code' => 'payment_cod','key'=>'name','value'=>'cod'];
        $data[] =['code' => 'payment_cod','key'=>'min_total','value'=>'0.01'];
        $data[] =['code' => 'payment_cod','key'=>'status','value'=>'1'];
        $data[] =['code' => 'payment_cod','key'=>'sort','value'=>'1'];
        $data[] =['code' => 'payment_cod','key'=>'geo_group_id','value'=>'0'];
        $data[] =['code' => 'payment_cod','key'=>'order_status','value'=>'8'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'payment','code'=>'cod'];
        DB::table('shop_extension')->insert($data);
    }

    public function uninstall() {
        DB::table('shop_setting')->where(['code' => 'payment_cod'])->delete();
        DB::table('shop_extension')->where(['type' => 'payment','code'=>'cod'])->delete();
    }


}
