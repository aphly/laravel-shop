<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Attribute;
use Aphly\LaravelShop\Models\Common\AttributeGroup;
use Aphly\LaravelShop\Models\Product\Product;
use Aphly\LaravelShop\Models\Product\ProductAttribute;
use Aphly\LaravelShop\Models\Product\ProductDesc;
use Aphly\LaravelShop\Models\Product\ProductImage;
use Aphly\LaravelShop\Models\Product\ProductOption;
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
        $product = Product::updateOrCreate(['id'=>$request->query('id',0)],$input);
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
        if($request->isMethod('post')) {
            $product_id = $request->input('product_id',0);
            if($product_id){
                ProductAttribute::where('product_id',$product_id)->delete();
                $attribute_arr = $request->input('attribute',[]);
                $update_arr = [];
                foreach ($attribute_arr as $key=>$val){
                    $update_arr[] = ['attribute_id'=>$key,'text'=>$val,'product_id'=>$product_id];
                }
                ProductAttribute::insert($update_arr);
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
            }
        }else{
            $product_id = $request->query('product_id',0);
            $res['product'] = Product::where('id',$product_id)->first();
            if($res['product']){
                $res['product_attribute'] = ProductAttribute::where('product_id',$product_id)->with('attribute')->get()->toArray();

            }
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
        if($request->isMethod('post')) {
            $product_id = $request->input('product_id',0);
            if($product_id){
                ProductAttribute::where('product_id',$product_id)->delete();
                $attribute_arr = $request->input('attribute',[]);
                $update_arr = [];
                foreach ($attribute_arr as $key=>$val){
                    $update_arr[] = ['attribute_id'=>$key,'text'=>$val,'product_id'=>$product_id];
                }
                ProductAttribute::insert($update_arr);
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
            }
        }else{
            $product_id = $request->query('product_id',0);
            $res['product'] = Product::where('id',$product_id)->first();
            if($res['product']){
                $res['product_attribute'] = ProductOption::where('product_id',$product_id)->with('attribute')->get()->toArray();

            }
            return $this->makeView('laravel-shop::admin.catalog.product.attribute',['res'=>$res]);
        }
    }

    public function optionAjax(Request $request){
        $name = $request->query('name',false);
        $list = Attribute::leftJoin('shop_attribute_group','shop_attribute_group.id','=','shop_attribute.attribute_group_id')
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
}
