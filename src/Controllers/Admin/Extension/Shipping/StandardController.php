<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Shipping;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StandardController extends Controller
{
    public function install() {
        $this->uninstall();
        $data=[];
        $data[] =['code' => 'shipping_standard','key'=>'name','value'=>'Standard Shipping'];
        $data[] =['code' => 'shipping_standard','key'=>'cost','value'=>'5.95'];
        $data[] =['code' => 'shipping_standard','key'=>'status','value'=>'1'];
        $data[] =['code' => 'shipping_standard','key'=>'sort','value'=>'1'];
        $data[] =['code' => 'shipping_standard','key'=>'free','value'=>'69'];
        $data[] =['code' => 'shipping_standard','key'=>'geo_group_id','value'=>'69'];
        $data[] =['code' => 'shipping_standard','key'=>'desc','value'=>'9-20 business days after shipment, Free with orders over $69.00'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'shipping','code'=>'standard'];
        DB::table('shop_extension')->insert($data);
    }

    public function uninstall() {
        DB::table('shop_setting')->where(['code' => 'shipping_standard'])->delete();;
        DB::table('shop_extension')->where(['type' => 'shipping','code'=>'standard'])->delete();
    }

}
