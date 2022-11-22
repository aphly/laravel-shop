<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    public function index()
    {
        $res['list'] = Wishlist::where(['uuid'=>User::uuid()])->with('product')->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account_ext.wishlist_index',['res'=>$res]);
    }

    public function product(Request $request){
        $uuid = User::uuid();
        if($uuid){
            $info = Wishlist::where(['uuid'=>$uuid,'product_id'=>$request->id])->first();
            if(!empty($info)){
                $info->delete();
                throw new ApiException(['code'=>0,'msg'=>'remove_success']);
            }else{
                Wishlist::create(['product_id'=>$request->id,'uuid'=>$uuid]);
                throw new ApiException(['code'=>0,'msg'=>'add_success']);
            }
        }else{
            $arr = [$request->id];
            $shop_wishlist = Cookie::get('shop_wishlist');
            if($shop_wishlist){
                $shop_wishlist = json_decode($shop_wishlist,true);
                $arr = array_merge($arr,$shop_wishlist);
            }
            Cookie::queue('shop_wishlist',json_encode($arr));
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }
    }

    public function remove(Request $request){
        $info = Wishlist::where(['uuid'=>User::uuid(),'id'=>$request->id])->first();
        if(!empty($info)){
            $info->delete();
        }
        throw new ApiException(['code'=>0,'msg'=>'remove_success']);
    }

}
