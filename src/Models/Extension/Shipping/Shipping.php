<?php

namespace Aphly\LaravelShop\Models\Extension\Shipping;

use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Common\Geo;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;

class Shipping
{
    public string $cname = 'shipping';

    public function checkout($total){
        $total = floatval($total);
        $data = Extension::findAll();
        $res = [];
        $shipping_coupon = Cookie::get('shipping_coupon');
        $shipping_address = Cookie::get('shipping_address');
        if(!empty($data[$this->cname]) && $shipping_address){
            $shipping_address = json_decode($shipping_address,true);
            $setting = Setting::findAll();
            foreach ($data[$this->cname] as $val){
                if(isset($setting[$this->cname.'_'.$val]) && $setting[$this->cname.'_'.$val]['status']==1){
                    $geo = true;
                    $setting[$this->cname.'_'.$val]['geo_group_id'] = intval($setting[$this->cname.'_'.$val]['geo_group_id']);
                    if($setting[$this->cname.'_'.$val]['geo_group_id']){
                        $geo = (new Geo)->isExist($shipping_address['country_id'],$shipping_address['zone_id'],$setting[$this->cname.'_'.$val]['geo_group_id']);
                    }
                    if($geo){
                        $setting[$this->cname.'_'.$val]['shipping_free'] = 0;
                        if($shipping_coupon){
                            $setting[$this->cname.'_'.$val]['new_cost'] = 0;
                            $setting[$this->cname.'_'.$val]['new_cost_format'] = Currency::format(0);
                            $setting[$this->cname.'_'.$val]['shipping_free'] = 1;
                        }else{
                            $setting[$this->cname.'_'.$val]['cost_format'] = Currency::format($setting[$this->cname.'_'.$val]['cost']);
                            $free = floatval($setting[$this->cname.'_'.$val]['free']);
                            if($free>0 && $free<=$total){
                                $setting[$this->cname.'_'.$val]['new_cost'] = 0;
                                $setting[$this->cname.'_'.$val]['new_cost_format'] = Currency::format(0);
                                $setting[$this->cname.'_'.$val]['shipping_free'] = 1;
                            }
                        }
                        $res[$val] = $setting[$this->cname.'_'.$val];
                    }

                }
            }
        }
        return $res;
    }
}
