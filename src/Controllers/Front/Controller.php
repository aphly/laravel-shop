<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelPayment\Models\Currency;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Setting\Config;
use Aphly\LaravelShop\Models\Setting\Ipv4;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\Laravel\Controllers\Front\Controller
{
    public $shop_config= [];

    public $currency= [];

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next){
            $this->shop_config = Config::findAll();
            View::share("shop_config",$this->shop_config);
            $currency = (new Currency)->allDefaultCurr();
            $this->currency = $currency;
//            $ipv4 = ip2long($request->ip());
//            $ipv4_lib = Ipv4::where('ip_start_int','<=',$ipv4)->where('ip_end_int','>=',$ipv4)->first();
//            if(!empty($ipv4_lib)){
//                date_default_timezone_set($currency[2]['timezone']);
//            }
            View::share("currency",$currency);
            list($cart_num) = (new Cart)->countList();
            View::share("cart_num",$cart_num);
            $count = 0;
            if(CommonUser::uid()){
                $wishlist = Wishlist::where(['uid'=>CommonUser::uid()]);
                $count = $wishlist->count();
                if($count){
                    Wishlist::$product_ids = array_column($wishlist->get('product_id')->toArray(),'product_id');
                }
                View::share("email",CommonUser::getEmail());
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
            return $next($request);
        });
    }

}
