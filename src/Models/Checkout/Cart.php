<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Aphly\Laravel\Libs\Math;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Models\Catalog\Coupon;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductDiscount;
use Aphly\LaravelShop\Models\Catalog\ProductSpecial;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
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
        $where = ['uuid'=>User::uuid(),'guest'=>session('guest'),'product_id'=>$product_id,'option'=>$option];
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
            $uuid = User::uuid();
            $cart_data = self::when($uuid, function ($query, $uuid) {
                return $query->where('uuid', $uuid);
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
                                } else if ($option_value[$k]['option']['type'] == 'text' || $option_value[$k]['option']['type'] == 'textarea' || $option_value[$k]['option']['type'] == 'file'
                                    || $option_value[$k]['option']['type'] == 'date' || $option_value[$k]['option']['type'] == 'datetime' || $option_value[$k]['option']['type'] == 'time') {
                                    $option_value[$k]['product_option_value'] = $v;
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

                    if (!empty($product_special)) {
                        $price = $product_special['price'];
                    }

                    if ($cart['product']['subtract'] == 1 && ($cart['product']['quantity'] < 1 || $cart['product']['quantity'] < $cart['quantity'])) {
                        $stock = false;
                    }

                    list($price,$price_format) = Currency::format($price + $option_price,2);
                    //$total = $price * $cart['quantity'];
                    $total = Math::mul($price,$cart['quantity']);
                    $cart['product']['image_src'] = UploadFile::getPath($cart['product']['image'],$cart['product']['remote']);
                    $list[$cart['id']] = $cart;
                    $list[$cart['id']]['option'] = $option_value;
                    $list[$cart['id']]['option_value_str'] = implode(' / ',$option_value_arr);
                    $list[$cart['id']]['stock'] = $stock;
                    $list[$cart['id']]['price'] = $price;
                    $list[$cart['id']]['price_format'] = $price_format;
                    $list[$cart['id']]['total'] = $total;
                    $list[$cart['id']]['total_format'] = Currency::_format($total);
                    $list[$cart['id']]['discount'] = 0;
                    $list[$cart['id']]['discount_format'] = Currency::_format(0);
                    $list[$cart['id']]['real_total'] = $total;
                    $list[$cart['id']]['real_total_format'] = Currency::_format($total);
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
        $count = $sub_total = 0;
        $list = $this->getList($refresh);
        foreach ($list as $cart) {
            $count += $cart['quantity'];
            //$sub_total += $cart['total'];
            $sub_total = Math::add($sub_total,$cart['total']);
        }
        return [$count,$list,$sub_total];
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
        return self::where(['uuid'=>User::uuid()])->delete();
    }

    public function initCart(){
        session()->forget(['shop_address_id','shop_shipping_id']);
        self::where('uuid',0)->where('created_at','<',time()-3600*24*2)->delete();
    }

    public static $total = [
        'shipping','coupon','sub_total','total'
    ];

    public static $free_shipping = false;

    public function totalData($refresh=false) {
        list($count,$list,$sub_total) = $this->countListSubTotal($refresh);
        $totals = [];
        $total = 0;
        $total_data = [
            'totals' => &$totals,
            'total'  => &$total
        ];

        $value_format = Currency::_format($sub_total);
        $total_data['totals']['sub_total'] = [
            'title'      => 'SubTotal',
            'value'      => $sub_total,
            'value_format'      => $value_format,
            'sort' => 1,
            'ext'=>$count
        ];
        //$total_data['total'] += $sub_total;
        $total_data['total'] = Math::add($total_data['total'],$sub_total);
        $cart_ext = (new Coupon)->getTotal($total_data);

		(new Shipping)->getTotal($total_data);
        list($total_data['total'],$total_data['total_format']) = Currency::format($total_data['total'],2);
        $total_data['totals']['total'] = [
            'title'      => 'Total',
            'value'      => $total_data['total'],
            'value_format'      => $total_data['total_format'],
            'sort' => 99,
            'ext'=>''
        ];
        if(!empty($cart_ext)){
            foreach ($list as $key=>$val){
                $list[$key] = array_merge($val,$cart_ext[$key]);
            }
        }
        return [$count,$list,$total_data];
    }
}
