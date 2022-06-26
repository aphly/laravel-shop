<?php

namespace Aphly\LaravelShop\Models\Extension\Payment;

use Illuminate\Support\Facades\Cookie;

class Paypal
{
    public function getStatus() {
        $status = true;
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
