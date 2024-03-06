<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelShop\Models\Catalog\CategoryPath;
use Aphly\LaravelShop\Models\Catalog\Filter;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Option;
use Aphly\LaravelShop\Models\Catalog\OptionValue;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductAttribute;
use Aphly\LaravelShop\Models\Catalog\ProductCategory;
use Aphly\LaravelShop\Models\Catalog\ProductDesc;
use Aphly\LaravelShop\Models\Catalog\ProductDiscount;
use Aphly\LaravelShop\Models\Catalog\ProductFilter;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Catalog\ProductOption;
use Aphly\LaravelShop\Models\Catalog\ProductOptionValue;
use Aphly\LaravelShop\Models\Catalog\ProductSpecial;
use Aphly\LaravelShop\Models\Catalog\ProductVideo;
use Aphly\LaravelShop\Models\Catalog\ReviewImage;
use Aphly\LaravelShop\Models\Sale\ServiceImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $index_url='/shop_admin/product/index';

    private $currArr = ['name'=>'商品','key'=>'product'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['status'] = $request->query('status','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Product::when($res['search'],
            function($query,$search) {
                if($search['name']!==''){
                    $query->where('name', 'like', '%'.$search['name'].'%');
                }
                if($search['status']!==''){
                    $query->where('status', $search['status']);
                }
            })
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['list']->transform(function ($item){
            $item->image_src = UploadFile::getPath($item->image,$item->remote);
            return $item;
        });
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
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
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/shop_admin/'.$this->currArr['key'].'/add']
            ]);
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
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/shop_admin/'.$this->currArr['key'].'/edit?product_id='.$res['product']->id]
            ]);
            return $this->makeView('laravel-shop::admin.catalog.product.form',['res'=>$res]);
        }
    }

    public function form(Request $request)
    {
        $res['product'] = Product::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['product']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['product']->id?'/form?id='.$res['product']->id:'/form')]
        ]);
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
            ProductAttribute::whereIn('product_id',$post)->delete();
            ProductCategory::whereIn('product_id',$post)->delete();
            ProductDiscount::whereIn('product_id',$post)->delete();
            ProductFilter::whereIn('product_id',$post)->delete();
            $imgs = ProductImage::whereIn('product_id',$post)->get();
            foreach ($imgs as $img){
                if($img->delete()){
                    UploadFile::del($img->image,$img->remote);
                }
            }
            ProductOption::whereIn('product_id',$post)->delete();
            ProductOptionValue::whereIn('product_id',$post)->delete();
            ProductSpecial::whereIn('product_id',$post)->delete();
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
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'描述','href'=>'/shop_admin/'.$this->currArr['key'].'/desc?product_id='.$res['product']->id]
            ]);
            return $this->makeView('laravel-shop::admin.catalog.product.desc',['res'=>$res]);
        }
    }

    public function img(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $res['info_img'] = ProductImage::where('product_id',$res['product']->id)->orderBy('sort','desc')->get();
        if($request->isMethod('post')) {
            if($request->hasFile('file')) {
                $UploadFile = new UploadFile(5);
                $remote = $UploadFile->isRemote();
                $file_path = $UploadFile->uploads(20,$request->file('file'), 'public/shop/product/image');
                $img_src = $insertData = [];
                foreach ($file_path as $key=>$val) {
                    $img_src[] = UploadFile::getPath($val,$remote);
                    $insertData[] = ['product_id'=>$res['product']->id,'image'=>$val,'sort'=>-1,'remote'=>$remote];
                }
                if ($insertData) {
                    ProductImage::insert($insertData);
                    $this->updateImg($res['product']->id);
                    throw new ApiException(['code' => 0, 'msg' => '上传成功', 'data' => ['redirect' => '/shop_admin/product/img?product_id='.$res['product']->id,'imgs'=>$img_src]]);
                }
            }
            throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'图片','href'=>'/shop_admin/'.$this->currArr['key'].'/img?product_id='.$res['product']->id]
            ]);
            $res['info_img']->transform(function ($item){
                $item->image_src = UploadFile::getPath($item->image,$item->remote);
                return $item;
            });
            if($res['product']->is_color_group){
                $res['info_option_value'] = Option::where('is_color',1)->where('status',1)->with('value')->first();
            }else{
                $res['info_option_value'] = [];
            }
            return $this->makeView('laravel-shop::admin.catalog.product.img',['res'=>$res]);
        }
    }

    public function imgSave(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $post = $request->input('imgs');
        foreach ($post['sort'] as $k=>$v){
            ProductImage::find($k)->update(['sort'=>$v]);
        }
        foreach ($post['type'] as $k=>$v){
            ProductImage::find($k)->update(['type'=>$v]);
        }
        if(isset($post['option_value_id'])){
            foreach ($post['option_value_id'] as $k=>$v){
                ProductImage::find($k)->update(['option_value_id'=>$v]);
            }
        }
        $this->updateImg($res['product']->id);
        throw new ApiException(['code' => 0, 'msg' => '更新成功', 'data' => ['redirect' =>  '/shop_admin/product/img?product_id='.$res['product']->id]]);
    }

    public function imgDel(Request $request)
    {
        $info_obj = ProductImage::where('id',$request->id);
        $info = $info_obj->first();
        if($info_obj->delete()){
            UploadFile::del($info->image,$info->remote);
        }
        $this->updateImg($info->product_id);
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
    }

    public function updateImg($product_id){
        $productImg = ProductImage::where('product_id',$product_id)->orderBy('sort','desc')->first();
        if(!empty($productImg)){
            Product::find($productImg->product_id)->update(['image'=>$productImg->image,'remote'=>$productImg->remote]);
        }else{
            Product::where(['id'=>$product_id])->update(['image'=>'','remote'=>0]);
        }
    }

    public function video(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $res['info_video'] = ProductVideo::where('product_id',$res['product']->id)->orderBy('sort','desc')->get();
        if($request->isMethod('post')) {
            if($request->hasFile('file')) {
                $UploadFile = new UploadFile(10,['mp4']);
                $remote = $UploadFile->isRemote();
                $file_path = $UploadFile->uploads(1,$request->file('file'), 'public/shop/product/video');
                $video_src = $insertData = [];
                foreach ($file_path as $key=>$val) {
                    $video_src[] = UploadFile::getPath($val,$remote);
                    $insertData[] = ['product_id'=>$res['product']->id,'video'=>$val,'sort'=>-1,'remote'=>$remote];
                }
                if ($insertData) {
                    ProductVideo::insert($insertData);
                    throw new ApiException(['code' => 0, 'msg' => '上传成功', 'data' => ['redirect' => '/shop_admin/product/video?product_id='.$res['product']->id,'video'=>$video_src]]);
                }
            }
            throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'视频','href'=>'/shop_admin/'.$this->currArr['key'].'/video?product_id='.$res['product']->id]
            ]);
            $res['info_video']->transform(function ($item){
                $item->video_src = UploadFile::getPath($item->video,$item->remote);
                return $item;
            });
            return $this->makeView('laravel-shop::admin.catalog.product.video',['res'=>$res]);
        }
    }

    public function videoSave(Request $request)
    {
        $res['product'] = $this->getProductId($request);
        $post = $request->input('video');
        foreach ($post['sort'] as $k=>$v){
            ProductVideo::find($k)->update(['sort'=>$v]);
        }
        foreach ($post['type'] as $k=>$v){
            ProductVideo::find($k)->update(['type'=>$v]);
        }
        throw new ApiException(['code' => 0, 'msg' => '更新成功', 'data' => ['redirect' =>  '/shop_admin/product/video?product_id='.$res['product']->id]]);
    }

    public function videoDel(Request $request)
    {
        $info_obj = ProductVideo::where('id',$request->id);
        $info = $info_obj->first();
        if($info_obj->delete()){
            UploadFile::del($info->video,$info->remote);
        }
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
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
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'属性','href'=>'/shop_admin/'.$this->currArr['key'].'/attribute?product_id='.$res['product']->id]
            ]);
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
                    ProductOptionValue::upsert($product_option_value_update,['id'],['product_option_id','product_id','option_id','option_value_id','product_image_id','quantity','subtract','price','sort']);
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['product_option'] = ProductOption::where('product_id',$product_id)->with('value_arr')->orderBy('id','desc')->get()->toArray();
            $res['option'] = Option::with('value')->get()->keyBy('id')->toArray();
            $res['product_image'] = ProductImage::where('product_id',$product_id)->whereNot('type',1)->get()->keyBy('id');
            $res['product_image'] = $res['product_image']->map(function ($item){
                $item->image_src = UploadFile::getPath($item->image,$item->remote);
                return $item;
            });
            $res['product_image'] = $res['product_image']->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'选项','href'=>'/shop_admin/'.$this->currArr['key'].'/option?product_id='.$res['product']->id]
            ]);
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
            $res['filter'] = Filter::leftJoin('shop_filter_group as group','group.id','=','shop_filter.filter_group_id')
                ->whereIn('shop_filter.id', $filter_ids)
                ->selectRaw("shop_filter.*,concat(group.name,' \> ',shop_filter.name) as name_all")
                ->get()->keyBy('id')->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'链接','href'=>'/shop_admin/'.$this->currArr['key'].'/links?product_id='.$res['product']->id]
            ]);
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
            ProductSpecial::upsert($update,['id'],['product_id','price','date_start','date_end']);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            //$res['group'] = Group::get()->keyBy('id')->toArray();
            $res['product_special'] = ProductSpecial::where('product_id',$product_id)->get()->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'特价','href'=>'/shop_admin/'.$this->currArr['key'].'/special?product_id='.$res['product']->id]
            ]);
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
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>$res['product']->name],
                ['name'=>'批发价','href'=>'/shop_admin/'.$this->currArr['key'].'/discount?product_id='.$res['product']->id]
            ]);
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
        return Product::where('id',$request->input('product_id',0))->firstOrError();
    }

    function sync(Request $request){
        if($request->isMethod('post')) {
            $type = $request->input('type',[]);
            if (in_array('product',$type)) {
                Product::query()->update(['remote' => 1]);
                ProductImage::query()->update(['remote' => 1]);
            }else if(in_array('review',$type)){
                ReviewImage::query()->update(['remote' => 1]);
            }else if(in_array('service',$type)){
                ServiceImage::query()->update(['remote' => 1]);
            }else if(in_array('option',$type)){
                OptionValue::query()->update(['remote' => 1]);
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['title'] = '同步';
            return $this->makeView('laravel-shop::admin.catalog.product.sync',['res'=>$res]);
        }
    }
}
