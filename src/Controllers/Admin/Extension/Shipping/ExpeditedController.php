<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Shipping;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExpeditedController extends Controller
{
    public function install() {
        $this->uninstall();
        $data=[];
        $data[] =['code' => 'shipping_expedited','key'=>'name','value'=>'Expedited Shipping'];
        $data[] =['code' => 'shipping_expedited','key'=>'cost','value'=>'24.95'];
        $data[] =['code' => 'shipping_expedited','key'=>'status','value'=>'1'];
        $data[] =['code' => 'shipping_expedited','key'=>'sort','value'=>'1'];
        $data[] =['code' => 'shipping_expedited','key'=>'free','value'=>'249'];
        $data[] =['code' => 'shipping_expedited','key'=>'geo_group_id','value'=>'0'];
        $data[] =['code' => 'shipping_expedited','key'=>'desc','value'=>'4-8 business days after shipment, Free with orders over $249.00'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'shipping','code'=>'expedited'];
        DB::table('shop_extension')->insert($data);
    }

    public function uninstall() {
        DB::table('shop_setting')->where(['code' => 'shipping_expedited'])->delete();;
        DB::table('shop_extension')->where(['type' => 'shipping','code'=>'expedited'])->delete();
    }

}
