<?php

namespace Aphly\LaravelShop\Mail\Order;

use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\OrderTotal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Paid extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
        $this->order->orderTotal = OrderTotal::where('order_id',$order->id)->get();
        $this->order->orderProduct = OrderProduct::where('order_id',$order->id)->with('orderOption')->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Order Paid')
            ->view('laravel-shop::mail.order.paid');
    }
}
