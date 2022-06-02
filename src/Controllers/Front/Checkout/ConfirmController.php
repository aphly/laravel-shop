<?php

namespace Aphly\LaravelShop\Controllers\Front\Checkout;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Common\Extension;
use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ConfirmController extends Controller
{
    public function index()
    {
        $Cart = new Cart;
        $res['list'] = $Cart->getProducts();
        if ($Cart->hasShipping($res['list'])) {
            if (!empty(Cookie::get('shipping_address')) || !empty(Cookie::get('shipping_method'))) {
                return redirect('checkout/checkout');
            }
        }
        if (!empty(Cookie::get('payment_method'))) {
            return redirect('checkout/checkout');
        }

        return redirect('pay?order_id=');
    }



}
