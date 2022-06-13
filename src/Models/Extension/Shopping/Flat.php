<?php

namespace Aphly\LaravelShop\Models\Extension\Shopping;

use Illuminate\Support\Facades\DB;

class Flat
{
    public function install() {
        $data=[];
        $data[] =['code' => 'shipping','key'=>'flat_cost','value'=>'5'];
        $data[] =['code' => 'shipping','key'=>'flat_status','value'=>'1'];
        $data[] =['code' => 'shipping','key'=>'flat_sort','value'=>'1'];
        return DB::table('shop_setting')->insert($data);
    }
}
