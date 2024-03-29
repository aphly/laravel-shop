<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Libs\Math;
use Aphly\Laravel\Models\Model;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon';
    //public $timestamps = false;

    protected $fillable = [
        'name','code','type','discount','free_shipping','total','date_start','date_end','uses_total',
        'uses_customer','status'
    ];

    public function getCoupon($code) {
        $status = true;
        $time = time();
        $product_data = [];
        $info = self::where('code',$code)->where(function ($query) use ($time){
                    $query->where('date_start',0)->orWhere('date_start','<',$time);
                })->where(function ($query) use ($time){
                    $query->where('date_end',0)->orWhere('date_end','>',$time);
                })->where('status',1)->first();
        if(!empty($info)){
        	$cart = new Cart;
            if($info->total > $cart->getSubTotal()){
                $status = false;
            }
            $coupon_total = $this->getCouponHistoriesByCoupon($code);
            if ($info['uses_total'] > 0 && ($coupon_total >= $info['uses_total'])) {
                $status = false;
            }

            if(User::uuid()){
                $customer_total = $this->getCouponHistoriesByUuId($code, User::uuid());
                if ($info['uses_customer'] > 0 && ($customer_total >= $info['uses_customer'])) {
                    $status = false;
                }
            }

            // Products
            $coupon_product = CouponProduct::where('coupon_id',$info['id'])->get()->toArray();
            $coupon_product_data = array_column($coupon_product,'product_id');

            $productCategoryAll = [];
            $coupon_category_query = CouponCategory::leftJoin('shop_category_path','shop_coupon_category.category_id','=','shop_category_path.path_id')
                                    ->where('shop_coupon_category.coupon_id',$info['id'])->get()->toArray();
            $coupon_category_data = array_column($coupon_category_query,'category_id');

            if($coupon_product_data || $coupon_category_data){
                if($coupon_category_data){
                    $productCategoryAll = ProductCategory::whereIn('category_id',$coupon_category_data)->get()->toArray();
                    $productCategoryAll = array_column($productCategoryAll,'product_id');
                }
                $productAll = array_unique(array_merge($coupon_product_data,$productCategoryAll));
                if ($productAll) {
                    foreach ($cart->getList() as $product) {
                        if (in_array($product['product_id'], $productAll)) {
                            $product_data[$product['product_id']] = $product['product_id'];
                        }
                    }
                }
                if(!$product_data){
                    $status=false;
                }
            }

        }else{
            $status=false;
        }
        if($status){
            $arr = $info->toArray();
            $arr['product'] = $product_data;
            return $arr;
        }else{
            return [];
        }
    }

    public function getTotal($total_data) {
        $cart_ext = [];
        $coupon = session('shop_coupon');
        if($coupon){
            $info = $this->getCoupon($coupon);
            if($info) {
				$cart = new Cart;
				if($info['free_shipping']==1){
                    Cart::$free_shipping = true;
                }
                $discount_total = 0;
                if (!$info['product']) {
                    $sub_total = $cart->getSubTotal();
                } else {
                    $sub_total = 0;
                    foreach ($cart->getList() as $product) {
                        if (in_array($product['product_id'], $info['product'])) {
                            //$sub_total += $product['total'];
                            $sub_total = Math::add($sub_total,$product['total']);
                        }
                    }
                }
                if ($info['type'] == 2) {
                    $info['discount'] = min($info['discount'], $sub_total);
                    $info['discount'] = Currency::format($info['discount'],1);
                }

                foreach ($cart->getList() as $key=>$product) {
                    $discount = 0;
                    if (!$info['product']) {
                        $status = true;
                    } else {
                        $status = in_array($product['product_id'], $info['product']);
                    }
                    if ($status) {
                        if ($info['type'] == 2) {
                            //$discount = $info['discount'] * ($product['total'] / $sub_total);
                            $discount = Math::mul($info['discount'],Math::div($product['total'],$sub_total));
                        } elseif ($info['type'] == 1) {
                            //$discount = $product['total'] / 100 * $info['discount'];
                            $discount = Math::mul(Math::div($product['total'],100),$info['discount']);
                        }
                    }
                    //$discount = Currency::numberFormat($discount);
                    //$discount_total += $discount;
                    $discount_total = Math::add($discount_total,$discount);
                    $cart_ext[$key]['discount'] = $discount;
                    $cart_ext[$key]['discount_format'] = Currency::_format($discount);
                    //$real_total = $product['total'] - $discount;
                    $real_total = Math::sub($product['total'],$discount);
                    $cart_ext[$key]['real_total'] = $real_total;
                    $cart_ext[$key]['real_total_format'] = Currency::_format($real_total);
                }

                if ($discount_total > $total_data['total']) {
                    $discount_total = $total_data['total'];
                    foreach ($cart->getList() as $key=>$product) {
                        $cart_ext[$key]['discount'] = $product['total'];
                        $cart_ext[$key]['discount_format'] = Currency::_format($product['total']);
                        $cart_ext[$key]['real_total'] = 0;
                        $cart_ext[$key]['real_total_format'] = Currency::_format(0);
                    }
                }

                if ($discount_total > 0) {
                    $total_data['totals']['coupon'] = array(
                        'title'      => 'Coupon',
                        'value'      => $discount_total,
                        'value_format' => '-'.Currency::_format($discount_total),
                        'sort_order' => 2,
                        'ext' => $coupon
                    );
                    //$total_data['total'] -= $discount_total;
                    $total_data['total'] = Math::sub($total_data['total'],$discount_total);
                }
            }
        }
        return $cart_ext;
    }

    public function getCouponHistoriesByCoupon($coupon) {
        return CouponHistory::leftJoin('shop_coupon','shop_coupon.id','=','shop_coupon_history.coupon_id')->where('shop_coupon.code',$coupon)->count();
    }

    public function getCouponHistoriesByUuId($coupon,$uuid) {
        return CouponHistory::leftJoin('shop_coupon','shop_coupon.id','=','shop_coupon_history.coupon_id')->where('shop_coupon.code',$coupon)
            ->where('shop_coupon_history.uuid',$uuid)->count();
    }


}
