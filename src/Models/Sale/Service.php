<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $table = 'shop_service';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','uuid','is_received','is_opened','reason','service_action_id','service_reason_id','service_status_id','delete_at'
    ];

    public function product(){
        return $this->hasMany(ServiceProduct::class,'service_id','id');
    }

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function addOrderHistory($info, $service_status_id, $comment = '', $notify = false){

        ServiceHistory::create([
            'service_id'=>$info->id,
            'service_action_id'=>$info->service_action_id,
            'service_status_id'=>$service_status_id,
            'comment'=>$comment,
            'notify'=>$notify
        ]);
    }

}
