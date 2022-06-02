<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function category(Request $request)
    {
        //$res['title'] = '';
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
        $res['list'] = (new Product)->getList($filter_data);
        foreach ($res['list']->items() as $key=>$val){
            $res['list']->items()[$key]->price= Currency::format($res['list']->items()[$key]->price);
        }
        return $this->makeView('laravel-shop::front.product.category',['res'=>$res]);
    }

    public function detail(Request $request)
    {
        $res['info'] = Product::where('id',$request->id)->with('img')->with('desc')->first();
        if(!empty($res['info'])){
            $res['info_attr'] = $res['info']->findAttribute($res['info']->id);
            $res['info_special'] = $res['info']->findSpecial($res['info']->id);
            $res['info_reward'] = $res['info']->findReward($res['info']->id);
            $res['info_discount'] = $res['info']->findDiscount($res['info']->id);
            $res['info_option'] = $res['info']->findOption($res['info']->id,true);
        }
        return $this->makeView('laravel-shop::front.product.detail',['res'=>$res]);
    }



}
