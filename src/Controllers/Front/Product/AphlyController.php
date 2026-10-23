<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\LaravelShop\Controllers\Front\Controller;
use Illuminate\Http\Request;

class AphlyController extends Controller
{

    public function sizeGuide(Request $request)
    {
        $res['title'] = 'Size Guide';
        return $this->makeView(config('shop.pre').'::front.product.aphly.size_guide',['res'=>$res]);
    }


}
