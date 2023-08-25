<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    public function index()
    {
        $res['list'] = Wishlist::where(['uuid'=>User::uuid()])->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        $product_ids = [];
        foreach ($res['list'] as $val){
            $product_ids[] = $val->product_id;
        }
        $res['productData'] = (new Product)->getByids($product_ids);
        foreach ($res['productData'] as $val){
            $val->image_src= UploadFile::getPath($val->image,$val->remote);
            $val->price= Currency::format($val->price);
            $val->special= $val->special?Currency::format($val->special):0;
            $val->discount= $val->discount?Currency::format($val->discount):0;
        }
        return $this->makeView('laravel-shop-front::account_ext.wishlist.index',['res'=>$res]);
    }

    public function product(Request $request){
        $uuid = User::uuid();
        if($uuid){
            $info = Wishlist::where(['uuid'=>$uuid,'product_id'=>$request->id])->first();
            if(!empty($info)){
                $info->delete();
                $count = Wishlist::where(['uuid'=>$uuid])->count();
                throw new ApiException(['code'=>0,'msg'=>'remove_success','data'=>['count'=>$count]]);
            }else{
                Wishlist::create(['product_id'=>$request->id,'uuid'=>$uuid]);
                $count = Wishlist::where(['uuid'=>$uuid])->count();
                throw new ApiException(['code'=>0,'msg'=>'add_success','data'=>['count'=>$count]]);
            }
        }else{
            $shop_wishlist = Cookie::get('shop_wishlist');
            if($shop_wishlist){
                $shop_wishlist_arr = json_decode($shop_wishlist,true);
                $key = array_search($request->id,$shop_wishlist_arr);
                if($key!==false){
                    unset($shop_wishlist_arr[$key]);
                }else{
                    $shop_wishlist_arr[] = $request->id;
                }
            }else{
                $shop_wishlist_arr = [$request->id];
            }
            $shop_wishlist_arr = array_unique($shop_wishlist_arr);
            Cookie::queue('shop_wishlist',json_encode($shop_wishlist_arr));
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['count'=>count($shop_wishlist_arr)]]);
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
