<?php

namespace Aphly\LaravelShop\Commands;

use Aphly\Laravel\Models\CommonDict;
use Aphly\Laravel\Models\CommonDictValue;
use Aphly\LaravelAdmin\Models\AdminManager;
use Aphly\LaravelAdmin\Models\AdminMenu;
use Aphly\LaravelShop\Models\Account\Group;
use Aphly\LaravelShop\Models\Sale\OrderStatus;
use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\LaravelShop\Models\Setting\Zone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-shop:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $module = 'laravel-shop';

    public function clear()
    {
        AdminMenu::where('module',$this->module)->delete();
        CommonDict::where('module',$this->module)->delete();
        CommonDictValue::where('module',$this->module)->delete();
        Group::truncate();
        Country::truncate();
        Zone::truncate();
        OrderStatus::truncate();
    }

    public function handle()
    {
        $this->clear();

        $path = storage_path('app/private/shop_init.sql');
        if(file_exists($path)){
            DB::unprepared(file_get_contents($path));
        }

        $manager = AdminManager::where('username','admin')->firstOrError();
        $menu = AdminMenu::create(['name' => '商城','route' =>'','pid'=>0,'uid'=>$manager->uid,'type'=>1,'sort'=>10,'module'=>$this->module]);
        if($menu){
            $menu21 = AdminMenu::create(['name' => '目录','route' =>'','pid'=>$menu->id,'uid'=>$manager->uid,'type'=>1,'sort'=>10,'module'=>$this->module]);
            if($menu21){
                $data=[];
                $data[] =['name' => '分类管理','route' =>'shop_admin/category/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '商品管理','route' =>'shop_admin/product/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '筛选管理','route' =>'shop_admin/filter/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '属性管理','route' =>'shop_admin/attribute/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '选项管理','route' =>'shop_admin/option/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '物流管理','route' =>'shop_admin/shipping/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '文章管理','route' =>'shop_admin/information/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => 'banner','route' =>'shop_admin/banner/index','pid'=>$menu21->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                DB::table('admin_menu')->insert($data);
            }
            $menu22 = AdminMenu::create(['name' => '用户','route' =>'','pid'=>$menu->id,'uid'=>$manager->uid,'type'=>1,'sort'=>9,'module'=>$this->module]);
            if($menu22){
                $data=[];
                $data[] =['name' => '地址','route' =>'shop_admin/user_address/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '用户组','route' =>'shop_admin/group/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '心愿单','route' =>'shop_admin/wishlist/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '评论','route' =>'shop_admin/review/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '订阅','route' =>'shop_admin/subscribe/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                DB::table('admin_menu')->insert($data);
            }
            $menu22 = AdminMenu::create(['name' => '销售','route' =>'','pid'=>$menu->id,'uid'=>$manager->uid,'type'=>1,'sort'=>9,'module'=>$this->module]);
            if($menu22){
                $data=[];
                $data[] =['name' => '订单','route' =>'shop_admin/order/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                //$data[] =['name' => '售后','route' =>'shop_admin/service/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '售后','route' =>'shop_admin/after_sales/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '优惠券','route' =>'shop_admin/coupon/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '联系我们','route' =>'shop_admin/contact_us/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '销售员','route' =>'shop_admin/salesperson/index','pid'=>$menu22->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                DB::table('admin_menu')->insert($data);
            }
            $menu23 = AdminMenu::create(['name' => '设置','route' =>'','pid'=>$menu->id,'uid'=>$manager->uid,'type'=>1,'sort'=>8,'module'=>$this->module]);
            if($menu23){
                $data=[];
                $data[] =['name' => '配置','route' =>'shop_admin/config/index','pid'=>$menu23->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '国家','route' =>'shop_admin/country/index','pid'=>$menu23->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => '地区','route' =>'shop_admin/zone/index','pid'=>$menu23->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                $data[] =['name' => 'Geo','route' =>'shop_admin/geo/index','pid'=>$menu23->id,'uid'=>$manager->uid,'type'=>2,'sort'=>0,'module'=>$this->module];
                DB::table('admin_menu')->insert($data);
            }
        }

        $dict = CommonDict::create(['name' => '缺货时状态','uid'=>$manager->uid,'key'=>'stock_status','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'2-3 Days','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'In Stock','value'=>'2','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Out Of Stock','value'=>'3','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Pre-Order','value'=>'4','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => '尺寸单位','uid'=>$manager->uid,'key'=>'length_class','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'cm','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'in','value'=>'2','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'mm','value'=>'3','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => '重量单位','uid'=>$manager->uid,'key'=>'weight_class','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'g','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'kg','value'=>'2','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'oz','value'=>'3','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'lb','value'=>'4','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => '商品状态','uid'=>$manager->uid,'key'=>'product_status','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'上架','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'下架','value'=>'0','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => 'shop_yes_no','uid'=>$manager->uid,'key'=>'shop_yes_no','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Yes','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'No','value'=>'0','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => 'shop_op_status','uid'=>$manager->uid,'key'=>'shop_op_status','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Success','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Fail','value'=>'0','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $data=[];
        $data[] =['id'=>'1','name'=>'Pending payment','cn_name'=>'待支付'];
        $data[] =['id'=>'2','name'=>'To be shipped','cn_name'=>'待发货'];
        $data[] =['id'=>'3','name'=>'Shipped','cn_name'=>'已寄送'];
        $data[] =['id'=>'4','name'=>'After Sales','cn_name'=>'售后'];
        $data[] =['id'=>'5','name'=>'Closed','cn_name'=>'已关闭'];
        $data[] =['id'=>'6','name'=>'Canceled','cn_name'=>'已取消'];
        $data[] =['id'=>'7','name'=>'Refunded','cn_name'=>'已退款'];
        DB::table('shop_order_status')->insert($data);

        $dict = CommonDict::create(['name' => '售后类型','uid'=>$manager->uid,'key'=>'service_action','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'refund','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'return','value'=>'2','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => '退款状态','uid'=>$manager->uid,'key'=>'refund_status','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Request Refund','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Refusal of refund','value'=>'2','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Complete','value'=>'3','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Refunded','value'=>'4','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }

        $dict = CommonDict::create(['name' => '退货状态','uid'=>$manager->uid,'key'=>'return_status','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Request Return','value'=>'1','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Refusal of return','value'=>'2','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Agree to return','value'=>'3','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Waiting for delivery','value'=>'4','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Complete','value'=>'5','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Refunded','value'=>'6','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }
        $dict = CommonDict::create(['name' => '售后状态','uid'=>$manager->uid,'key'=>'after_sales_status','module'=>$this->module]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Processing','value'=>'0','module'=>$this->module];
            $data[] =['dict_id' => $dict->id,'name'=>'Completed','value'=>'1','module'=>$this->module];
            DB::table('common_dict_value')->insert($data);
        }
        return 'install_ok';
    }
}
