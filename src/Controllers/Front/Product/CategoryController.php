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
        $category_info = Category::where('status',1)->where('id',$request->query('id',0))->first();
        if(!$category_info){
            return abort(404);
        }
        $filter_data = [
            'category_id' => $category_info->id,
            'filter'      => $request->query('filter',false),
            'name'      => $request->query('name',false),
            'sort'      => $request->query('sort',false),
        ];
        $res['list'] = (new Product)->getProducts($filter_data);

        return $this->makeView('laravel-shop::front.product.category.index',['res'=>$res]);
    }


}
