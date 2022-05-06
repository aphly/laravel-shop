<?php

namespace Aphly\LaravelShop\Controllers\Admin;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function install(){
        $path = storage_path('app/private/shop_init.sql');
        DB::unprepared(file_get_contents($path));
        $data=[];
        $data[] =['id'=>10000,'name' => 'Shop','url' =>'','pid'=>0,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10001,'name' => 'Catalog','url' =>'','pid'=>10000,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10002,'name' => 'Category','url' =>'/shop-admin/category/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10003,'name' => 'Filter','url' =>'/shop-admin/filter/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10004,'name' => 'Product','url' =>'/shop-admin/product/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10005,'name' => 'Attribute','url' =>'/shop-admin/attribute/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10006,'name' => 'Option','url' =>'/shop-admin/option/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10007,'name' => 'Review','url' =>'/shop-admin/review/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10008,'name' => 'Information','url' =>'/shop-admin/information/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10009,'name' => 'Sale','url' =>'','pid'=>10000,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10010,'name' => 'Order','url' =>'/shop-admin/order/index','pid'=>10009,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10011,'name' => 'Return','url' =>'/shop-admin/return/index','pid'=>10009,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10012,'name' => 'Coupon','url' =>'/shop-admin/coupon/index','pid'=>10009,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10013,'name' => 'Setting','url' =>'','pid'=>10000,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10014,'name' => 'Currency','url' =>'/shop-admin/currency/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10015,'name' => 'Country','url' =>'/shop-admin/country/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10016,'name' => 'Zone','url' =>'/shop-admin/zone/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        DB::table('admin_menu')->insert($data);

        $data=[];
        for($i=10000;$i<=10016;$i++){
            $data[] =['role_id' => 2,'menu_id'=>$i];
        }
        DB::table('admin_role_menu')->insert($data);
        return 'install_ok';
    }
    public function uninstall(){
        $admin_menu = DB::table('admin_menu')->where('module_id',2);
        $arr = $admin_menu->get()->toArray();
        $admin_menu->delete();
        $ids = array_column($arr,'id');
        DB::table('admin_role_menu')->whereIn('menu_id',$ids)->delete();

        DB::table('shop_country')->truncate();
        DB::table('shop_zone')->truncate();
        DB::table('shop_currency')->truncate();
        return 'uninstall_ok';
    }


}
