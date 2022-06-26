<?php

namespace Aphly\LaravelShop\Models\Extension\Payment;

use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Common\Geo;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;

class Payment
{
    public string $cname = 'payment';

    public function checkout($total){
        $total = floatval($total);
        $data = Extension::findAll();
        $res = [];
        $shipping_address = Cookie::get('shipping_address');
        if(!empty($data[$this->cname]) && $shipping_address){
            $shipping_address = json_decode($shipping_address,true);
            $setting = Setting::findAll();
            foreach ($data[$this->cname] as $val){
                $class = ucfirst($val);
                if(isset($setting[$this->cname.'_'.$val]) && $setting[$this->cname.'_'.$val]['status']==1){
                    $geo = true;
                    $setting[$this->cname.'_'.$val]['geo_group_id'] = intval($setting[$this->cname.'_'.$val]['geo_group_id']);
                    if($setting[$this->cname.'_'.$val]['geo_group_id']){
                        $geo = (new Geo)->isExist($shipping_address['country_id'],$shipping_address['zone_id'],$setting[$this->cname.'_'.$val]['geo_group_id']);
                    }
                    $min_total = floatval($setting[$this->cname.'_'.$val]['min_total']);
                    if($geo && $min_total<=$total){
                        if(class_exists($class)){
                            if((new $class)->getStatus()){
                                $res[$val] = $setting[$this->cname.'_'.$val];
                            }
                        }else{
                            $res[$val] = $setting[$this->cname.'_'.$val];
                        }
                    }
                }
            }
        }
        return $res;
    }


}
