<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Shipping;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FreeController extends Controller
{
    public function install() {
        $this->uninstall();

        $data=[];
        $data[] =['code' => 'shipping_free','key'=>'name','value'=>'free'];
        $data[] =['code' => 'shipping_free','key'=>'cost','value'=>'0'];
        $data[] =['code' => 'shipping_free','key'=>'status','value'=>'1'];
        $data[] =['code' => 'shipping_free','key'=>'sort','value'=>'1'];
        $data[] =['code' => 'shipping_free','key'=>'free','value'=>'0'];
        $data[] =['code' => 'shipping_free','key'=>'geo_group_id','value'=>'0'];
        $data[] =['code' => 'shipping_free','key'=>'desc','value'=>'free'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'shipping','code'=>'free'];
        DB::table('shop_extension')->insert($data);
    }

    public function uninstall() {
        DB::table('shop_setting')->where(['code' => 'shipping_free'])->delete();;
        DB::table('shop_extension')->where(['type' => 'shipping','code'=>'free'])->delete();
    }


}
