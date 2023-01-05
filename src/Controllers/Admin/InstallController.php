<?php

namespace Aphly\LaravelShop\Controllers\Admin;

use Aphly\LaravelAdmin\Models\Dict;
use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelAdmin\Models\Module;
use Aphly\LaravelAdmin\Models\Role;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public $module_id = 0;

    public function __construct()
    {
        parent::__construct();
        $module = Module::where('key','shop')->first();
        if(!empty($module)){
            $this->module_id = $module->id;
        }
    }

    public function install(){
        $menu = Menu::create(['name' => 'Shop','url' =>'','pid'=>0,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>10]);
        if($menu){
            $menu21 = Menu::create(['name' => 'Catalog','url' =>'','pid'=>$menu->id,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>10]);
            if($menu21){
                $data=[];
                $data[] =['name' => 'Product','url' =>'/shop_admin/product/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Attribute','url' =>'/shop_admin/attribute/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Option','url' =>'/shop_admin/option/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Review','url' =>'/shop_admin/review/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Shipping','url' =>'/shop_admin/shipping/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $menu22 = Menu::create(['name' => 'Sale','url' =>'','pid'=>$menu->id,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>9]);
            if($menu22){
                $data=[];
                $data[] =['name' => 'Order','url' =>'/shop_admin/order/index','pid'=>$menu22->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Return','url' =>'/shop_admin/return/index','pid'=>$menu22->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Coupon','url' =>'/shop_admin/coupon/index','pid'=>$menu22->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $menu23 = Menu::create(['name' => 'System','url' =>'','pid'=>$menu->id,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>8]);
            if($menu23){
                $data=[];
                $data[] =['name' => 'Setting','url' =>'/shop_admin/setting/index','pid'=>$menu23->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
        }

        $menuData = Menu::where(['module_id'=>$this->module_id])->get();
        $data=[];
        foreach ($menuData as $val){
            $data[] =['role_id' => Role::MANAGER,'menu_id'=>$val->id];
        }
        DB::table('admin_role_menu')->insert($data);

        $dict = Dict::create(['name' => '缺货时状态','key'=>'stock_status','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'2-3 Days','value'=>'1','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'In Stock','value'=>'2','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Out Of Stock','value'=>'3','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Pre-Order','value'=>'4','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }
        $dict = Dict::create(['name' => '尺寸单位','key'=>'length_class','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'cm','value'=>'1','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'in','value'=>'2','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'mm','value'=>'3','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }
        $dict = Dict::create(['name' => '重量单位','key'=>'weight_class','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'g','value'=>'1','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'kg','value'=>'2','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'oz','value'=>'3','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'lb','value'=>'4','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }
        $dict = Dict::create(['name' => '商品状态','key'=>'product_status','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'上架','value'=>'1','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'下架','value'=>'2','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }
		$data=[];
		$data[] =['id'=>'1','name'=>'Pending payment','cn_name'=>'待支付'];
		$data[] =['id'=>'2','name'=>'Processing','cn_name'=>'买家已支付'];
		$data[] =['id'=>'3','name'=>'Shipped','cn_name'=>'已寄送'];
        $data[] =['id'=>'4','name'=>'Complete','cn_name'=>'已完成'];
        $data[] =['id'=>'5','name'=>'Closed','cn_name'=>'已关闭'];
        $data[] =['id'=>'6','name'=>'Canceled','cn_name'=>'已取消'];
        $data[] =['id'=>'7','name'=>'Refund in progress','cn_name'=>'退款中'];
        $data[] =['id'=>'8','name'=>'Refunded','cn_name'=>'已退款'];
		DB::table('shop_order_status')->insert($data);
        return 'install_ok';
    }
    public function uninstall(){
        parent::uninstall();
		DB::table('shop_order_status')->truncate();
        return 'uninstall_ok';
    }


}
