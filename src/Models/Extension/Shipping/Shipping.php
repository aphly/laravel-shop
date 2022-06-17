<?php

namespace Aphly\LaravelShop\Models\Extension\Shipping;

use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;

class Shipping
{
    public string $cname = 'shipping';

    public function getList(){
        $data = Extension::findAll();
        $res = [];
        $shipping_coupon = Cookie::get('shipping_coupon');
        if(!empty($data[$this->cname])){
            $setting = Setting::findAll();
            foreach ($data[$this->cname] as $val){
                if(isset($setting[$this->cname.'_'.$val]) && $setting[$this->cname.'_'.$val]['status']==1){
                    $setting[$this->cname.'_'.$val]['name'] = $setting[$this->cname.'_'.$val]['name']??$val;
                    if($shipping_coupon){
                        $setting[$this->cname.'_'.$val]['cost'] = 0;
                        $setting[$this->cname.'_'.$val]['cost_format'] = Currency::format(0);
                        $setting[$this->cname.'_'.$val]['shipping_coupon'] = $shipping_coupon;
                    }else{
                        $setting[$this->cname.'_'.$val]['cost_format'] = Currency::format($setting[$this->cname.'_'.$val]['cost']);
                    }
                    $res[] = $setting[$this->cname.'_'.$val];
                }
            }
        }
        return $res;
    }
}
