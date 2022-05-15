<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\Common\Category;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelShop\Controllers\Controller
{

    public function __construct()
    {
        View::share("category",(new Category)->getCategory());
        parent::__construct();
    }
}
