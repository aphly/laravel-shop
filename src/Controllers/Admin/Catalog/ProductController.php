<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Product\Product;
use Aphly\LaravelShop\Models\Product\ProductDesc;
use Aphly\LaravelShop\Models\Product\ProductImage;
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

    public function descForm(Request $request)
    {
        $product_id = $request->query('product_id',0);
        $res['product'] = Product::where('id',$product_id)->first();
        if($res['product']){
            $res['product_desc'] = ProductDesc::where('product_id',$product_id)->firstOrNew();
        }
        return $this->makeView('laravel-shop::admin.catalog.product.desc_form',['res'=>$res]);
    }

    public function descSave(Request $request){
        $input = $request->all();
        ProductDesc::updateOrCreate(['product_id'=>$request->query('product_id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
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
                    $this->updateImg($request->product_id);
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

    function updateImg($product_id){
        $productImg = ProductImage::where('product_id',$product_id)->orderBy('sort','desc')->first();
        if($productImg){
            Product::find($productImg->product_id)->update(['image'=>$productImg->image]);
        }else{
            Product::where(['id'=>$product_id])->update(['image'=>'']);
        }
    }
}
