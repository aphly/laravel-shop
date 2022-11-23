<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductDiscount;
use Aphly\LaravelShop\Models\Catalog\ProductImage;
use Aphly\LaravelShop\Models\Catalog\ProductReward;
use Aphly\LaravelShop\Models\Catalog\ProductSpecial;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'shop_cart';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','guest','quantity','option'
    ];

    static public $products=[];

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function afterRegister() {
        $this->afterLogin();
    }

    public function afterLogin() {
        $guest = Cookie::get('guest');
        if($guest){
            $cart = self::where('guest',$guest);
            self::where('uuid',User::uuid())->update(['guest'=>$guest]);
            $data = $cart->get()->toArray();
            $cart->delete();
            foreach ($data as $val){
                $this->add($val['product_id'], $val['quantity'], json_decode($val['option']));
            }
        }
    }

    public function add($product_id, $quantity = 1, $option = []) {
        $option = json_encode($option);
        $where = ['uuid'=>User::uuid(),'guest'=>Cookie::get('guest'),'product_id'=>$product_id,'option'=>$option];
        $info = self::where($where)->first();
        if(!empty($info)){
            $info->increment('quantity',$quantity);
        }else{
            self::create(array_merge($where,['quantity'=>$quantity]));
        }
    }

    public function totalQuantity($guest) {
        $info = self::where('guest',$guest)->select(DB::raw('SUM(quantity) as total_quantity'))->first();
        if(!empty($info) && $info->total_quantity){
            return $info->total_quantity;
        }
        return 0;
    }

    public function getList($refresh=false){
        if(!self::$products || $refresh) {
            $product_data = [];
            $uuid = User::uuid();
            $cart_data = self::when($uuid, function ($query, $uuid) {
                return $query->where('uuid', $uuid);
            })->where(['guest' => Cookie::get('guest')])->with('product')->get()->toArray();
            foreach ($cart_data as $cart) {
                $stock = true;
                if ($cart['product']['status'] == 1 && $cart['product']['date_available'] < time() && $cart['quantity'] > 0) {
                    $option_price = 0;
                    $option_weight = 0;
                    $cart['option'] = json_decode($cart['option'], true);
                    if ($cart['option']) {
                        $option_value = (new Product)->optionValue($cart['product_id'], array_keys($cart['option']));
                        foreach ($cart['option'] as $k => $v) {
                            if (!empty($option_value[$k])) {
                                if ($option_value[$k]['option']['type'] == 'select' || $option_value[$k]['option']['type'] == 'radio') {
                                    if (!empty($option_value[$k]['product_option_value'][$v])) {
                                        $option_price += $option_value[$k]['product_option_value'][$v]['price'];
                                        $option_weight += $option_value[$k]['product_option_value'][$v]['weight'];
                                        if ($option_value[$k]['product_option_value'][$v]['subtract'] == 1 && (!$option_value[$k]['product_option_value'][$v]['quantity'] || ($option_value[$k]['product_option_value'][$v]['quantity'] < $cart['quantity']))) {
                                            $stock = false;
                                        }
                                        $option_value[$k]['product_option_value'] = $option_value[$k]['product_option_value'][$v];

                                    }
                                } else if ($option_value[$k]['option']['type'] == 'text' || $option_value[$k]['option']['type'] == 'textarea' || $option_value[$k]['option']['type'] == 'file'
                                    || $option_value[$k]['option']['type'] == 'date' || $option_value[$k]['option']['type'] == 'datetime' || $option_value[$k]['option']['type'] == 'time') {
                                    $option_value[$k]['product_option_value'] = $v;
                                } else if ($option_value[$k]['option']['type'] == 'checkbox' && is_array($v)) {
                                    $arr = [];
                                    foreach ($v as $v1) {
                                        if (!empty($option_value[$k]['product_option_value'][$v1])) {
                                            $option_price += $option_value[$k]['product_option_value'][$v1]['price'];
                                            $option_weight += $option_value[$k]['product_option_value'][$v1]['weight'];
                                            $arr[$v1] = $option_value[$k]['product_option_value'][$v1];
                                            if ($option_value[$k]['product_option_value'][$v1]['subtract'] == 1 && (!$option_value[$k]['product_option_value'][$v1]['quantity'] || ($option_value[$k]['product_option_value'][$v1]['quantity'] < $cart['quantity']))) {
                                                $stock = false;
                                            }
                                        }
                                    }
                                    $option_value[$k]['product_option_value'] = $arr;
                                }
                            }
                        }

                    } else {
                        $option_value = [];
                    }

                    $price = $cart['product']['price'];

                    $group_id = User::groupId();
                    $time = time();
                    $discount_quantity = 0;
                    foreach ($cart_data as $cart2) {
                        if ($cart2['product_id'] == $cart['product_id']) {
                            $discount_quantity += $cart2['quantity'];
                        }
                    }
                    $product_discount = ProductDiscount::where('product_id', $cart['product_id'])
                        ->where('quantity', '<=', $discount_quantity)->orderBy('quantity', 'desc')->first();
                    if (!empty($product_discount)) {
                        $price = $product_discount['price'];
                    }

                    $product_special = ProductSpecial::where('product_id', $cart['product_id'])
                        ->where(function ($query) use ($time){
                            $query->where('date_start',0)->orWhere('date_start','<',$time);
                        })->where(function ($query) use ($time){
                            $query->where('date_end',0)->orWhere('date_end','>',$time);
                        })->orderBy('priority','desc')->first();

                    if (!empty($product_special)) {
                        $price = $product_special['price'];
                    }
                    $product_reward = ProductReward::where('product_id', $cart['product_id'])->where('group_id', $group_id)->first();
                    if (!empty($product_reward)) {
                        $reward = $product_reward['points'];
                    } else {
                        $reward = 0;
                    }
                    if ($cart['product']['subtract'] == 1 && ($cart['product']['quantity'] < 1 || $cart['product']['quantity'] < $cart['quantity'])) {
                        $stock = false;
                    }

                    $price = ($price + $option_price);
                    $total = $price * $cart['quantity'];
                    $cart['product']['image_src'] = ProductImage::render($cart['product']['image'],true);
                    $product_data[$cart['id']] = $cart;
                    $product_data[$cart['id']]['option'] = $option_value;
                    $product_data[$cart['id']]['stock'] = $stock;
                    $product_data[$cart['id']]['price'] = $price;
                    $product_data[$cart['id']]['price_format'] = Currency::format($price);
                    $product_data[$cart['id']]['total'] = $total;
                    $product_data[$cart['id']]['total_format'] = Currency::format($total);
                    $product_data[$cart['id']]['shipping'] = $cart['product']['shipping'];
                    $product_data[$cart['id']]['reward'] = $reward * $cart['quantity'];
                    $product_data[$cart['id']]['weight'] = ($cart['product']['weight'] + $option_weight) * $cart['quantity'];
                } else {
                    $this->remove($cart['id']);
                }
            }
            return self::$products = $product_data;
        }else{
            return self::$products;
        }
    }

    public function getSubTotal() {
        $products = $this->getList();
        $total = 0;
        foreach ($products as $cart) {
            $total += $cart['total'];
        }
        return $total;
    }

    public function hasShipping() {
        $products = $this->getList();
        foreach ($products as $product) {
            if ($product['shipping']) {
                return true;
            }
        }
        return false;
    }

    public function countList($refresh=false) {
        $product_count = 0;
        $list = $this->getList($refresh);
        foreach ($list as $product) {
            $product_count += $product['quantity'];
        }
        return [$product_count,$list];
    }

    public function remove($cart_id) {
        return self::where(['id'=>$cart_id])->delete();
    }

    public function delUuid(){
        return self::where(['uuid'=>User::uuid()])->delete();
    }

    public function initCart(){
        //Cookie::queue('shop_coupon', null , -1);
        Cookie::queue('shop_address_id', null , -1);
        Cookie::queue('shop_shipping_id', null , -1);
        self::where('uuid',0)->where('created_at','<',time()-3600*24*2)->delete();
    }

    public static $total = [
        'shipping','coupon','sub_total','total'
    ];

    public function totalData() {
        $totals = [];
        $total = 0;
        $total_data = [
            'totals' => &$totals,
            'total'  => &$total
        ];
        $sub_total = $this->getSubTotal();
        list($value,$value_format) = Currency::format($sub_total,2);
//        $total_data['totals'][] = [
//            'title'      => 'Sub_total',
//            'value'      => $value,
//            'value_format'      => $value_format,
//            'sort' => 1
//        ];
        $total_data['sub_total'] = $value;
        $total_data['sub_total_format'] = $value_format;

        $total_data['total'] += $value;

		(new Coupon())->getTotal($total_data);

		(new Shipping())->getTotal($total_data);

		$total_data['total_format'] = Currency::_format($total_data['total']);
        return $total_data;
    }
}
