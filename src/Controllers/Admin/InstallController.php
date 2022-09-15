<?php

namespace Aphly\LaravelShop\Controllers\Admin;

use Aphly\LaravelAdmin\Models\Dict;
use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelAdmin\Models\Role;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public $module_id = 5;

    public function install(){
        $menu = Menu::create(['name' => 'Novel','url' =>'','pid'=>0,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>30]);
        if($menu){
            $data=[];
            $data[] =['name' => 'Novel','url' =>'/novel_admin/novel/index','pid'=>$menu->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
            $data[] =['name' => 'Novel Order','url' =>'/novel_admin/novel/order','pid'=>$menu->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
            DB::table('admin_menu')->insert($data);
        }
        $menuData = Menu::where(['module_id'=>$this->module_id])->get();
        $data=[];
        foreach ($menuData as $val){
            $data[] =['role_id' => Role::MANAGER,'menu_id'=>$val->id];
        }
        DB::table('admin_role_menu')->insert($data);

        $dict = Dict::create(['name' => '是否上架','key'=>'novel_display','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'下架','value'=>'2','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'上架','value'=>'1','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }
        $dict = Dict::create(['name' => 'novel_status','key'=>'novel_status','module_id'=>$this->module_id]);
        if($dict->id){
            $data=[];
            $data[] =['dict_id' => $dict->id,'name'=>'Hiatus','value'=>'3','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Completed','value'=>'2','fixed'=>'0'];
            $data[] =['dict_id' => $dict->id,'name'=>'Ongoing','value'=>'1','fixed'=>'0'];
            DB::table('admin_dict_value')->insert($data);
        }

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
        return 'uninstall_ok';
    }


}
