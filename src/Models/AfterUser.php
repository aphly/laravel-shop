<?php

namespace Aphly\LaravelShop\Models;

use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;

class AfterUser
{
    public function afterRegister()
    {
        (new Wishlist)->afterRegister();
        (new Cart)->afterRegister();
    }

    public function afterLogin()
    {
        (new Wishlist)->afterLogin();
        (new Cart)->afterLogin();
    }
}
