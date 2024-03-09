<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelBlog\Models\User;
use Aphly\LaravelShop\Models\Setting\Currency;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Setting\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelBlog\Controllers\Front\Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next){
            return $next($request);
        });
        //dd(self::$_G);
    }

    public function afterController(){
        parent::$_G['shop_config'] = Config::findAll();
        View::share("shop_config",parent::$_G['shop_config']);
        parent::$_G['currency'] = (new Currency)->allDefaultCurr();
        if(isset(parent::$_G['currency'][2]) && !empty(parent::$_G['currency'][2]['timezone'])){
            date_default_timezone_set(parent::$_G['currency'][2]['timezone']);
        }
        View::share("currency",parent::$_G['currency']);
        list($cart_num) = (new Cart)->countList();
        View::share("cart_num",$cart_num);
        $count = 0;
        if(User::uuid()){
            $wishlist = Wishlist::where(['uuid'=>User::uuid()]);
            $count = $wishlist->count();
            if($count){
                Wishlist::$product_ids = array_column($wishlist->get('product_id')->toArray(),'product_id');
            }
            View::share("email",Auth::guard('user')->user()->initId());
        }else{
            $shop_wishlist = session('shop_wishlist');
            if($shop_wishlist){
                $shop_wishlist_arr = json_decode($shop_wishlist,true);
                $count = count($shop_wishlist_arr);
                if($count){
                    Wishlist::$product_ids = $shop_wishlist_arr;
                }
            }
            View::share("email",'');
        }
        View::share("wishlist_num",$count);
    }

}
