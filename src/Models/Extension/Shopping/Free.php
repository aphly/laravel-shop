<?php

namespace Aphly\LaravelShop\Models\Extension\Shopping;

use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Free
{
    public function install() {
        $data=[];
        $data[] =['code' => 'shipping','key'=>'free_cost','value'=>'0'];
        $data[] =['code' => 'shipping','key'=>'free_status','value'=>'1'];
        $data[] =['code' => 'shipping','key'=>'free_sort','value'=>'1'];
        return DB::table('shop_setting')->insert($data);
    }
}
