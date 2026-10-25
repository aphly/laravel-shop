<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\CommonUploadFile;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Review;
use Aphly\LaravelShop\Models\Account\ReviewImage;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Catalog\Category;
use Aphly\LaravelShop\Models\Catalog\FilterGroup;
use Aphly\LaravelShop\Models\Catalog\Option;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductDiscount;
use Aphly\LaravelShop\Models\Catalog\ProductSpecial;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelPayment\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $review_image_length = 4;

    private $review_image_size = 1;

    public function listData($filter_data,$res,$bySpu=false)
    {
        $product = new Product;
        $res['list'] = $product->getList($filter_data,$bySpu);
        $product_ids = [];
        $res['list']->transform(function ($item) use (&$product_ids){
            $product_ids[] = $item->id;
            $item->image_src= CommonUploadFile::getPath($item->image,$item->disk);
            if($item->special && floatval($item->price)){
                $item->special_off = 100-intval(floatval($item->special)/floatval($item->price)*100);
                $item->special= Currency::format($item->special);
            }else{
                $item->special= 0;
                $item->special_off = 0;
            }
            $item->price= Currency::format($item->price);
            $item->discount= $item->discount?Currency::format($item->discount):0;
            return $item;
        });
        $res['product_option'] = $product->optionValueColor($product_ids);

        //dd($res['product_option']);
        //$res['product_image'] = $product->imgByIds($product_ids);
        $res['product_option_value_image'] = [];
        foreach ($res['product_option'] as $val){
            foreach ($val['product_option_value'] as $v){
                if(!empty($v['product_image_id'])){
                    $res['product_option_value_image'][$val['product_id']][$v['product_image_id']] = $v['product_image']['image_src'];
                }
            }
        }
        $res['wishlist_product_ids'] = Wishlist::$product_ids;
        $res['sort'] = $product->sortArr();
        $res['price'] = $product->priceArr($this->currency[2]['symbol_left']);
        return $res;
    }

    public function index(Request $request)
    {
        $res['title'] = 'Index';
        $res['filter_data'] = $filter_data = [
            'name'      => $request->query('name',false),
            'sku'      => $request->query('sku',false),
            'category_id' => $request->query('category_id',false),
            'filter'      => $request->query('filter',false),
            'sort'      => $request->query('sort','new_desc'),
            'price'      => $request->query('price',false),
            'option_value'      => $request->query('option_value',false),
        ];
        if($filter_data['category_id']){
            $cate = Category::where('id',$filter_data['category_id'])->first();
            if(!$cate){
                return redirect('/product');
            }
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>'Home','href'=>'/'],
                ['name'=>$cate->name,'href'=>''],
            ],false);
            if(!empty($cate->meta_title)){
                $res['title'] = $cate->meta_title;
            }else{
                $res['title'] = $cate->name;
            }
            $res['description'] = $cate->meta_description;
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>'Home','href'=>'/'],
                ['name'=>'All','href'=>''],
            ],false);
        }
        $res['filte_filter'] = $filter_data['filter']?explode(',',$filter_data['filter']):[];
        $res['filte_option_value'] = $filter_data['option_value']?explode(',',$filter_data['option_value']):[];

        $res = $this->listData($filter_data,$res);
        if($filter_data['name'] && $res['list']->count()==1){
            return redirect('/product/'.$res['list'][0]->id);
        }
        $res['filterGroup'] = FilterGroup::where('status',1)->with('filter')->get();
        $res['option'] = Option::where(['status'=>1,'is_filter'=>1])->with('value')->get();
        return $this->makeView(config('shop.pre').'::front.product.index',['res'=>$res]);
    }

    public function detail(Request $request)
    {
        $res['info'] = Product::where('id', $request->id)->where('status', 1)->where('date_available', '<', time())->with('desc')->firstOr404();
        $res['info']->image_src= CommonUploadFile::getPath($res['info']->image,$res['info']->disk);
        $res['title'] = $res['info']->name;
        if($res['info']->desc){
            $res['description'] = $res['info']->desc->meta_description;
        }
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>'Home','href'=>'/'],
            ['name'=>$res['info']->name,'href'=>'']
        ],false);
        $res['quantityInCart'] = (new Cart)->quantityInCart($request->id);
        $res['info']->price_format = Currency::format($res['info']->price);
        $res['color'] = $request->query('color',0);
            //$group_id = CommonUser::groupId();
        $res['info_attr'] = $res['info']->findAttribute($res['info']->id);
        $res['info_category'] = $res['info']->findCategory($res['info']->id);
        $res['info_option'] = $res['info']->findOption($res['info']->id,true);
        list($res['special_price'],$res['special_price_format']) = $res['info']->findSpecial($res['info']->id);
        if($res['special_price'] && floatval($res['info']->price)){
            $res['special_off'] =  100-intval(floatval($res['special_price'])/floatval($res['info']->price)*100);
        }else{
            $res['special_off'] = 0;
        }

        $res['info_discount'] = $res['info']->findDiscount($res['info']->id);
        $res['info_img'] = $res['info']->imgById($res['info']->id,$res['info']->is_color_group);
        $res['info_video'] = $res['info']->videoById($res['info']->id);

        //$res['info_reward'] = $res['info']->findReward($res['info']->id,$group_id);
        //$res['shipping'] = Shipping::where('cost',0)->firstToArray();
        $res['wishlist_product_ids'] = Wishlist::$product_ids;

        $res['reviewRatingAvg'] = Review::where('product_id',$res['info']->id)->avg('rating');
        $res['reviewRatingAvg'] = intval($res['reviewRatingAvg']*10)/10;
        $res['reviewRatingAvg_100'] = $res['reviewRatingAvg']/5*100;

        $res['review_image_length'] = $this->review_image_length;
        $res['review_image_size'] = $this->review_image_size;

        $res['rand'] = Cache::remember('rand_'.$res['info']->id,7200, function () use ($res) {
            $time = time();
            $rand= DB::table('shop_product as p')->where('status',1)->whereNot('id',$res['info']->id)->where('date_available','<',time())
                ->inRandomOrder()->select('p.id','p.sale','p.viewed','p.date_available','p.price','p.name','p.quantity','p.image',
                    'p.spu','p.sku','p.disk','p.is_color_group')
                ->addSelect([
                    'special'=>ProductSpecial::whereColumn('product_id','p.id')
                        ->where(function ($query) use ($time){
                            $query->where('date_start',0)->orWhere('date_start','<',$time);
                        })->where(function ($query) use ($time){
                            $query->where('date_end',0)->orWhere('date_end','>',$time);
                        })->orderBy('priority','desc')
                        ->select('price')->limit(1),
                    'discount'=>ProductDiscount::whereColumn('product_id','p.id')
                        ->where('quantity',1)
                        ->select('price')->limit(1)
                ])->limit(12)->get();
            $rand->transform(function ($item) use (&$product_ids){
                $item->image_src= CommonUploadFile::getPath($item->image,$item->disk);
                if($item->special && floatval($item->price)){
                    $item->special_off = 100-intval(floatval($item->special)/floatval($item->price)*100);
                    $item->special= Currency::format($item->special);
                }else{
                    $item->special= 0;
                    $item->special_off = 0;
                }
                $item->price= Currency::format($item->price);
                $item->discount= $item->discount?Currency::format($item->discount):0;
                return $item;
            });
            return json_decode(json_encode($rand), true);
        });

        $res['shippingFreeCost'] = (new Shipping)->getFree();
        return $this->makeView(config('shop.pre').'::front.product.detail',['res'=>$res]);
    }

    public function reviewAjax(Request $request)
    {
        $res['info'] = Product::where('id', $request->id)->where('status', 1)->where('date_available', '<', time())->first();
        if(empty($res['info'])){
            throw new ApiException(['code'=>1,'msg'=>'The product does not exist.']);
        }
        $list = [];
        $reviewSql = Review::where('product_id',$res['info']->id)->where('status',1);
        $count = $reviewSql->count();
        if($count){
            $list = $reviewSql->with('img')->with('user')->orderBy('created_at','desc')
                ->Paginate(1, ['*'], 'page', $request->query('page'));
            $list->transform(function ($item) {
                $item->avatar_src = CommonUploadFile::getPath($item->user->avatar,$item->user->disk,false);
                if(!$item->avatar_src){
                    $item->avatar_css = substr($item->author, 0, 1);
                }
                foreach ($item->img as $v){
                    $v->image_src = CommonUploadFile::getPath($v->image,$v->disk);
                }
                $item->timestamp = $item->created_at->timestamp;
                $item->rating_20 = $item->rating*20;
                $item->user = [];
                return $item;
            });
            $list = $list->toArray();
        }
        throw new ApiException(['code'=>0,'msg'=>'ok','data'=>['list'=>$list]]);
    }

    public function reviewAdd(Request $request)
    {
        $input = $request->all();
        if(empty($input['text'])){
            throw new ApiException(['code'=>1,'msg'=>'Content cannot be empty']);
        }

        if($this->shop_config['review_limit']){
//            $count = Review::where(['uid'=>$this->user->uid,'product_id'=>$request->id])->count();
//            if($count>0){
//                throw new ApiException(['code'=>1,'msg'=>'The product can only be reviewed once']);
//            }
//            $orderProductCount = OrderProduct::leftJoin('shop_order','shop_order.id','=','shop_order_product.order_id')->where(['shop_order.uid'=>$this->user->uid,'shop_order_product.product_id'=>$request->id])->count();
//            if(!$orderProductCount){
//                throw new ApiException(['code'=>2,'msg'=>'Only after purchasing the product can you comment on it']);
//            }
            $input['status'] = 0;
        }

        $insertData = $img_src = $file_paths =  [];
        $UploadFile = new CommonUploadFile($this->review_image_size);
        $disk = $UploadFile->disk();
        if($request->hasFile("files")){
            $file_paths= $UploadFile->uploads($this->review_image_length,$request->file("files"), 'public/shop/product/review');
        }
        $input['id'] = app('Snowflake')->nextId();
        $input['author'] = $this->user->nickname;
        $input['uid'] = $this->user->uid;
        $input['product_id'] = $request->id;
        $review = Review::create($input);
        if($review->id){
            foreach ($file_paths as $v){
                $img_src[] = CommonUploadFile::getPath($v,$disk);
                $insertData[] = ['review_id'=>$review->id,'image'=>$v,'disk'=>$disk];
            }
            if ($insertData) {
                ReviewImage::insert($insertData);
                throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['imgs'=>$img_src,'review'=>$review->toArray()]]);
            }
        }
        throw new ApiException(['code'=>0,'msg'=>'success']);
    }

}
