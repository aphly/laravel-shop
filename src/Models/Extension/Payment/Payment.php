<?php

namespace Aphly\LaravelShop\Models\Extension\Payment;

use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Common\Setting;

class Payment
{
    public string $cname = 'payment';

    public function getList(){
        $data = Extension::findAll();
        $res = [];
        if(!empty($data[$this->cname])){
            $setting = Setting::findAll();
            foreach ($data[$this->cname] as $val){
                $class = ucfirst($val);
                if(isset($setting[$this->cname.'_'.$val]) && $setting[$this->cname.'_'.$val]['status']==1){
                    if(class_exists($class)){
                        if((new $class)->getStatus()){
                            $res[$val] = $setting[$this->cname.'_'.$val];
                        }
                    }
                }
            }
        }
        return $res;
    }


}
