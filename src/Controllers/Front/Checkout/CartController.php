<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $res['title'] = '';
        $cart = new Cart;
        $cart->initCart();
        $res['list'] = $cart->getProducts();
        $res['items'] = 0;
        if($res['list']){
            foreach ($res['list'] as $key=>$product) {
                $res['list'][$key]['product']['image_src'] = ProductImage::render($res['list'][$key]['product']['image'],true);
                $res['items'] += $product['quantity'];
            }
        }
        $res['total_data'] = $cart->totalData();
        return $this->makeView('laravel-shop-front::checkout.cart',['res'=>$res]);
    }

    public function add(Request $request)
    {
        $res['info'] = Product::where('id',$request->input('product_id',0))->where('status',1)->first();
        if(!empty($res['info'])){
            $quantity = (int)$request->input('quantity',1);
            $option = array_filter($request->input('option',[]));
            $product_options = $res['info']->findOption($res['info']->id);
            foreach ($product_options as $val) {
                if ($val['required']==1 && empty($option[$val['id']])) {
                    throw new ApiException(['code'=>1,'msg'=>$val['option']['name'].' required']);
                }
            }
            $cart = new Cart;
            $cart->add($res['info']->id, $quantity, $option);
            list($count,$list) = $cart->countProducts(true);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['count'=>$count,'list'=>$list]]);
        }
    }

    public function edit(Request $request)
    {
        $cartInfo = Cart::where(['id'=>$request->input('cart_id',0)])->firstOrError();
        $quantity = $request->input('quantity',1);
        $cartInfo->quantity = $quantity>1?$quantity:1;
        $cartInfo->save();
        throw new ApiException(['code'=>0,'msg'=>'success']);
    }

    public function addWishlist(Request $request)
    {
        $cartInfo = Cart::where(['id'=>$request->id])->firstOrError();
        $info = Wishlist::where(['uuid'=>User::uuid(),'product_id'=>$cartInfo->product_id])->first();
        if(empty($info)){
            Wishlist::create(['product_id'=>$cartInfo->product_id,'uuid'=>User::uuid()]);
        }
        $cartInfo->delete();
        throw new ApiException(['code'=>0,'msg'=>'success']);
    }

    public function coupon(Request $request)
    {
        $res['info'] = (new Coupon)->getCoupon($request->code);
        if(!empty($res['info'])){
            Cookie::queue('shop_coupon',$res['info']['code']);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            Cookie::queue('shop_coupon', null , -1);
            throw new ApiException(['code'=>1,'msg'=>'fail']);
        }
    }


}
