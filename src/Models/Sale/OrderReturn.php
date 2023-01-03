<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturn extends Model
{
    use HasFactory;
    protected $table = 'shop_order_return';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','product_id','uuid','firstname','lastname','email','telephone','product','quantity','opened','comment','order_return_reason_id'
        ,'order_return_action_id','order_return_status_id'
    ];

    function orderReturnReason(){
        return $this->hasOne(OrderReturnReason::class,'id','order_return_reason_id');
    }

    function orderReturnAction(){
        return $this->hasOne(OrderReturnAction::class,'id','order_return_action_id');
    }

    function orderReturnStatus(){
        return $this->hasOne(OrderReturnStatus::class,'id','order_return_status_id');
    }

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

}
