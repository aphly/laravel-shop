<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelCommon\Models\Category;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Catalog\Product;
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
        $res['list'] = (new Product)->getList($filter_data);
        foreach ($res['list']->items() as $key=>$val){
            $res['list']->items()[$key]->price= Currency::format($res['list']->items()[$key]->price);
            $res['list']->items()[$key]->special= Currency::format($res['list']->items()[$key]->special);
            $res['list']->items()[$key]->discount= Currency::format($res['list']->items()[$key]->discount);
        }
        return $this->makeView('laravel-shop-front::product.category',['res'=>$res]);
    }

    public function detail(Request $request)
    {
        $res['title'] = '';
        $res['info'] = Product::where('id',$request->id)->with('img')->with('desc')->first();
        $res['info']->price = Currency::format($res['info']->price);
        if(!empty($res['info'])){
            $group_id = User::groupId();
            $res['info_attr'] = $res['info']->findAttribute($res['info']->id);
            $res['info_option'] = $res['info']->findOption($res['info']->id,true);
            $res['info_special'] = $res['info']->findSpecial($res['info']->id);
            $res['info_reward'] = $res['info']->findReward($res['info']->id,$group_id);
            $res['info_discount'] = $res['info']->findDiscount($res['info']->id);
        }
        return $this->makeView('laravel-shop-front::product.detail',['res'=>$res]);
    }



}
