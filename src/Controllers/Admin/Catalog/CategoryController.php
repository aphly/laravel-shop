<?php

namespace Aphly\LaravelShop\Controllers\Admin\Catalog;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Common\CategoryPath;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $index_url='/shop-admin/category/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = CategoryPath::leftJoin('shop_category as c1','c1.id','=','shop_category_path.category_id')
            ->leftJoin('shop_category as c2','c2.id','=','shop_category_path.path_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('c1.name', 'like', '%'.$name.'%');
                })
            ->when($status,
                function($query,$status) {
                    return $query->where('c1.status', $status);
                })
            ->groupBy('category_id')
            ->selectRaw('any_value(shop_category_path.`category_id`) AS category_id,
                GROUP_CONCAT(c2.`name` ORDER BY shop_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->orderBy('c1.sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        //$res['fast_save'] = Category::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-shop::admin.catalog.category.index',['res'=>$res]);
    }

    public function show()
    {
        $data = Category::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        return $this->makeView('laravel-shop::admin.catalog.category.show',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $category = Category::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0),],$request->all());
        (new CategoryPath)->add($category->id,$category->pid);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop-admin/category/show']]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Category::where('pid',$post)->get();
            if($data->isEmpty()){
                Category::destroy($post);
                CategoryPath::whereIn('category_id',$post)->delete();
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的菜单','data'=>['redirect'=>$redirect]]);
            }
        }
    }

}