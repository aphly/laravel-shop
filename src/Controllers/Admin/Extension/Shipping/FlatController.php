<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Shipping;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlatController extends Controller
{
    public function install() {
        $this->uninstall();
        $data=[];
        $data[] =['code' => 'shipping_flat','key'=>'cost','value'=>'5'];
        $data[] =['code' => 'shipping_flat','key'=>'status','value'=>'1'];
        $data[] =['code' => 'shipping_flat','key'=>'sort','value'=>'1'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'shipping','code'=>'flat'];
        DB::table('shop_extension')->insert($data);
    }

    public function uninstall() {
        DB::table('shop_setting')->where(['code' => 'shipping_flat'])->delete();;
        DB::table('shop_extension')->where(['type' => 'shipping','code'=>'flat'])->delete();
    }

}
