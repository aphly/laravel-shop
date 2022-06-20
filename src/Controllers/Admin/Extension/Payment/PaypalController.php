<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Payment;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{

    public function install() {
        $this->uninstall();
        $data=[];
        $data[] =['code' => 'payment_paypal','key'=>'total','value'=>'0.01'];
        $data[] =['code' => 'payment_paypal','key'=>'status','value'=>'1'];
        $data[] =['code' => 'payment_paypal','key'=>'sort','value'=>'1'];
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
