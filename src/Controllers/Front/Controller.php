<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Support\Facades\Auth;
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
        list($cart_num) = (new Cart)->countProducts();
        View::share("cart_num",$cart_num);
    }

}
