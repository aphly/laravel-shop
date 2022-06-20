<?php

namespace Aphly\LaravelShop\Models\Extension\Payment;

use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Paypal
{
    public function getStatus($total) {
        $status = true;
        if (Setting::findAll()['payment_paypal']['total'] > $total) {
            $status = false;
        }
        $currencies = [
            'AUD','CAD','EUR','GBP','JPY','USD','NZD','CHF','HKD',
            'SGD','SEK','DKK','PLN','NOK','HUF','CZK',
            'ILS','MXN','MYR','BRL','PHP','TWD','THB','TRY','RUB'
        ];
        if (!in_array(strtoupper(Cookie::get('currency')), $currencies)) {
            $status = false;
        }
        return $status;
    }


}
