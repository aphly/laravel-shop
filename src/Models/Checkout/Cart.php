<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Aphly\LaravelShop\Models\Account\Customer;
use Aphly\LaravelShop\Models\Account\Group;
use Aphly\LaravelShop\Models\Product\Product;
use Aphly\LaravelShop\Models\Product\ProductDiscount;
use Aphly\LaravelShop\Models\Product\ProductOption;
use Aphly\LaravelShop\Models\Product\ProductOptionValue;
use Aphly\LaravelShop\Models\Product\ProductReward;
use Aphly\LaravelShop\Models\Product\ProductSpecial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'shop_cart';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','guest','quantity','option','date_add'
    ];

    public function __construct() {
        self::where('uuid',0)->where('date_add','<',time()-3600*24)->delete();
        parent::__construct();
    }

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function login() {
        $guest = Cookie::get('guest');
        if($guest){
            $cart = self::where('guest',$guest);
            $data = $cart->get()->toArray();
            $cart->delete();
            foreach ($data as $val){
                $this->add($val['product_id'], $val['quantity'], json_decode($val['option']));
            }
        }
    }

    public function add($product_id, $quantity = 1, $option = []) {
        $option = json_encode($option);
        $uuid = session('user')['uuid']??0;
        $where = ['uuid'=>$uuid,'guest'=>Cookie::get('guest'),'product_id'=>$product_id,'option'=>$option];
        $info = self::where($where)->first();
        if(!empty($info)){
            $info->increment('quantity',$quantity);
        }else{
            self::create(array_merge($where,['quantity'=>$quantity,'date_add'=>time()]));
        }
    }

    public function getProducts(){
        $product_data = [];
        $uuid = session('user')['uuid']??0;
        $cart_data = self::where(['uuid'=>$uuid,'guest'=>Cookie::get('guest')])->with('product')->get()->toArray();
        foreach($cart_data as $cart){
            $stock = true;
            if($cart['product']['status']==1 && $cart['product']['date_available']<time() && $cart['quantity'] > 0){
                $option_price = 0;
                $option_points = 0;
                $option_weight = 0;
                $cart['option'] = json_decode($cart['option'],true);
                if($cart['option']){
                    $option_value = (new Product)->optionValue($cart['product_id'],array_keys($cart['option']));
                    foreach ($cart['option'] as $k => $v) {
                        if(!empty($option_value[$k])){
                            if($option_value[$k]['option']['type']=='select' || $option_value[$k]['option']['type']=='radio'){
                                if(!empty($option_value[$k]['product_option_value'][$v])){
                                    $option_price += $option_value[$k]['product_option_value'][$v]['price'];
                                    $option_points += $option_value[$k]['product_option_value'][$v]['points'];
                                    $option_weight += $option_value[$k]['product_option_value'][$v]['weight'];
                                    if ($option_value[$k]['product_option_value'][$v]['subtract']==1 && (!$option_value[$k]['product_option_value'][$v]['quantity'] || ($option_value[$k]['product_option_value'][$v]['quantity'] < $cart['quantity']))) {
                                        $stock = false;
                                    }
                                    $option_value[$k]['product_option_value'] = $option_value[$k]['product_option_value'][$v];

                                }
                            }else if($option_value[$k]['option']['type']=='text' || $option_value[$k]['option']['type']=='textarea' || $option_value[$k]['option']['type']=='file'
                                || $option_value[$k]['option']['type']=='date' || $option_value[$k]['option']['type']=='datetime' || $option_value[$k]['option']['type']=='time'){
                                $option_value[$k]['product_option_value'] = $v;
                            }else if($option_value[$k]['option']['type']=='checkbox' && is_array($v)){
                                $arr = [];
                                foreach ($v as $v1){
                                    if(!empty($option_value[$k]['product_option_value'][$v1])){
                                        $option_price += $option_value[$k]['product_option_value'][$v1]['price'];
                                        $option_points += $option_value[$k]['product_option_value'][$v1]['points'];
                                        $option_weight += $option_value[$k]['product_option_value'][$v1]['weight'];
                                        $arr[$v1] = $option_value[$k]['product_option_value'][$v1];
                                        if ($option_value[$k]['product_option_value'][$v1]['subtract']==1 && (!$option_value[$k]['product_option_value'][$v1]['quantity'] || ($option_value[$k]['product_option_value'][$v1]['quantity'] < $cart['quantity']))) {
                                            $stock = false;
                                        }
                                    }
                                }
                                $option_value[$k]['product_option_value'] = $arr;
                            }
                        }
                    }

                }else{
                    $option_value = [];
                }

                $price = $cart['product']['price'];
                $group_id = Customer::groupId();
                $time = time();
                $discount_quantity = 0;
                foreach ($cart_data as $cart2) {
                    if ($cart2['product_id'] == $cart['product_id']) {
                        $discount_quantity += $cart2['quantity'];
                    }
                }
                $product_discount = ProductDiscount::where('product_id',$cart['product_id'])->where('group_id',$group_id)
                    ->where('quantity','<=',$discount_quantity)->orderBy('quantity','desc')->first();
                if(!empty($product_discount)){
                    $price = $product_discount['price'];
                }

                $product_special = ProductSpecial::where('product_id',$cart['product_id'])->where('group_id',$group_id)->where(function ($query) use ($time){
                                    $query->where('date_start','<',$time)->orWhere('date_start',0);
                                })->where(function ($query) use ($time){
                                    $query->where('date_end','>',$time)->orWhere('date_end',0);
                                })->orderBy('price','asc')->first();
                if(!empty($product_special)){
                    $price = $product_special['price'];
                }

                $product_reward = ProductReward::where('product_id',$cart['product_id'])->where('group_id',$group_id)->first();
                if (!empty($product_reward)) {
                    $reward = $product_reward['points'];
                } else {
                    $reward = 0;
                }
                if($cart['product']['subtract']==1 && ($cart['product']['quantity']<1 || $cart['product']['quantity']<$cart['quantity'])){
                    $stock = false;
                }

                $product_data[$cart['id']] = $cart;
                $product_data[$cart['id']]['option'] = $option_value;
                $product_data[$cart['id']]['stock'] = $stock;
                $product_data[$cart['id']]['price'] = ($price + $option_price);
                $product_data[$cart['id']]['total'] = ($price + $option_price) * $cart['quantity'];
                $product_data[$cart['id']]['shipping'] = $cart['product']['shipping'];
                $product_data[$cart['id']]['reward'] = $reward * $cart['quantity'];
                $product_data[$cart['id']]['points'] = ($cart['product']['points'] ? ($cart['product']['points'] + $option_points) * $cart['quantity'] : 0);
                $product_data[$cart['id']]['weight'] = ($cart['product']['weight'] + $option_weight) * $cart['quantity'];
            }else{
                $this->remove($cart['id']);
            }
        }
        return $product_data;
    }

    public function getSubTotal($products) {
        $total = 0;
        foreach ($products as $cart) {
            $total += $cart['total'];
        }
        return $total;
    }

    public function hasShipping($products) {
        foreach ($products as $product) {
            if ($product['shipping']) {
                return true;
            }
        }
        return false;
    }

    public function remove($cart_id) {
        return self::where(['id'=>$cart_id])->delete();
    }

    public function countProducts() {
        $product_total = 0;
        $products = $this->getProducts();
        foreach ($products as $product) {
            $product_total += $product['quantity'];
        }
        return $product_total;
    }
}
