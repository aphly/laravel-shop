<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelCommon\Models\Category;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function category(Request $request)
    {
        $res['title'] = '';
        $category_info = Category::where('status',1)->where('id',$request->query('id',0))->first();
        if(!empty($category_info)){
            $filter_data = [
                'category_id' => $category_info->id,
                'filter'      => $request->query('filter',false),
                'name'      => $request->query('name',false),
                'sort'      => $request->query('sort',false),
            ];
        }else{
            $filter_data = [
                'name'      => $request->query('name',false),
                'sort'      => $request->query('sort',false),
            ];
        }
        $product = new Product;
        $res['list'] = $product->getList($filter_data);

        $product_ids = [];
        foreach ($res['list'] as $key=>$val){
            $product_ids[] = $val->id;
            $val->image_src= ProductImage::render($val->image,true);
            $val->price= Currency::format($val->price);
            $val->special= $val->special?Currency::format($val->special):0;
            $val->discount= $val->discount?Currency::format($val->discount):0;
        }
        $res['product_option'] = $product->optionValueByName($product_ids);
        $res['product_image'] = $product->imgByIds($product_ids);
        $res['wishlist_product_ids'] = Wishlist::$product_ids;
        return $this->makeView('laravel-shop-front::product.category',['res'=>$res]);
    }


    public function detail(Request $request)
    {
        $res['title'] = '';
        $res['info'] = Product::where('id',$request->id)->with('desc')->firstOrError();
        $res['quantityInCart'] = (new Cart)->quantityInCart($request->id);
        list($res['info']->price,$res['info']->price_format) = Currency::format($res['info']->price,2);
        $res['info_img'] = $res['info']->imgById($res['info']->id);
        $group_id = User::groupId();
        $res['info_attr'] = $res['info']->findAttribute($res['info']->id);
        $res['info_option'] = $res['info']->findOption($res['info']->id,true);
        list($res['special_price'],$res['special_price_format']) = $res['info']->findSpecial($res['info']->id);
        $res['info_discount'] = $res['info']->findDiscount($res['info']->id);
        $res['info_reward'] = $res['info']->findReward($res['info']->id,$group_id);
        $res['shipping'] = Shipping::where('cost',0)->firstToArray();
        $res['wishlist_product_ids'] = Wishlist::$product_ids;
        return $this->makeView('laravel-shop-front::product.detail',['res'=>$res]);
    }



}
