<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Attribute;
use Aphly\LaravelShop\Models\Common\AttributeGroup;
use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Common\CategoryPath;
use Aphly\LaravelShop\Models\Common\Filter;
use Aphly\LaravelShop\Models\Common\FilterGroup;
use Aphly\LaravelShop\Models\Common\Option;
use Aphly\LaravelShop\Models\Product\Product;
use Aphly\LaravelShop\Models\Product\ProductAttribute;
use Aphly\LaravelShop\Models\Product\ProductCategory;
use Aphly\LaravelShop\Models\Product\ProductDesc;
use Aphly\LaravelShop\Models\Product\ProductFilter;
use Aphly\LaravelShop\Models\Product\ProductImage;
use Aphly\LaravelShop\Models\Product\ProductOption;
use Aphly\LaravelShop\Models\Product\ProductOptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public $index_url='/shop_admin/product/index';

    public function index(Request $request)
    {
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
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

    public function form(Request $request)
    {
        $res['product'] = Product::where('id',$request->query('id',0))->firstOrNew();

        return $this->makeView('laravel-shop::admin.catalog.product.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['date_add'] = time();
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
        if($request->isMethod('post')) {
            $input = $request->all();
            ProductDesc::updateOrCreate(['product_id'=>$request->query('product_id',0)],$input);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $product_id = $request->query('product_id',0);
            $res['product'] = Product::where('id',$product_id)->first();
            if($res['product']){
                $res['product_desc'] = ProductDesc::where('product_id',$product_id)->firstOrNew();
            }
            return $this->makeView('laravel-shop::admin.catalog.product.desc',['res'=>$res]);
        }
    }

    public function img(Request $request)
    {
        $res['info'] = Product::find($request->id);
        $res['info_img'] = ProductImage::where('product_id',$request->id)->orderBy('sort','desc')->get()->toArray();
        if($request->isMethod('post')) {
            if($request->hasFile('file')) {
                $file_path = UploadFile::imgs($request->file('file'), 'public/shop/product/image',2);
                $img_src = $insertData = [];
                foreach ($file_path as $key=>$val) {
                    $img_src[] = Storage::url($val);
                    $insertData[] = ['product_id'=>$res['info']->id,'image'=>$val,'sort'=>$key];
                }
                if ($insertData) {
                    ProductImage::insert($insertData);
                    $this->updateImg($request->id);
                    throw new ApiException(['code' => 0, 'msg' => '上传成功', 'data' => ['redirect' => '/shop_admin/product/'.$res['info']->id.'/img','imgs'=>$img_src]]);
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
        $post = $request->input('sort');
        $max = max($post);
        foreach ($post as $k=>$v){
            $productImage = ProductImage::find($k);
            $productImage->update(['sort'=>$v]);
            if($v==$max){
                Product::find($productImage->product_id)->update(['image'=>$productImage->image]);
            }
        }
        throw new ApiException(['code' => 0, 'msg' => '更新成功', 'data' => ['redirect' => '/shop_admin/product/'.$request->id.'/img']]);
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
        if($productImg){
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

    public function attributeAjax(Request $request){
        $name = $request->query('name',false);
        $list = AttributeGroup::leftJoin('shop_attribute','shop_attribute_group.id','=','shop_attribute.attribute_group_id')
            ->when($name,function($query,$name) {
                return $query->where('shop_attribute.name', 'like', '%'.$name.'%');
            })
            ->select('shop_attribute.*','shop_attribute_group.name as groupname')
            ->where('shop_attribute_group.status',1)->get()->toArray();
        $attr_res = [];
        foreach ($list as $val){
            $attr_res[$val['attribute_group_id']]['groupname'] = $val['groupname'];
            $attr_res[$val['attribute_group_id']]['child'][$val['id']] = $val['name'];
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$attr_res]]);
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
                    ProductOptionValue::upsert($product_option_value_update,['id'],['product_option_id','product_id','option_id','option_value_id','quantity','subtract','price','points','weight']);
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product_option'] = ProductOption::where('product_id',$product_id)->with('value_arr')->get()->toArray();
            $res['option'] = Option::with('value')->get()->keyBy('id')->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.option',['res'=>$res]);
        }
    }

    public function optionAjax(Request $request){
        $name = $request->query('name',false);
        $list = Option::where('status',1)->when($name,function($query,$name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->with('value')->get()->keyBy('id')->toArray();
        $option_group = [];
        foreach ($list as $val){
            $option_group[$val['type']][] = $val;
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list,'option_group'=>$option_group]]);
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
            $res['category'] = $category_ids?(CategoryPath::leftJoin('shop_category as c1','c1.id','=','shop_category_path.category_id')
                ->leftJoin('shop_category as c2','c2.id','=','shop_category_path.path_id')
                ->whereIn('c1.id', $category_ids)
                ->groupBy('category_id')
                ->selectRaw('any_value(c1.`id`) AS id,any_value(shop_category_path.`category_id`) AS category_id,
            GROUP_CONCAT(c2.`name` ORDER BY shop_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name')
                ->get()->keyBy('id')->toArray()):[];

            $res['product_filter'] = ProductFilter::where('product_id',$product_id)->get()->toArray();
            $filter_ids = array_column($res['product_filter'],'filter_id');
            $res['filter'] = Filter::leftJoin('shop_filter_group as group','group.id','=','shop_filter.filter_group_id')
                ->whereIn('shop_filter.id', $filter_ids)
                ->selectRaw("shop_filter.*,concat(group.name,' \> ',shop_filter.name) as name_all")
                ->get()->keyBy('id')->toArray();
            return $this->makeView('laravel-shop::admin.catalog.product.links',['res'=>$res]);
        }
    }

    public function linksCategory(Request $request){
        $name = $request->query('name',false);
        $list = CategoryPath::leftJoin('shop_category as c1','c1.id','=','shop_category_path.category_id')
            ->leftJoin('shop_category as c2','c2.id','=','shop_category_path.path_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('c1.name', 'like', '%'.$name.'%');
                })
            ->where('c1.status', 1)
            ->groupBy('category_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(shop_category_path.`category_id`) AS category_id,
                GROUP_CONCAT(c2.`name` ORDER BY shop_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

    public function linksFilter(Request $request){
        $name = $request->query('name',false);
        $list = Filter::leftJoin('shop_filter_group as group','group.id','=','shop_filter.filter_group_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('shop_filter.name', 'like', '%'.$name.'%');
                })
            ->where('group.status', 1)
            ->selectRaw("shop_filter.*,concat(group.name,' \> ',shop_filter.name) as name_all,group.status as status")
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
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
        $product = Product::where('id',$product_id)->first();
        if($product){
            return $product;
        }else{
            throw new ApiException(['code'=>2,'msg'=>'fail','data'=>[]]);
        }
    }
}
