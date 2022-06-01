<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\LaravelShop\Models\Account\Customer;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Product\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cookie;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon';
    public $timestamps = false;

    protected $fillable = [
        'name','code','type','discount','is_login',
        'shipping','total','date_start','date_end','uses_total',
        'uses_customer','status','date_add'
    ];

    public function __construct(public array $cart_products=[])
    {
        parent::__construct();
    }

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
            if($info->total > (new Cart)->getSubTotal($this->cart_products)){
                $status = false;
            }
            $coupon_total = $this->getCouponHistoriesByCoupon($code);
            if ($info['uses_total'] > 0 && ($coupon_total >= $info['uses_total'])) {
                $status = false;
            }
            if ($info['is_login'] && !Customer::uuid()) {
                $status = false;
            }
            if(Customer::uuid()){
                $customer_total = $this->getCouponHistoriesByUuId($code, Customer::uuid());
                if ($info['uses_customer'] > 0 && ($customer_total >= $info['uses_customer'])) {
                    $status = false;
                }
            }

            // Products
            $coupon_product_data = [];
            $coupon_product = CouponProduct::where('coupon_id',$info['id'])->get()->toArray();
            foreach ($coupon_product as $product) {
                $coupon_product_data[] = $product['product_id'];
            }

            $coupon_category_data = [];
            $coupon_category_query = CouponCategory::leftJoin('shop_category_path','shop_coupon_category.category_id','=','shop_category_path.path_id')->where('shop_coupon_category.coupon_id',$info['id'])->get()->toArray();
            foreach ($coupon_category_query as $category) {
                $coupon_category_data[] = $category['category_id'];
            }

            if ($coupon_product_data || $coupon_category_data) {
                foreach ($this->cart_products as $product) {
                    if (in_array($product['product_id'], $coupon_product_data)) {
                        $product_data[$product['product_id']] = $product['product_id'];
                        continue;
                    }
                    $productCategory = ProductCategory::where('product_id',$product['product_id'])->get()->toArray();
                    $productCategory = array_column($productCategory,'category_id');
                    if($productCategory){
                        foreach ($coupon_category_data as $category_id) {
                            if (in_array($category_id,$productCategory)) {
                                $product_data[$product['product_id']] = $product['product_id'];
                                continue;
                            }
                        }
                    }

                }
                if (!$product_data) {
                    $status = false;
                }
            }
        }else{
            $status=false;
        }
        if($status){
            $arr = $info->toArray();
            $arr['product'] = $product_data;
            return $arr;
        }
    }

    public function getTotal($total_data) {
        $coupon = Cookie::get('coupon');
        if($coupon){
            $info = $this->getCoupon($coupon);
            if($info) {
                $discount_total = 0;
                if (!$info['product']) {
                    $sub_total = (new Cart)->getSubTotal($this->cart_products);
                } else {
                    $sub_total = 0;
                    foreach ($this->cart_products as $product) {
                        if (in_array($product['product_id'], $info['product'])) {
                            $sub_total += $product['total'];
                        }
                    }
                }
                if ($info['type'] == 'F') {
                    $info['discount'] = min($info['discount'], $sub_total);
                }
            }
        }
        return 12;
    }

    public function getCouponHistoriesByCoupon($coupon) {
        return CouponHistory::leftJoin('shop_coupon','shop_coupon.id','=','shop_coupon_history.coupon_id')->where('shop_coupon.code',$coupon)->count();
    }

    public function getCouponHistoriesByUuId($coupon,$uuid) {
        return CouponHistory::leftJoin('shop_coupon','shop_coupon.id','=','shop_coupon_history.coupon_id')->where('shop_coupon.code',$coupon)->where('shop_coupon_history.uuid',$uuid)->count();
    }


}
