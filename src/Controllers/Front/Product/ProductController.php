<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Catalog\FilterGroup;
use Aphly\LaravelShop\Models\Catalog\Option;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\Review;
use Aphly\LaravelShop\Models\Catalog\ReviewImage;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $review_image_length = 4;

    private $review_image_size = 0.2;

    public function listData($filter_data,$res,$bySpu=false)
    {
        $product = new Product;
        $res['list'] = $product->getList($filter_data,$bySpu);
        $product_ids = [];
        foreach ($res['list'] as $key=>$val){
            $product_ids[] = $val->id;
            $val->image_src= UploadFile::getPath($val->image,$val->remote);
            $val->price= Currency::format($val->price);
            $val->special= $val->special?Currency::format($val->special):0;
            $val->discount= $val->discount?Currency::format($val->discount):0;
        }
        $res['product_option'] = $product->optionValueByName($product_ids);
        $res['product_image'] = $product->imgByIds($product_ids);
        $res['wishlist_product_ids'] = Wishlist::$product_ids;
        $res['sort'] = $product->sortArr();

        $res['price'] = $product->priceArr($this->currency[2]['symbol_left']);
        return $res;
    }

    public function index(Request $request)
    {
        $res['title'] = 'Index';
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>'Home','href'=>'/'],
            ['name'=>'All','href'=>''],
        ],false);
        $res['filter_data'] = $filter_data = [
            'name'      => $request->query('name',false),
            'category_id' => $request->query('category_id',false),
            'filter'      => $request->query('filter',false),
            'sort'      => $request->query('sort',false),
            'price'      => $request->query('price',false),
            'option_value'      => $request->query('option_value',false),
        ];
        $res['filte_filter'] = $filter_data['filter']?explode(',',$filter_data['filter']):[];
        $res['filte_option_value'] = $filter_data['option_value']?explode(',',$filter_data['option_value']):[];

        $res = $this->listData($filter_data,$res);
        if($filter_data['name'] && $res['list']->count()==1){
            return redirect('/product/'.$res['list'][0]->id);
        }
        $res['filterGroup'] = FilterGroup::where('status',1)->with('filter')->get();
        $res['option'] = Option::where(['status'=>1,'is_filter'=>1])->with('value')->get();
        return $this->makeView('laravel-shop-front::product.index',['res'=>$res]);
    }

    public function detail(Request $request)
    {
        $res['title'] = 'Detail';
        $res['info'] = Product::where('id',$request->id)->where('status',1)->where('date_available','<',time())->with('desc')->firstOr404();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>'Home','href'=>'/'],
            ['name'=>$res['info']->name,'href'=>'']
        ],false);
        $res['quantityInCart'] = (new Cart)->quantityInCart($request->id);
        list($res['info']->price,$res['info']->price_format) = Currency::format($res['info']->price,2);
        $res['info_img'] = $res['info']->imgById($res['info']->id);
        $group_id = User::groupId();
        $res['info_attr'] = $res['info']->findAttribute($res['info']->id);
        $res['info_option'] = $res['info']->findOption($res['info']->id,true);
        list($res['special_price'],$res['special_price_format']) = $res['info']->findSpecial($res['info']->id);
        $res['info_discount'] = $res['info']->findDiscount($res['info']->id);
        $res['info_reward'] = $res['info']->findReward($res['info']->id,$group_id);
        //$res['shipping'] = Shipping::where('cost',0)->firstToArray();
        $res['wishlist_product_ids'] = Wishlist::$product_ids;
        $res['review'] = Review::where('product_id',$res['info']->id)->with('img')->orderBy('created_at','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['reviewRatingAvg'] = Review::where('product_id',$res['info']->id)->avg('rating');
        $res['reviewRatingAvg'] = intval($res['reviewRatingAvg']*10)/10;
        $res['reviewRatingAvg_100'] = $res['reviewRatingAvg']/5*100;
        foreach ($res['review'] as $val){
            foreach ($val->img as $v){
                $v->image_src = UploadFile::getPath($v->image,$v->remote);
            }
        }
        $res['review_image_length'] = $this->review_image_length;
        $res['review_image_size'] = $this->review_image_size;

        return $this->makeView('laravel-shop-front::product.detail',['res'=>$res]);
    }

    public function reviewAdd(Request $request)
    {
        $input = $request->all();
        if(empty($input['text'])){
            throw new ApiException(['code'=>1,'msg'=>'Content cannot be empty']);
        }
//        $count = Review::where(['uuid'=>$this->user->uuid,'product_id'=>$request->id])->count();
//        if($count>0){
//            throw new ApiException(['code'=>1,'msg'=>'A product can only be evaluated once']);
//        }
//        $orderProductCount = OrderProduct::leftJoin('shop_order','shop_order.id','=','shop_order_product.order_id')->where(['shop_order.uuid'=>$this->user->uuid,'shop_order_product.product_id'=>$request->id])->count();
//        if(!$orderProductCount){
//            throw new ApiException(['code'=>2,'msg'=>'Only after purchasing the product can you evaluate it']);
//        }

        $insertData = $img_src = $file_paths =  [];
        $UploadFile = new UploadFile($this->review_image_size);
        $remote = $UploadFile->isRemote();
        if($request->hasFile("files")){
            $file_paths= $UploadFile->uploads($this->review_image_length,$request->file("files"), 'public/shop/product/review');
        }
        $input['author'] = $this->user->nickname;
        $input['uuid'] = $this->user->uuid;
        $input['product_id'] = $request->id;
        $review = Review::create($input);
        if($review->id){
            foreach ($file_paths as $v){
                $img_src[] = Storage::url($v);
                $insertData[] = ['review_id'=>$review->id,'image'=>$v,'remote'=>$remote];
            }
            if ($insertData) {
                ReviewImage::insert($insertData);
                throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['imgs'=>$img_src,'review'=>$review->toArray()]]);
            }
        }
        throw new ApiException(['code'=>0,'msg'=>'success']);
    }

}
