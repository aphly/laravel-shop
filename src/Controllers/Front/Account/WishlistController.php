<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Account\CustomerWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $res['title'] = '';
        $res['user'] = session('user');
        $res['list'] = CustomerWishlist::where(['uuid'=>Auth::guard('user')->user()->uuid])->Paginate(config('shop.perPage'))->withQueryString()->toArray();
        return $this->makeView('laravel-shop::account.wishlist',['res'=>$res]);
    }


    public function add(Request $request){

    }

}
