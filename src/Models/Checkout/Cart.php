<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Aphly\Laravel\Libs\Math;
use Aphly\Laravel\Models\CommonUploadFile;
use Aphly\LaravelPayment\Models\Currency;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductDiscount;
use Aphly\LaravelShop\Models\Catalog\ProductSpecial;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'shop_cart';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'uid','product_id','guest','quantity','option'
    ];

    static public $list=false;

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function afterRegister() {
        $this->afterLogin();
    }

    public function afterLogin() {
        $guest = session('guest');
        if($guest){
            $cart = self::where('guest',$guest);
            self::where('uid',CommonUser::uid())->update(['guest'=>$guest]);
            $data = $cart->get()->toArray();
            $cart->delete();
            foreach ($data as $val){
                $this->add($val['product_id'], $val['quantity'], json_decode($val['option']));
            }
        }
    }

    public function add($product_id, $quantity = 1, $option = []) {
        $option = json_encode($option);
        $where = ['uid'=>CommonUser::uid(),'guest'=>session('guest'),'product_id'=>$product_id,'option'=>$option];
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
        if(self::$list===false || $refresh) {
            $list = [];
            $uid = CommonUser::uid();
            $cart_data = self::when($uid, function ($query, $uid) {
                return $query->where('uid', $uid);
            })->where(['guest' => session('guest')])->with('product')->get()->toArray();

            foreach ($cart_data as $cart) {
                $stock = true;
                if ($cart['product']['status'] == 1 && $cart['product']['date_available'] < time() && $cart['quantity'] > 0) {
                    $option_price = 0;
                    $option_value_arr = [];
                    $cart['option'] = json_decode($cart['option'], true);
                    if ($cart['option']) {
                        $option_value = (new Product)->optionValue($cart['product_id'], array_keys($cart['option']));
                        foreach ($cart['option'] as $k => $v) {
                            if (!empty($option_value[$k])) {
                                if ($option_value[$k]['option']['type'] == 'select' || $option_value[$k]['option']['type'] == 'radio') {
                                    $option_value_arr[] = $option_value[$k]['product_option_value'][$v]['option_value']['name'];
                                    if (!empty($option_value[$k]['product_option_value'][$v])) {
                                        //$option_price += $option_value[$k]['product_option_value'][$v]['price'];
                                        $option_price = Math::add($option_price,$option_value[$k]['product_option_value'][$v]['price']);
                                        if ($option_value[$k]['product_option_value'][$v]['subtract'] == 1 && (!$option_value[$k]['product_option_value'][$v]['quantity'] || ($option_value[$k]['product_option_value'][$v]['quantity'] < $cart['quantity']))) {
                                            $stock = false;
                                        }
                                        $option_value[$k]['product_option_value'] = $option_value[$k]['product_option_value'][$v];
                                    }
//                                } else if ($option_value[$k]['option']['type'] == 'text' || $option_value[$k]['option']['type'] == 'textarea' || $option_value[$k]['option']['type'] == 'file'
//                                    || $option_value[$k]['option']['type'] == 'date' || $option_value[$k]['option']['type'] == 'datetime' || $option_value[$k]['option']['type'] == 'time') {
                                } else if ($option_value[$k]['option']['type'] == 'checkbox' && is_array($v)) {
                                    $arr = [];
                                    foreach ($v as $v1) {
                                        if (!empty($option_value[$k]['product_option_value'][$v1])) {
                                            $option_value_arr[] = $option_value[$k]['product_option_value'][$v1]['option_value']['name'];
                                            //$option_price += $option_value[$k]['product_option_value'][$v1]['price'];
                                            $option_price = Math::add($option_price,$option_value[$k]['product_option_value'][$v1]['price']);
                                            $arr[$v1] = $option_value[$k]['product_option_value'][$v1];
                                            if ($option_value[$k]['product_option_value'][$v1]['subtract'] == 1 && (!$option_value[$k]['product_option_value'][$v1]['quantity'] || ($option_value[$k]['product_option_value'][$v1]['quantity'] < $cart['quantity']))) {
                                                $stock = false;
                                            }
                                        }
                                    }
                                    $option_value[$k]['product_option_value'] = $arr;
                                } else {
                                    $option_price = Math::add($option_price,$option_value[$k]['price']);
                                    $option_value_arr[] = $v;
                                    $option_value[$k]['product_option_value'] = $v;
                                }
                            }
                        }

                    } else {
                        $option_value = [];
                    }

                    $price = $cart['product']['price'];

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
                    $price_old = $price;
                    if (!empty($product_special)) {
                        $price = $product_special['price'];
                    }

                    if ($cart['product']['subtract'] == 1 && ($cart['product']['quantity'] < 1 || $cart['product']['quantity'] < $cart['quantity'])) {
                        $stock = false;
                    }
                    //dd($price,$option_price);
                    $price = $price + $option_price;
                    $price = $price>0?$price:0;

                    $price_old = $price_old + $option_price;
                    //$total = $price * $cart['quantity'];

                    $total = Math::mul($price,$cart['quantity']);
                    $total_old = Math::mul($price_old,$cart['quantity']);

                    $cart['product']['image_src'] = CommonUploadFile::getPath($cart['product']['image'],$cart['product']['disk']);
                    $list[$cart['id']] = $cart;
                    $list[$cart['id']]['option'] = $option_value;
                    $list[$cart['id']]['option_value_arr'] = $option_value_arr;
                    $list[$cart['id']]['stock'] = $stock;
                    $list[$cart['id']]['price'] = $price;
                    $list[$cart['id']]['price_format'] = Currency::format($price);
                    $list[$cart['id']]['price_old'] = $price_old;
                    $list[$cart['id']]['price_old_format'] = Currency::format($price_old);
                    $list[$cart['id']]['total'] = $total;
                    $list[$cart['id']]['total_format'] = Currency::format($total);
                    $list[$cart['id']]['total_old'] = $total_old;
                    $list[$cart['id']]['total_old_format'] = Currency::format($total_old);
                    $list[$cart['id']]['discount'] = 0;
                    $list[$cart['id']]['discount_format'] = 0;
                    $list[$cart['id']]['is_shipping'] = $cart['product']['is_shipping'];
                    $list[$cart['id']]['reward'] = 0;
                    $list[$cart['id']]['weight'] = $cart['product']['weight'] * $cart['quantity'];
                } else {
                    $this->remove($cart['id']);
                }
            }
            return self::$list = $list;
        }else{
            return self::$list;
        }
    }

    public function hasShipping() {
        $list = $this->getList();
        foreach ($list as $cart) {
            if ($cart['is_shipping']==1) {
                return true;
            }
        }
        return false;
    }

    public function getSubTotal() {
        $list = $this->getList();
        $total = 0;
        foreach ($list as $cart) {
            //$total += $cart['total'];
            $total = Math::add($total,$cart['total']);
        }
        return $total;
    }

    public function countList($refresh=false) {
        $count = 0;
        $list = $this->getList($refresh);
        foreach ($list as $cart) {
            $count += $cart['quantity'];
        }
        return [$count,$list];
    }

    public function countListSubTotal($refresh=false) {
        $count = $sub_total = $sub_total_old = 0;
        $list = $this->getList($refresh);
        foreach ($list as $cart) {
            $count += $cart['quantity'];
            //$sub_total += $cart['total'];
            $sub_total = Math::add($sub_total,$cart['total']);
            $sub_total_old = Math::add($sub_total_old,$cart['total_old']);
        }
        return [$count,$list,$sub_total,$sub_total_old];
    }

    public function quantityInCart($product_id) {
        $count = 0;
        $list = $this->getList();
        foreach ($list as $cart) {
            if($cart['product_id']==$product_id){
                $count += $cart['quantity'];
            }
        }
        return $count;
    }

    public function remove($cart_id) {
        return self::where(['id'=>$cart_id])->delete();
    }

    public function clear(){
        return self::where(['uid'=>CommonUser::uid()])->delete();
    }

    public function initCart(){
        session()->forget(['shop_address_id','shop_shipping_id']);
        self::where('uid',0)->where('created_at','<',time()-3600*24*2)->delete();
    }

    public static $total = [
        'shipping','coupon','sub_total','total'
    ];

    public static $free_shipping = false;

    public function totalData($refresh=false) {
        list($count,$list,$sub_total,$sub_total_old) = $this->countListSubTotal($refresh);
        $totals = [];
        $total = $total_old = 0;
        $total_data = [
            'totals' => &$totals,
            'total'  => &$total,
            'total_old'  => &$total_old,
        ];

        $total_data['totals']['sub_total'] = [
            'title'      => 'SubTotal',
            'value'      => $sub_total,
            'value_format'      => Currency::format($sub_total),
            'value_old'      => $sub_total_old,
            'value_old_format'      => Currency::format($sub_total_old),
            'sort' => 1,
            'ext'=>$count
        ];
        //$total_data['total'] += $sub_total;
        $total_data['total'] = Math::add($total_data['total'],$sub_total);
        $total_data['total_old'] = Math::add($total_data['total_old'],$sub_total_old);

        $cart_ext = (new Coupon)->getTotal($total_data);

		(new Shipping)->getTotal($total_data);
        list($payment_total,$payment_total_format,$currency_code) = Currency::format($total_data['total'],3);
        $total_data['totals']['total'] = [
            'title'      => 'Total',
            'value'      => $total_data['total'],
            'value_format'      => $payment_total_format,
            'value_old'      => $total_data['total_old'],
            'value_old_format'      => Currency::format($total_data['total_old']),
            'sort' => 99,
            'ext'=>''
        ];
        if(!empty($cart_ext)){
            foreach ($list as $key=>$val){
                $list[$key] = array_merge($val,$cart_ext[$key]);
            }
        }
        $total_data['payment_total'] = $payment_total;
        $total_data['payment_currency_code'] = $currency_code;
        return [$count,$list,$total_data];
    }
}
