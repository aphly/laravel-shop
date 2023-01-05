<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refund extends Model
{
    use HasFactory;
    protected $table = 'shop_refund';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','product_id','uuid','firstname','lastname','email','telephone','product','quantity','opened','comment','refund_reason_id'
        ,'refund_action_id','refund_status_id'
    ];

    function refundReason(){
        return $this->hasOne(RefundReason::class,'id','refund_reason_id');
    }

    function refundAction(){
        return $this->hasOne(RefundAction::class,'id','refund_action_id');
    }

    function refundStatus(){
        return $this->hasOne(RefundStatus::class,'id','refund_status_id');
    }

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

}
