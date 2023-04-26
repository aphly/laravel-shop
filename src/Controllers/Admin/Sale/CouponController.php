<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\CategoryPath;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Aphly\LaravelShop\Models\Catalog\CouponCategory;
use Aphly\LaravelShop\Models\Catalog\CouponHistory;
use Aphly\LaravelShop\Models\Catalog\CouponProduct;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public $index_url='/shop_admin/coupon/index';

    private $currArr = ['name'=>'优惠券','key'=>'coupon'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Coupon::when($res['search']['name'],
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.sale.coupon.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $coupon_id = $request->query('id',0);
        $res['coupon'] = Coupon::where('id',$coupon_id)->firstOrNew();
        $res['coupon_category'] = CouponCategory::where('coupon_id',$coupon_id)->get()->toArray();
        $category_ids = array_column($res['coupon_category'],'category_id');
        $res['category'] = (new CategoryPath)->getByIds($category_ids);
        $res['coupon_product'] = CouponProduct::where('coupon_id',$coupon_id)->get()->toArray();
        $product_ids = array_column($res['coupon_product'],'product_id');
        $res['product'] = Product::whereIn('id',$product_ids)->select('name','id')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['coupon']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['coupon']->id?'/form?id='.$res['coupon']->id:'/form')]
        ]);
        return $this->makeView('laravel-shop::admin.sale.coupon.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['date_add'] = $input['date_add']??time();
        $input['date_start'] = $input['date_start']?strtotime($input['date_start']):0;
        $input['date_end'] = $input['date_end']?strtotime($input['date_end']):0;
        $coupon = Coupon::updateOrCreate(['id'=>$request->query('id',0)],$input);
        CouponCategory::where('coupon_id',$coupon->id)->delete();
        $coupon_category = $request->input('coupon_category',[]);
        if($coupon_category){
            $update_arr = [];
            foreach ($coupon_category as $val){
                $update_arr[] = ['category_id'=>$val,'coupon_id'=>$coupon->id];
            }
            CouponCategory::insert($update_arr);
        }
        CouponProduct::where('coupon_id',$coupon->id)->delete();
        $coupon_product = $request->input('coupon_product',[]);
        if($coupon_product){
            $update_arr = [];
            foreach ($coupon_product as $val){
                $update_arr[] = ['product_id'=>$val,'coupon_id'=>$coupon->id];
            }
            CouponProduct::insert($update_arr);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Coupon::whereIn('id',$post)->delete();
            CouponProduct::whereIn('coupon_id',$post)->delete();
            CouponCategory::whereIn('coupon_id',$post)->delete();
            CouponHistory::whereIn('coupon_id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function history(Request $request)
    {
        $res['info'] = Coupon::where('id',$request->query('id',0))->firstOrError();
        $res['list'] = CouponHistory::where('coupon_id',$res['info']->id)->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'历史记录','href'=>'/shop_admin/'.$this->currArr['key'].'/history?id='.$res['info']->id]
        ]);
        return $this->makeView('laravel-shop::admin.sale.coupon.history',['res'=>$res]);
    }

}
