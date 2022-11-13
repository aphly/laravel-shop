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
        $dict = Dict::create(['name' => '订单状态','key'=>'order_status','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Canceled','value'=>'1','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Canceled Reversal','value'=>'2','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Chargeback','value'=>'3','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Complete','value'=>'4','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Denied','value'=>'5','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Expired','value'=>'6','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Failed','value'=>'7','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Pending','value'=>'8','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Processed','value'=>'9','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Processing','value'=>'10','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Refunded','value'=>'11','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Reversed','value'=>'12','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Shipped','value'=>'13','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Voided','value'=>'14','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }
		$data=[];
		$data[] =['id'=>'1','name'=>'Pending','cn_name'=>'待支付'];
		$data[] =['id'=>'2','name'=>'Processing','cn_name'=>'处理中'];
		$data[] =['id'=>'3','name'=>'Shipped','cn_name'=>'已寄送'];
		$data[] =['id'=>'4','name'=>'Complete','cn_name'=>'已完成'];
		$data[] =['id'=>'5','name'=>'Canceled','cn_name'=>'已取消'];
		$data[] =['id'=>'6','name'=>'Denied','cn_name'=>''];
		$data[] =['id'=>'7','name'=>'Canceled Reversal','cn_name'=>''];
		$data[] =['id'=>'8','name'=>'Failed','cn_name'=>''];
		$data[] =['id'=>'9','name'=>'Refunded','cn_name'=>''];
		$data[] =['id'=>'10','name'=>'Reversed','cn_name'=>''];
		$data[] =['id'=>'11','name'=>'Chargeback','cn_name'=>''];
		$data[] =['id'=>'12','name'=>'Expired','cn_name'=>''];
		$data[] =['id'=>'13','name'=>'Processed','cn_name'=>''];
		$data[] =['id'=>'14','name'=>'Voided','cn_name'=>''];
		DB::table('shop_order_status')->insert($data);
        return 'install_ok';
    }
    public function uninstall(){
        $admin_menu = DB::table('admin_menu')->where('module_id',$this->module_id);
        $arr = $admin_menu->get()->toArray();
        if($arr){
            $admin_menu->delete();
            $ids = array_column($arr,'id');
            DB::table('admin_role_menu')->whereIn('menu_id',$ids)->delete();
        }

        $admin_dict = DB::table('admin_dict')->where('module_id',$this->module_id);
        $arr = $admin_dict->get()->toArray();
        if($arr){
            $admin_dict->delete();
            $ids = array_column($arr,'id');
            DB::table('admin_dict_value')->whereIn('dict_id',$ids)->delete();
        }
		DB::table('shop_order_status')->truncate();
        return 'uninstall_ok';
    }


}
