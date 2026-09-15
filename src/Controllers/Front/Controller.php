<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelPayment\Models\Currency;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Setting\Config;
use Aphly\LaravelShop\Models\Setting\Ipv4;
use Illuminate\Pagination\Paginator;
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
            $salesperson_id = $request->query('salesperson_id',false);
            $sp_id = $request->query('sp_id',false);
            if($salesperson_id || $sp_id){
                session(['shop_salesperson_id' => $salesperson_id]);
            }

            if(config('shop.facebook_analytics')){
                $fb_code = <<<EOT
                    <!-- Meta Pixel Code -->
                    <script>
                    !function(f,b,e,v,n,t,s)
                    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                    n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s)}(window, document,'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                    fbq('init', '1944599702889203');
                    fbq('track', 'PageView');
                    </script>
                    <noscript><img height="1" width="1" style="display:none"
                    src="https://www.facebook.com/tr?id=1944599702889203&ev=PageView&noscript=1"
                    /></noscript>
                    <!-- End Meta Pixel Code -->
                EOT;

                View::share("Fb_Code",$fb_code);
                View::share("Fb_AddToCart","fbq('track', 'AddToCart');");
                View::share("Fb_InitiateCheckout","fbq('track', 'InitiateCheckout');");
                View::share("Fb_AddPaymentInfo","fbq('track', 'AddPaymentInfo');");
                View::share("Fb_Purchase","fbq('track', 'Purchase', {value: 1.00, currency: 'USD'});");
            }else{
                View::share("Fb_Code",'');
                View::share("Fb_AddToCart","");
                View::share("Fb_InitiateCheckout","");
                View::share("Fb_AddPaymentInfo","");
                View::share("Fb_Purchase","");
            }

            if(config('shop.google_analytics')){
                $Google_Code = <<<EOT
                    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DT0RF3XJTH"></script>
                    <script>
                        window.dataLayer = window.dataLayer || [];
                        function gtag(){dataLayer.push(arguments);}
                        gtag('js', new Date());
                        gtag('config', 'G-DT0RF3XJTH');
                    </script>
                EOT;
                View::share("Google_Code",$Google_Code);
            }else{
                View::share("Google_Code",'');
            }
            Paginator::defaultView('laravel-shop::front.common.pagination');
            return $next($request);
        });
    }

}
