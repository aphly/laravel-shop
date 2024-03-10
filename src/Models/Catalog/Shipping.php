<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Libs\Math;
use Aphly\LaravelShop\Models\Account\UserAddress;
use Aphly\LaravelShop\Models\Setting\Currency;
use Aphly\LaravelShop\Models\Setting\GeoGroup;
use Aphly\Laravel\Models\User;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shop_shipping';
    //public $timestamps = false;

    protected $fillable = [
        'name','desc','cost','free_cost','geo_group_id','sort','status','default'
    ];

    static public function findAll($cache=true) {
        if($cache){
            return Cache::rememberForever('shop_shipping', function () {
                return self::where('status',1)->get()->keyBy('id')->toArray();
            });
        }else{
            return self::where('status',1)->get()->keyBy('id')->toArray();
        }
    }

    public function geoGroup(){
        return $this->hasOne(GeoGroup::class,'id','geo_group_id');
    }

    public function getList($address_id=0,$shipping_id=0) {
        $res = [];
        $cart = new Cart;
        if($cart->hasShipping()){
            $shop_address = $address_id?:(session('shop_address_id'));
            if($shop_address){
                $addrInfo = UserAddress::where('id',$shop_address)->where('uuid',User::uuid())->first();
                if(!empty($addrInfo)) {
                    $subTotal = $cart->getSubTotal();
                    $shipping = (new Shipping())->findAll();
                    foreach ($shipping as $val) {
                        if($val['free_cost']>0?($subTotal>=$val['free_cost']):false){
                            $val['free']=true;
                        }else{
                            $val['free']=false;
                        }
                        list($val['cost'],$val['cost_format']) = Currency::format($val['cost'],2);
                        list($val['free_cost'],$val['free_cost_format']) = Currency::format($val['free_cost'],2);
                        if($shipping_id && $val['id']==$shipping_id){
                            return $val;
                        }
                        if ($val['geo_group_id']) {
                            $geo = GeoGroup::with('child')->where('id',$val['geo_group_id'])->where('status',1)->firstToArray();
                            foreach ($geo['child'] as $v){
                                if($v['country_id']==$addrInfo->country_id){
                                    if(!$v['zone_id']){
                                        $res[$val['id']] = $val;
                                        break;
                                    }else if($v['zone_id']==$addrInfo->zone_id){
                                        $res[$val['id']] = $val;
                                        break;
                                    }
                                }
                            }
                        } else {
                            $res[$val['id']] = $val;
                        }
                    }
                }
            }
        }
        return $res;
    }

    public function getTotal($total_data) {
        if(Cart::$free_shipping){
            $total_data['totals']['shipping'] = [
                'title'      => 'Shipping',
                'value'      => 0,
                'value_format'      => 'Free (Coupon)',
                'sort' => 3,
                'ext'=>''
            ];
        }else{
            $shop_shipping_id = session('shop_shipping_id');
            $shipping = $this->getList();
            if(!empty($shipping[$shop_shipping_id])){
                if($shipping[$shop_shipping_id]['free']){
                    $total_data['totals']['shipping'] = [
                        'title'      => 'Shipping',
                        'value'      => 0,
                        'value_format'      => 'Free',
                        'sort' => 3,
                        'ext'=>$shop_shipping_id
                    ];
                }else{
                    $price = $shipping[$shop_shipping_id]['cost'];
                    list($value,$value_format) = Currency::format($price,2);
                    $total_data['totals']['shipping'] = [
                        'title'      => 'Shipping',
                        'value'      => $value,
                        'value_format'      => $value?$value_format:'Free',
                        'sort' => 3,
                        'ext'=>$shop_shipping_id
                    ];
                    //$total_data['total'] += $value;
                    $total_data['total'] = Math::add($total_data['total'],$value);
                }
            }
        }

    }
}
