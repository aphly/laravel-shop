<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function index(Request $request)
    {
        $path = storage_path('app/private/shop_init.sql');
        DB::unprepared(file_get_contents($path));
        $data=[];
        $data[] =['id'=>9,'name' => 'Shop','url' =>'','pid'=>1,'is_leaf'=>0];
        $data[] =['id'=>10,'name' => 'Catalog','url' =>'','pid'=>9,'is_leaf'=>0];
        $data[] =['id'=>11,'name' => 'Category','url' =>'/shop-admin/category/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>12,'name' => 'Filter','url' =>'/shop-admin/filter/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>13,'name' => 'Product','url' =>'/shop-admin/product/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>14,'name' => 'Attribute','url' =>'/shop-admin/attribute/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>15,'name' => 'Option','url' =>'/shop-admin/option/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>16,'name' => 'Review','url' =>'/shop-admin/review/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>17,'name' => 'Information','url' =>'/shop-admin/information/index','pid'=>10,'is_leaf'=>1];
        $data[] =['id'=>18,'name' => 'Sale','url' =>'','pid'=>9,'is_leaf'=>0];
        $data[] =['id'=>19,'name' => 'Order','url' =>'/shop-admin/order/index','pid'=>18,'is_leaf'=>1];
        $data[] =['id'=>20,'name' => 'Return','url' =>'/shop-admin/return/index','pid'=>18,'is_leaf'=>1];
        $data[] =['id'=>21,'name' => 'Coupon','url' =>'/shop-admin/coupon/index','pid'=>18,'is_leaf'=>1];
        $data[] =['id'=>22,'name' => 'Setting','url' =>'','pid'=>9,'is_leaf'=>0];
        $data[] =['id'=>23,'name' => 'Currency','url' =>'/shop-admin/currency/index','pid'=>22,'is_leaf'=>1];
        $data[] =['id'=>24,'name' => 'Country','url' =>'/shop-admin/country/index','pid'=>22,'is_leaf'=>1];
        $data[] =['id'=>25,'name' => 'Zone','url' =>'/shop-admin/zone/index','pid'=>22,'is_leaf'=>1];
        DB::table('admin_menu')->insert($data);

        $data=[];
        for($i=9;$i<=25;$i++){
            $data[] =['role_id' => 2,'menu_id'=>$i];
        }
        DB::table('admin_role_menu')->insert($data);
        return '更新缓存';
    }


}
