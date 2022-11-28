<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shop_shipping';
    //public $timestamps = false;

    protected $fillable = [
        'name','desc','cost','free_cost','geo_group_id','sort','status','default'
    ];

    static public function findAll() {
        return Cache::rememberForever('shop_shipping', function () {
            return self::where('status',1)->get()->keyBy('id')->toArray();
        });
    }

    public function geoGroup(){
        return $this->hasOne(GeoGroup::class,'id','geo_group_id');
    }

    public function getList($address_id=0,$shipping_id=0) {
        $res = [];
        $cart = new Cart;
        if($cart->hasShipping()){
            $shop_address = $address_id?$address_id:(Cookie::get('shop_address_id'));
            if($shop_address){
                $addrInfo = UserAddress::where('id',$shop_address)->where('uuid',User::uuid())->first();
                if(!empty($addrInfo)) {
                    $subTotal = $cart->getSubTotal();

                    $shipping = (new Shipping())->findAll();

                    foreach ($shipping as $val) {
                        if($val['free_cost']>0?($subTotal>=$val['free_cost']):false){
                            $val['free']=1;
                        }else{
                            $val['free']=0;
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
        $shop_shipping_id = Cookie::get('shop_shipping_id');
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
                $total_data['total'] += $value;
            }
        }
    }
}
