<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $res['list'] = Wishlist::where(['uuid'=>User::uuid()])->with('product')->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-shop-front::account.wishlist',['res'=>$res]);
    }

    public function product(Request $request){
        $info = Wishlist::where(['uuid'=>User::uuid(),'product_id'=>$request->id])->first();
        if(!empty($info)){
            $info->delete();
            throw new ApiException(['code'=>0,'msg'=>'remove_success']);
        }else{
            Wishlist::create(['product_id'=>$request->id,'uuid'=>User::uuid()]);
            throw new ApiException(['code'=>0,'msg'=>'add_success']);
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
