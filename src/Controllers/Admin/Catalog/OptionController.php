<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Option;
use Aphly\LaravelShop\Models\Common\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller
{
    public $index_url='/shop_admin/option/index';

    public function index(Request $request)
    {
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Option::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.catalog.option.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['optionValue'] = [];
        $res['option'] = Option::where('id',$request->query('id',0))->firstOrNew();
        if($res['option']->id){
            $res['optionValue'] = OptionValue::where('option_id',$res['option']->id)->orderBy('sort','desc')->get();
        }
        return $this->makeView('laravel-shop::admin.catalog.option.form',['res'=>$res]);
    }

    public function save(Request $request){
        $option = Option::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        if($option->id){
            $optionValue = OptionValue::where('option_id',$option->id)->get()->keyBy('id')->toArray();
            $val_arr = $request->input('value',[]);
            $val_arr_keys = array_keys($val_arr);
            $update_arr = $delete_arr = [];
            foreach ($optionValue as $val){
                if(!in_array($val['id'],$val_arr_keys)){
                    $delete_arr[] = $val['id'];
                    Storage::delete($val['image']);
                }
            }
            OptionValue::whereIn('id',$delete_arr)->delete();
            $files = $request->file('value');
            foreach ($val_arr as $key=>$val){

                foreach ($val as $k=>$v){
                    $update_arr[$key][$k]=$v;
                }
                $update_arr[$key]['id'] = intval($key);
                $update_arr[$key]['option_id'] = $option->id;
                if($key_i = intval($key)){
                    if(isset($val['image'])) {
                        if($val['image'] == 'undefined'){
                            Storage::delete($optionValue[$key_i]['image']);
                            $update_arr[$key]['image'] = '';
                        }
                    }else{
                        $update_arr[$key]['image'] = isset($files[$key]['image'])?UploadFile::img($files[$key]['image'], 'public/shop/option'):'';
                        if($update_arr[$key]['image']){
                            Storage::delete($optionValue[$key_i]['image']);
                        }
                    }
                }else{
                    $update_arr[$key]['image'] = isset($files[$key]['image'])?UploadFile::img($files[$key]['image'], 'public/shop/option'):'';
                }
            }
            OptionValue::upsert($update_arr,['id'],['option_id','name','image','sort']);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Option::whereIn('id',$post)->delete();
            OptionValue::whereIn('option_id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
