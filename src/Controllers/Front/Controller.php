<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelBlog\Models\User;
use Aphly\LaravelShop\Models\Setting\Currency;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Setting\Config;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelBlog\Controllers\Front\Controller
{
    public $shop_config = [];

    public $currency = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            return $next($request);
        });
        parent::__construct();
    }

    public function afterController(){
        $this->shop_config = Config::findAll();
        View::share("shop_config",$this->shop_config);
        $this->currency = (new Currency)->allDefaultCurr();
        if(isset($this->currency[2]) && !empty($this->currency[2]['timezone'])){
            date_default_timezone_set($this->currency[2]['timezone']);
        }
        View::share("currency",$this->currency);
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
            $shop_wishlist = session('shop_wishlist');
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
