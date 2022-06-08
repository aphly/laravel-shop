<?php

namespace Aphly\LaravelShop\Controllers;

use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelAdmin\Controllers\Controller
{

    public function __construct()
    {
        View::share("oss_url",'https://img.lioasde.top');
        parent::__construct();
    }

}
