<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'shop_order_product';
    public $timestamps = false;

    protected $fillable = [
        'order_id','product_id','name','quantity','price','total','json','status'
    ];


}
