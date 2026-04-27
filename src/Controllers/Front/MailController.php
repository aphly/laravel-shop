<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\Laravel\Models\CommonUserAuth;
use Aphly\LaravelShop\Mail\Account\Forget;
use Aphly\LaravelShop\Mail\Account\GuestPassword;
use Aphly\LaravelShop\Mail\Account\Verify;
use Aphly\LaravelShop\Mail\Order\Cancel;
use Aphly\LaravelShop\Mail\Order\Paid;
use Aphly\LaravelShop\Mail\Order\Refunded;
use Aphly\LaravelShop\Mail\Order\Shipped;
use Aphly\LaravelShop\Models\Sale\Order;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function render(Request $request)
    {
        $ke = $request->query("key");
        if(!$ke){
            return 'fail';
        }
        return $this->$ke();
    }

    public function forget()
    {
        $userauth = CommonUserAuth::where(['id_type'=>'email','id'=>'1@qq.com'])->first();
        return new Forget($userauth);
    }

    public function verify()
    {
        $userauth = CommonUserAuth::where(['id_type'=>'email','id'=>'1@qq.com'])->first();
        return new Verify($userauth);
    }

    public function paid()
    {
        $order = Order::where(['id'=>304526920651898880])->first();
        return new Paid($order);
    }

    public function shipped()
    {
        $order = Order::where(['id'=>304526920651898880])->first();
        return new Shipped($order);
    }

    public function cancel()
    {
        $order = Order::where(['id'=>304526920651898880])->first();
        return new Cancel($order);
    }

    public function refunded()
    {
        $order = Order::where(['id'=>304526920651898880])->first();
        return new Refunded($order,);
    }

    public function guestPassword()
    {
        $userauth = CommonUserAuth::where(['id_type'=>'email','id'=>'1@qq.com'])->first();
        return new GuestPassword($userauth->id,'sssss');
    }
}
