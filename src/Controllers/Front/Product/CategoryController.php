<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        //$res['title'] = '';
        $category_info = Category::where('status',1)->where('id',$request->id)->first();

        if($category_info){
            $filter_data = [
                'category_id' => $category_info->id,
                'filter'      => $request->query('filter')
            ];
            $res['list'] = Product::where('status',1)->orderBy('date_add','desc')->Paginate(config('shop.perPage'))->withQueryString();

        }

        return $this->makeView('laravel-shop::front.product.category.index',['res'=>$res]);
    }


}
