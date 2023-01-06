<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnExchange extends Model
{
    use HasFactory;
    protected $table = 'shop_return_exchange';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','product_id','uuid','firstname','lastname','email','telephone','product_name','quantity','opened','comment',
        'return_exchange_reason_id','return_exchange_action_id','return_exchange_status_id'
    ];

    function returnExchangeReason(){
        return $this->hasOne(ReturnExchangeReason::class,'id','return_exchange_reason_id');
    }

    function returnExchangeAction(){
        return $this->hasOne(ReturnExchangeAction::class,'id','return_exchange_action_id');
    }

    function returnExchangeStatus(){
        return $this->hasOne(ReturnExchangeStatus::class,'id','return_exchange_status_id');
    }

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function addOrderHistory($info, $return_exchange_status_id, $comment = '', $notify = false){

        ReturnExchangeHistory::create([
            'return_exchange_id'=>$info->id,
            'return_exchange_status_id'=>$return_exchange_status_id,
            'comment'=>$comment,
            'notify'=>$notify
        ]);
    }

}
