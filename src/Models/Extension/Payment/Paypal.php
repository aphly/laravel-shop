<?php

namespace Aphly\LaravelShop\Models\Extension\Payment;

use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Paypal
{
    public function getMethod($address, $total) {
        $status = true;
        if (Setting::findAll()->config['payment_pp_standard_total'] > $total) {
            $status = false;
        }
        $currencies = array(
            'AUD','CAD','EUR','GBP','JPY','USD','NZD','CHF','HKD',
            'SGD','SEK','DKK','PLN','NOK','HUF','CZK',
            'ILS','MXN','MYR','BRL','PHP','TWD','THB','TRY','RUB'
        );
        if (!in_array(strtoupper(Cookie::get('currency')), $currencies)) {
            $status = false;
        }
        $method_data = array();
        if ($status) {
            $method_data = array(
                'code'       => 'pp_standard',
                'title'      => 'pp_standard',
                'terms'      => '',
                'sort_order' => 1
            );
        }
        return $method_data;
    }


}
