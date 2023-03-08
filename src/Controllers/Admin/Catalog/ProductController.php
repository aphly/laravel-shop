<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\LaravelCommon\Models\CategoryPath;
use Aphly\LaravelCommon\Models\Filter;
use Aphly\LaravelCommon\Models\Group;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Option;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductAttribute;
use Aphly\LaravelShop\Models\Catalog\ProductCategory;
use Aphly\LaravelShop\Models\Catalog\ProductDesc;
use Aphly\LaravelShop\Models\Catalog\ProductDiscount;
use Aphly\LaravelShop\Models\Catalog\ProductFilter;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Catalog\ProductOption;
use Aphly\LaravelShop\Models\Catalog\ProductOptionValue;
use Aphly\LaravelShop\Models\Catalog\ProductReward;
use Aphly\LaravelShop\Models\Catalog\ProductSpecial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public $index_url='/shop_admin/product/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['status'] = $status = $request->query('status',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Product::when($name,
            function($query,$name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->when($status,
                function($query,$status) {
                    return $query->where('status', $status);
                })
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.catalog.product.index',['res'=>$res]);
    }

    public function ajax(Request $request)
    {
        $name = $request->query('name',false);
        $list = Product::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->where('status', 1)
            ->select('id','name')
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $input['uuid'] = $this->manager->uuid;
            $input['date_available'] = $input['date_available']?strtotime($input['date_available']):time();
            Product::create($input);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product'] = Product::where('id',$request->query('product_id',0))->firstOrNew();
            return $this->makeView('laravel-shop::admin.catalog.product.form',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        $res['product'] = Product::where('id',$request->query('product_id',0))->firstOrError();
        if($request->isMethod('post')){
            $input = $request->all();
            $input['date_available'] = $input['date_available']?strtotime($input['date_available']):time();
            $res['product']->update($input);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            return $this->makeView('laravel-shop::admin.catalog.product.form',['res'=>$res]);
        }
    }

    public function form(Request $request)
    {
        $res['product'] = Product::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-shop::admin.catalog.product.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['uuid'] = $this->manager->uuid;
        $input['date_available'] = $input['date_available']?strtotime($input['date_available']):time();
        Product::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Product::destroy($post);
            ProductDesc::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function desc(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        if($request->isMethod('post')) {
            $input = $request->all();
            ProductDesc::updateOrCreate(['product_id'=>$res['product']->id],$input);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product'] = Product::where('id',$res['product']->id)->first();
            if(!empty($res['product'])){
                $res['product_desc'] = ProductDesc::where('product_id',$res['product']->id)->firstOrNew();
            }
            return $this->makeView('laravel-shop::admin.catalog.product.desc',['res'=>$res]);
        }
    }

    public function img(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $res['info_img'] = ProductImage::where('product_id',$res['product']->id)->orderBy('sort','desc')->get()->toArray();
        if($request->isMethod('post')) {
            if($request->hasFile('file')) {
                $file_path = (new UploadFile(1,5))->uploads($request->file('file'), 'public/shop/product/image');
                $img_src = $insertData = [];
                foreach ($file_path as $key=>$val) {
                    $img_src[] = Storage::url($val);
                    $insertData[] = ['product_id'=>$res['product']->id,'image'=>$val,'sort'=>$key];
                }
                if ($insertData) {
                    ProductImage::insert($insertData);
                    $this->updateImg($res['product']->id);
                    throw new ApiException(['code' => 0, 'msg' => '上传成功', 'data' => ['redirect' => '/shop_admin/product/img?product_id='.$res['product']->id,'imgs'=>$img_src]]);
                }
            }
            throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
        }else{
            $res['title'] = '';
            return $this->makeView('laravel-shop::admin.catalog.product.img',['res'=>$res]);
        }
    }

    public function imgSave(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $product_id = $res['product']->id;
        $post = $request->input('sort');
        $max = max($post);
        foreach ($post as $k=>$v){
            $productImage = ProductImage::find($k);
            $productImage->update(['sort'=>$v]);
            if($v==$max){
                Product::find($productImage->product_id)->update(['image'=>$productImage->image]);
            }
        }
        throw new ApiException(['code' => 0, 'msg' => '更新成功', 'data' => ['redirect' => $this->index_url]]);
    }

    public function imgDel(Request $request)
    {
        $info_obj = ProductImage::where('id',$request->id);
        $info = $info_obj->first();
        if($info_obj->delete()){
            Storage::delete($info->image);
        }
        $this->updateImg($info->product_id);
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
    }

    public function updateImg($product_id){
        $productImg = ProductImage::where('product_id',$product_id)->orderBy('sort','desc')->first();
        if(!empty($productImg)){
            Product::find($productImg->product_id)->update(['image'=>$productImg->image]);
        }else{
            Product::where(['id'=>$product_id])->update(['image'=>'']);
        }
    }

    public function attribute(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $product_id = $res['product']->id;
        if($request->isMethod('post')) {
            ProductAttribute::where('product_id',$product_id)->delete();
            $attribute_arr = $request->input('attribute',[]);
            $update_arr = [];
            foreach ($attribute_arr as $key=>$val){
                $update_arr[] = ['attribute_id'=>$key,'text'=>$val,'product_id'=>$product_id];
            }
            ProductAttribute::insert($update_arr);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product_attribute'] = ProductAttribute::where('product_id',$product_id)->with('attribute')->get()->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.attribute',['res'=>$res]);
        }
    }

    public function option(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $product_id = $res['product']->id;
        if($request->isMethod('post')) {
            $product_option = $request->input('product_option',[]);
            $productOption_data = ProductOption::where('product_id',$product_id)->get()->toArray();
            $del_arr = $this->getDelArr($productOption_data,$product_option);
            if($del_arr){
                ProductOption::whereIn('id',$del_arr)->delete();
                ProductOptionValue::whereIn('product_option_id',$del_arr)->delete();
            }
            foreach ($product_option as $key => $val){
                $arr = $option_value = [];
                $arr['product_id'] = $product_id;
                foreach ($val as $k=>$v){
                    $arr['option_id'] = $k;
                    $arr['value'] = $v['value']??'';
                    $arr['required'] = $v['required']??0;
                    $option_value = $v['option_value']??[];
                }
                $productOption = ProductOption::updateOrCreate(['id'=>$key],$arr);
                if($productOption->id){
                    $productOptionValue_data = ProductOptionValue::where('product_option_id',$productOption->id)->get()->toArray();
                    $del_arr = $this->getDelArr($productOptionValue_data,$option_value);
                    if($del_arr){
                        ProductOptionValue::whereIn('id',$del_arr)->delete();
                    }
                    $product_option_value_update = [];
                    foreach ($option_value as $k => $v) {
                        $arr_v = $v;
                        $arr_v['id'] = intval($k);
                        $arr_v['product_option_id'] = $productOption->id;
                        $arr_v['product_id'] = $product_id;
                        $arr_v['option_id'] = $productOption->option_id;
                        $product_option_value_update[] = $arr_v;
                    }
                    ProductOptionValue::upsert($product_option_value_update,['id'],['product_option_id','product_id','option_id','option_value_id','product_image_id','quantity','subtract','price','weight']);
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product_option'] = ProductOption::where('product_id',$product_id)->with('value_arr')->orderBy('id','desc')->get()->toArray();
            $res['option'] = Option::with('value')->get()->keyBy('id')->toArray();
            $res['product_image'] = ProductImage::where('product_id',$product_id)->get()->keyBy('id')->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.option',['res'=>$res]);
        }
    }

    public function links(Request $request){
        $res['product'] = $this->getProductId($request);
        $product_id = $res['product']->id;
        if($request->isMethod('post')) {
            ProductCategory::where('product_id',$product_id)->delete();
            $product_category = $request->input('product_category',[]);
            if($product_category){
                $update_arr = [];
                foreach ($product_category as $val){
                    $update_arr[] = ['category_id'=>$val,'product_id'=>$product_id];
                }
                ProductCategory::insert($update_arr);
            }
            ProductFilter::where('product_id',$product_id)->delete();
            $product_filter = $request->input('product_filter',[]);
            if($product_filter){
                $update_arr = [];
                foreach ($product_filter as $val){
                    $update_arr[] = ['filter_id'=>$val,'product_id'=>$product_id];
                }
                ProductFilter::insert($update_arr);
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product_category'] = ProductCategory::where('product_id',$product_id)->get()->toArray();
            $category_ids = array_column($res['product_category'],'category_id');
            $res['category'] = (new CategoryPath)->getByIds($category_ids);

            $res['product_filter'] = ProductFilter::where('product_id',$product_id)->get()->toArray();
            $filter_ids = array_column($res['product_filter'],'filter_id');
            $res['filter'] = Filter::leftJoin('common_filter_group as group','group.id','=','common_filter.filter_group_id')
                ->whereIn('common_filter.id', $filter_ids)
                ->selectRaw("common_filter.*,concat(group.name,' \> ',common_filter.name) as name_all")
                ->get()->keyBy('id')->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.links',['res'=>$res]);
        }
    }

//    public function reward(Request $request){
//        $res['product'] = $this->getProductId($request);
//        $product_id = $res['product']->id;
//        if($request->isMethod('post')) {
//            ProductReward::where('product_id',$product_id)->delete();
//            $product_reward = $request->input('product_reward',[]);
//            if($product_reward){
//                $update_arr = [];
//                foreach ($product_reward as $key=>$val){
//                    $update_arr[] = ['group_id'=>$key,'points'=>$val,'product_id'=>$product_id];
//                }
//                ProductReward::insert($update_arr);
//            }
//            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
//        }else{
//            $res['group'] = Group::get()->keyBy('id')->toArray();
//            $res['product_reward'] = ProductReward::where('product_id',$product_id)->get()->keyBy('group_id')->toArray();
//            return $this->makeView('laravel-shop::admin.catalog.product.reward',['res'=>$res]);
//        }
//    }

    public function special(Request $request){
        $res['product'] = $this->getProductId($request);
        $product_id = $res['product']->id;
        if($request->isMethod('post')) {
            $product_special = $request->input('product_special',[]);
            $productSpecial_data = ProductSpecial::where('product_id',$product_id)->get()->toArray();
            $del_arr = $this->getDelArr($productSpecial_data,$product_special);
            if($del_arr){
                ProductSpecial::whereIn('id',$del_arr)->delete();
            }
            $update = [];
            foreach ($product_special as $k => $v) {
                $arr_v = $v;
                $arr_v['id'] = intval($k);
                $arr_v['product_id'] = $product_id;
                $arr_v['date_start'] = strtotime($v['date_start']);
                $arr_v['date_end'] = strtotime($v['date_end']);
                $update[] = $arr_v;
            }
            ProductSpecial::upsert($update,['id'],['product_id','group_id','price','date_start','date_end']);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            //$res['group'] = Group::get()->keyBy('id')->toArray();
            $res['product_special'] = ProductSpecial::where('product_id',$product_id)->get()->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.special',['res'=>$res]);
        }
    }

    public function discount(Request $request){
        $res['product'] = $this->getProductId($request);
        $product_id = $res['product']->id;
        if($request->isMethod('post')) {
            $product_discount = $request->input('product_discount',[]);
            $productDiscount_data = ProductDiscount::where('product_id',$product_id)->get()->toArray();
            $del_arr = $this->getDelArr($productDiscount_data,$product_discount);
            if($del_arr){
                ProductDiscount::whereIn('id',$del_arr)->delete();
            }
            $update = [];
            foreach ($product_discount as $k => $v) {
                $arr_v = $v;
                $arr_v['id'] = intval($k);
                $arr_v['product_id'] = $product_id;
                $update[] = $arr_v;
            }
            ProductDiscount::upsert($update,['id'],['product_id','price','quantity']);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            //$res['group'] = Group::get()->keyBy('id')->toArray();
            $res['product_discount'] = ProductDiscount::where('product_id',$product_id)->get()->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.discount',['res'=>$res]);
        }
    }

    public function getDelArr($data,$input){
        $ids = array_column($data,'id');
        $del_arr = [];
        $input_ids = [];
        foreach ($input as $key => $val){
            if(intval($key)){
                $input_ids[]=$key;
            }
        }
        foreach ($ids as $val){
            if(!in_array($val,$input_ids)){
                $del_arr[] = $val;
            }
        }
        return $del_arr;
    }

    function getProductId($request){
        $product_id = $request->input('product_id',0);
        if(!$product_id){
            throw new ApiException(['code'=>1,'msg'=>'fail','data'=>[]]);
        }
        return Product::where('id',$product_id)->firstOrError();
    }
}
