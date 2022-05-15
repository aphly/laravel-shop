<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $res['title'] = '';
        $res['list'] = Wishlist::where(['uuid'=>session('user')['uuid']])->orderBy('date_add','desc')->Paginate(config('shop.perPage'))->withQueryString();
        $product_ids = array_column($res['list'],'product_id');
        //$res['product'] = (new Product)->findAllIds($product_ids);
        return $this->makeView('laravel-shop::account.wishlist',['res'=>$res]);
    }

    public function product(Request $request){
        $info = Wishlist::where(['uuid'=>session('user')['uuid'],'product_id'=>$request->id])->first();
        if($info){
            $info->delete();
            throw new ApiException(['code'=>0,'msg'=>'remove_success']);
        }else{
            Wishlist::create(['product_id'=>$request->id,'uuid'=>session('user')['uuid']]);
            throw new ApiException(['code'=>0,'msg'=>'add_success']);
        }
    }


}
