<?php

namespace Aphly\LaravelShop\Controllers\Admin\Common;

use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Sale\AfterSales;
use Aphly\LaravelShop\Models\Sale\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        //购物车
        $res['guestCart48'] = Cart::where('uid', 0)->selectRaw('
            count(*) AS count_product_id,
            SUM(IFNULL(quantity,0)) AS sum_quantity
        ')->first();
        $res['userCart'] = Cart::where('uid','>', 0)->selectRaw('
            count(*) AS count_product_id,
            SUM(IFNULL(quantity,0)) AS sum_quantity
        ')->first();


        //订单
        $res['order24Count'] = Order::where('created_at', '>=',(time()-24*3600))->count();
        $res['orderCount'] = Order::count();

        //未支付
        $res['order24Count1'] = Order::where('order_status_id', 1)->where('created_at', '>=',(time()-24*3600))->count();
        $res['orderCount1'] = Order::where('order_status_id', 1)->count();

        //已支付
        $res['order24Count2'] = Order::where('order_status_id', 2)->where('created_at', '>=',(time()-24*3600))->count();
        $res['orderCount2'] = Order::where('order_status_id', 2)->count();

        //已发货
        $res['order24Count3'] = Order::where('order_status_id',3)->where('created_at', '>=',(time()-24*3600))->count();
        $res['orderCount3'] = Order::where('order_status_id', 3)->count();


        $res['afterSales24Count'] = AfterSales::where('status',0)->where('created_at', '>=',(time()-24*3600))->count();
        $res['afterSalesCount'] = AfterSales::where('status', 0)->count();

        $res['afterSales24Count1'] = AfterSales::where('status',1)->where('created_at', '>=',(time()-24*3600))->count();
        $res['afterSalesCount1'] = AfterSales::where('status', 1)->count();

        return $this->makeView('laravel-shop::admin.common.home.index', ['res' => $res]);
    }




}
