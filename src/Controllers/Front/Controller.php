<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelCommon\Controllers\Front\Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $auth = Auth::guard('user');
            if($auth->check()){
            }else{
            }
            return $next($request);
        });
        parent::__construct();
    }

    public function afterController(){
        list($cart_num) = (new Cart)->countList();
        View::share("cart_num",$cart_num);
        $count = 0;
        if(User::uuid()){
            $wishlist = Wishlist::where(['uuid'=>User::uuid()]);
            $count = $wishlist->count();
            if($count){
                Wishlist::$product_ids = array_column($wishlist->get('product_id')->toArray(),'product_id');
            }
        }else{
            $shop_wishlist = Cookie::get('shop_wishlist');
            if($shop_wishlist){
                $shop_wishlist_arr = json_decode($shop_wishlist,true);
                $count = count($shop_wishlist_arr);
                if($count){
                    Wishlist::$product_ids = $shop_wishlist_arr;
                }
            }
        }
        View::share("wishlist_num",$count);
    }

}
