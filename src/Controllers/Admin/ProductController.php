<?php

namespace Aphly\LaravelShop\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Func;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\Laravel\Models\Dictionary;
use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Product;
use Aphly\LaravelShop\Models\ProductDesc;
use Aphly\LaravelShop\Models\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public $index_url='/shop-admin/product/index';
    public function index(Request $request)
    {
        $res['title']='我的';
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Product::when($name,
            function($query,$name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->when($status,
                function($query,$status) {
                    return $query->where('status', '=', $status);
                })
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop::admin.product.index',['res'=>$res]);
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $post = $arr = $request->all();
            $post['createtime'] = time();
            if($post['frame_width']>=110 && $post['frame_width']<=135){
                $post['size']=1;
            }else if($post['frame_width']>=136 && $post['frame_width']<=140){
                $post['size']=2;
            }else if($post['frame_width']>=141){
                $post['size']=3;
            }else{
                $post['size']=0;
            }
            $post['gender']= $post['gender']?implode(',',$post['gender']):'';
            $post['material']= $post['material']?implode(',',$post['material']):'';
            $post['color']= $post['color']?implode(',',$post['color']):'';
            $post['feature']= $post['feature']?implode(',',$post['feature']):'';
            $product = Product::create($post);
            if($product->id){
                $arr['product_id'] = $product->id;
                ProductDesc::create($arr);
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title']='我的';
            $res['cate']=(new Menu)->getMenuById(10);
            $res['filter_arr'] = $this->getFilter();
            return $this->makeView('laravel-shop::admin.product.add',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        if($request->isMethod('post')) {
            $product = Product::find($request->id);
            $post = $arr = $request->all();
            if($post['frame_width']>=110 && $post['frame_width']<=135){
                $post['size']=1;
            }else if($post['frame_width']>=136 && $post['frame_width']<=140){
                $post['size']=2;
            }else if($post['frame_width']>=141){
                $post['size']=3;
            }else{
                $post['size']=0;
            }
            $post['material']= $post['material']?implode(',',$post['material']):'';
            $post['color']= $post['color']?implode(',',$post['color']):'';
            $post['feature']= $post['feature']?implode(',',$post['feature']):'';
            if($product->update($post)){
                ProductDesc::find($request->id)->update($arr);
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['title']='我的';
            $res['info'] = Product::find($request->id);
            $res['info_desc'] = ProductDesc::find($request->id);
            $res['cate']=(new Menu)->getMenuById(10);
            $res['select_ids'] = [$res['info']['cate_id']];
            $res['filter_arr'] = $this->getFilter();
            return $this->makeView('laravel-shop::admin.product.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Product::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function img(Request $request)
    {
        $res['info'] = Product::find($request->id);
        $res['info_img'] = ProductImg::where('product_id',$request->id)->orderBy('sort','desc')->get()->toArray();
        if($request->isMethod('post')) {
            if($request->hasFile('file')) {
                $file_path = $img_src = [];
                foreach ($request->file('file') as $file) {
                    $src = UploadFile::upload($file, 'public/product_img');
                    $img_src[] = Storage::url($src);
                    $file_path[] = new ProductImg(['src'=>$src]);
                }
                if ($file_path) {
                    $res['info']->img()->saveMany($file_path);
                    throw new ApiException(['code' => 0, 'msg' => '上传成功', 'data' => ['redirect' => '/shop-admin/product/'.$request->id.'/img','imgs'=>$img_src]]);
                }
            }
            throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
        }else{
            $res['title']='我的';
            return $this->makeView('laravel-shop::admin.product.img',['res'=>$res]);
        }
    }

    public function imgSave(Request $request)
    {
        $post = $request->input('sort');
        foreach ($post as $k=>$v){
            ProductImg::find($k)->update(['sort'=>$v]);
        }
        throw new ApiException(['code' => 0, 'msg' => '更新成功', 'data' => ['redirect' => '/shop-admin/product/'.$request->id.'/img']]);
    }

    public function imgDel(Request $request)
    {
        $info = ProductImg::find($request->id);
        if($info->delete()){
            Storage::delete($info->src);
        }
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
    }
}
