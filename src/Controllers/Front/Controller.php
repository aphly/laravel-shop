<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\Common\Category;
use Aphly\LaravelShop\Models\Common\Currency;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelShop\Controllers\Controller
{
    public $currency_id;
    public function __construct()
    {
        View::share("category",(new Category)->getCategory());
        $currency = Cookie::get('currency');
        if($currency){
            $this->currency_id = $currency;
        }else{
            $currency = 1;
            Cookie::queue('currency',$currency);
            $this->currency_id = $currency;
        }
        parent::__construct();
    }

    function currency($price,$string = true){
        $info = Currency::where('id',$this->currency_id)->first();
        if($info){
            $price = round($price, (int)$info->decimal_place);
            if(!$string){
                return $price;
            }
            $string = '';
            if ($info->symbol_left) {
                $string .= $info->symbol_left;
            }
            $string .= number_format($price, (int)$info->decimal_place);
            if ($info->symbol_right) {
                $string .= $info->symbol_right;
            }
            return $string;
        }
        return $price;
    }
}
