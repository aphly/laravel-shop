<?php

namespace Aphly\LaravelShop\Controllers\Admin\Extension\Shipping;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Customer\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlatController extends Controller
{
    public function install() {
        $data=[];
        $data[] =['code' => 'shipping','key'=>'flat_cost','value'=>'5'];
        $data[] =['code' => 'shipping','key'=>'flat_status','value'=>'1'];
        $data[] =['code' => 'shipping','key'=>'flat_sort','value'=>'1'];
        DB::table('shop_setting')->insert($data);

        $data=[];
        $data[] =['type' => 'shipping','code'=>'flat'];
        DB::table('shop_extension')->insert($data);
        return 'ok';
    }

    public function uninstall() {
        $data=[];
        $data[] =['code' => 'payment','key'=>'paypal_cost','value'=>'0'];
        $data[] =['code' => 'payment','key'=>'paypal_status','value'=>'1'];
        $data[] =['code' => 'payment','key'=>'paypal_sort','value'=>'1'];
        return DB::table('shop_setting')->insert($data);
    }

}
