<?php

namespace Aphly\LaravelShop\Controllers;

use Aphly\LaravelShop\Models\Product\ProductImage;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelAdmin\Controllers\Controller
{

    public function __construct()
    {
        View::share("oss_url",ProductImage::$oss_url);
        View::share("oss_url",'');
        parent::__construct();
    }

}
