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
        $data[] =['id'=>10002,'name' => 'Category','url' =>'/shop_admin/category/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10003,'name' => 'Filter','url' =>'/shop_admin/filter/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10004,'name' => 'Product','url' =>'/shop_admin/product/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10005,'name' => 'Attribute','url' =>'/shop_admin/attribute/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10006,'name' => 'Option','url' =>'/shop_admin/option/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10007,'name' => 'Review','url' =>'/shop_admin/review/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10008,'name' => 'Information','url' =>'/shop_admin/information/index','pid'=>10001,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10009,'name' => 'Sale','url' =>'','pid'=>10000,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10010,'name' => 'Order','url' =>'/shop_admin/order/index','pid'=>10009,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10011,'name' => 'Return','url' =>'/shop_admin/return/index','pid'=>10009,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10012,'name' => 'Coupon','url' =>'/shop_admin/coupon/index','pid'=>10009,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10013,'name' => 'System','url' =>'','pid'=>10000,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10014,'name' => 'Setting','url' =>'/shop_admin/setting/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10015,'name' => 'Currency','url' =>'/shop_admin/currency/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10016,'name' => 'Country','url' =>'/shop_admin/country/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10017,'name' => 'Zone','url' =>'/shop_admin/zone/index','pid'=>10013,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10018,'name' => 'Customer','url' =>'','pid'=>10000,'is_leaf'=>0,'module_id'=>2];
        $data[] =['id'=>10019,'name' => 'Customer','url' =>'/shop_admin/customer/index','pid'=>10018,'is_leaf'=>1,'module_id'=>2];
        $data[] =['id'=>10020,'name' => 'Group','url' =>'/shop_admin/group/index','pid'=>10018,'is_leaf'=>1,'module_id'=>2];
        DB::table('admin_menu')->insert($data);

        $data=[];
        for($i=10000;$i<=10020;$i++){
            $data[] =['role_id' => 2,'menu_id'=>$i];
        }
        DB::table('admin_role_menu')->insert($data);

        $data=[];
        $data[] =['id'=>10000,'name' => '缺货时状态','key'=>'stock_status','module_id'=>2];
        $data[] =['id'=>10001,'name' => '尺寸单位','key'=>'length_class','module_id'=>2];
        $data[] =['id'=>10002,'name' => '重量单位','key'=>'weight_class','module_id'=>2];
        $data[] =['id'=>10003,'name' => '商品状态','key'=>'product_status','module_id'=>2];
        DB::table('admin_dict')->insert($data);

        $data=[];
        $data[] =['dict_id' => 10000,'name'=>'2-3 Days','value'=>'1','fixed'=>'0'];
        $data[] =['dict_id' => 10000,'name'=>'In Stock','value'=>'2','fixed'=>'0'];
        $data[] =['dict_id' => 10000,'name'=>'Out Of Stock','value'=>'3','fixed'=>'0'];
        $data[] =['dict_id' => 10000,'name'=>'Pre-Order','value'=>'4','fixed'=>'0'];
        $data[] =['dict_id' => 10001,'name'=>'cm','value'=>'1','fixed'=>'0'];
        $data[] =['dict_id' => 10001,'name'=>'in','value'=>'2','fixed'=>'0'];
        $data[] =['dict_id' => 10001,'name'=>'mm','value'=>'3','fixed'=>'0'];
        $data[] =['dict_id' => 10002,'name'=>'g','value'=>'1','fixed'=>'0'];
        $data[] =['dict_id' => 10002,'name'=>'kg','value'=>'2','fixed'=>'0'];
        $data[] =['dict_id' => 10002,'name'=>'oz','value'=>'3','fixed'=>'0'];
        $data[] =['dict_id' => 10002,'name'=>'lb','value'=>'4','fixed'=>'0'];
        $data[] =['dict_id' => 10003,'name'=>'上架','value'=>'1','fixed'=>'0'];
        $data[] =['dict_id' => 10003,'name'=>'下架','value'=>'2','fixed'=>'0'];
        DB::table('admin_dict_value')->insert($data);

        $data=[];
        $data[] =['name' => 'lv1'];
        DB::table('shop_customer_group')->insert($data);

        $data=[];
        $data[] =['id' => 1,'type'=>'total','code'=>'shipping'];
        $data[] =['id' => 2,'type'=>'total','code'=>'sub_total'];
        $data[] =['id' => 3,'type'=>'total','code'=>'total'];
        $data[] =['id' => 4,'type'=>'total','code'=>'credit'];
        $data[] =['id' => 5,'type'=>'total','code'=>'coupon'];
        $data[] =['id' => 6,'type'=>'total','code'=>'low_order_fee'];
        $data[] =['id' => 7,'type'=>'total','code'=>'voucher'];
        $data[] =['id' => 8,'type'=>'total','code'=>'handling'];
        $data[] =['id' => 9,'type'=>'total','code'=>'reward'];
        $data[] =['id' => 10,'type'=>'total','code'=>'tax'];
        DB::table('shop_extension')->insert($data);

        return 'install_ok';
    }
    public function uninstall(){
        DB::table('shop_country')->truncate();
        DB::table('shop_zone')->truncate();
        DB::table('shop_currency')->truncate();
        DB::table('shop_customer_group')->truncate();
        DB::table('shop_extension')->truncate();

        $admin_menu = DB::table('admin_menu')->where('module_id',2);
        $arr = $admin_menu->get()->toArray();
        $admin_menu->delete();
        $ids = array_column($arr,'id');
        DB::table('admin_role_menu')->whereIn('menu_id',$ids)->delete();

        $admin_dict = DB::table('admin_dict')->where('module_id',2);
        $arr = $admin_dict->get()->toArray();
        $admin_dict->delete();
        $ids = array_column($arr,'id');
        DB::table('admin_dict_value')->whereIn('dict_id',$ids)->delete();

        return 'uninstall_ok';
    }


}
