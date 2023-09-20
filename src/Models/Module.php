<?php

namespace Aphly\LaravelShop\Models;

use Aphly\Laravel\Models\Dict;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\Menu;
use Aphly\Laravel\Models\Module as Module_base;
use Illuminate\Support\Facades\DB;

class Module extends Module_base
{
    public $dir = __DIR__;

    public function install($module_id){
        parent::install($module_id);
        $manager = Manager::where('username','admin')->firstOrError();
        $menu = Menu::create(['name' => '商城','route' =>'','pid'=>0,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$module_id,'sort'=>10]);
        if($menu){
            $menu21 = Menu::create(['name' => '目录','route' =>'','pid'=>$menu->id,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$module_id,'sort'=>10]);
            if($menu21){
                $data=[];
                $data[] =['name' => '分类管理','route' =>'shop_admin/category/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '商品管理','route' =>'shop_admin/product/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '筛选管理','route' =>'shop_admin/filter/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '属性管理','route' =>'shop_admin/attribute/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '选项管理','route' =>'shop_admin/option/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '评论管理','route' =>'shop_admin/review/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '物流管理','route' =>'shop_admin/shipping/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '文章管理','route' =>'shop_admin/information/index','pid'=>$menu21->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $menu22 = Menu::create(['name' => '销售','route' =>'','pid'=>$menu->id,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$module_id,'sort'=>9]);
            if($menu22){
                $data=[];
                $data[] =['name' => '订单','route' =>'shop_admin/order/index','pid'=>$menu22->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '售后','route' =>'shop_admin/service/index','pid'=>$menu22->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '优惠券','route' =>'shop_admin/coupon/index','pid'=>$menu22->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '联系我们','route' =>'shop_admin/contact_us/index','pid'=>$menu22->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $menu23 = Menu::create(['name' => '本地','route' =>'','pid'=>$menu->id,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$module_id,'sort'=>8]);
            if($menu23){
                $data=[];
                $data[] =['name' => '设置','route' =>'shop_admin/setting/index','pid'=>$menu23->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
        }

        $menuData = Menu::where(['module_id'=>$module_id])->get();
        $data=[];
        foreach ($menuData as $val){
            $data[] =['role_id' => 1,'menu_id'=>$val->id];
        }
        DB::table('admin_role_menu')->insert($data);

        $dict = Dict::create(['name' => '缺货时状态','uuid'=>$manager->uuid,'key'=>'stock_status','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'2-3 Days','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'In Stock','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'Out Of Stock','value'=>'3'];
            $data[] =['dict_id' => $dict->id,'name'=>'Pre-Order','value'=>'4'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => '尺寸单位','uuid'=>$manager->uuid,'key'=>'length_class','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'cm','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'in','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'mm','value'=>'3'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => '重量单位','uuid'=>$manager->uuid,'key'=>'weight_class','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'g','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'kg','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'oz','value'=>'3'];
            $data[] =['dict_id' => $dict->id,'name'=>'lb','value'=>'4'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => '商品状态','uuid'=>$manager->uuid,'key'=>'product_status','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'上架','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'下架','value'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => 'shop_yes_no','uuid'=>$manager->uuid,'key'=>'shop_yes_no','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Yes','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'No','value'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => 'shop_op_status','uuid'=>$manager->uuid,'key'=>'shop_op_status','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Success','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'Fail','value'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }

        $data=[];
		$data[] =['id'=>'1','name'=>'Pending payment','cn_name'=>'待支付'];
		$data[] =['id'=>'2','name'=>'Paid','cn_name'=>'买家已支付'];
		$data[] =['id'=>'3','name'=>'Shipped','cn_name'=>'已寄送'];
        $data[] =['id'=>'4','name'=>'Complete','cn_name'=>'完成'];
        $data[] =['id'=>'5','name'=>'Closed','cn_name'=>'已关闭'];
        $data[] =['id'=>'6','name'=>'Canceled','cn_name'=>'已取消'];
        $data[] =['id'=>'7','name'=>'Refunded','cn_name'=>'已退款'];
		DB::table('shop_order_status')->insert($data);

        $dict = Dict::create(['name' => '售后类型','uuid'=>$manager->uuid,'key'=>'service_action','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'refund','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'return','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'exchange','value'=>'3'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => '退款状态','uuid'=>$manager->uuid,'key'=>'refund_status','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Request Refund','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'Refusal of refund','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'Complete','value'=>'3'];
            $data[] =['dict_id' => $dict->id,'name'=>'Refunded','value'=>'4'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => '退货状态','uuid'=>$manager->uuid,'key'=>'return_status','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Request Return','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'Refusal of return','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'Agree to return','value'=>'3'];
            $data[] =['dict_id' => $dict->id,'name'=>'Awaiting Products','value'=>'4'];
            $data[] =['dict_id' => $dict->id,'name'=>'Complete','value'=>'5'];
            $data[] =['dict_id' => $dict->id,'name'=>'Refunded','value'=>'6'];
            DB::table('admin_dict_value')->insert($data);
        }

        $dict = Dict::create(['name' => '换货状态','uuid'=>$manager->uuid,'key'=>'exchange_status','module_id'=>$module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Request exchange','value'=>'1'];
            $data[] =['dict_id' => $dict->id,'name'=>'Refusal of exchange','value'=>'2'];
            $data[] =['dict_id' => $dict->id,'name'=>'Agree to exchange','value'=>'3'];
            $data[] =['dict_id' => $dict->id,'name'=>'Awaiting products','value'=>'4'];
            $data[] =['dict_id' => $dict->id,'name'=>'Shipped','value'=>'5'];
            $data[] =['dict_id' => $dict->id,'name'=>'Complete','value'=>'6'];
            DB::table('admin_dict_value')->insert($data);
        }

        return 'install_ok';
    }
    public function uninstall($module_id){
        parent::uninstall($module_id);
        return 'uninstall_ok';
    }


}
