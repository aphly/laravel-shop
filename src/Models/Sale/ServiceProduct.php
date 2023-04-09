<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceProduct extends Model
{
    use HasFactory;
    protected $table = 'shop_service_product';
    public $timestamps = false;

    protected $fillable = [
        'service_id','order_product_id','quantity'
    ];

    public function orderProduct(){
        return $this->hasOne(OrderProduct::class,'id','order_product_id');
    }

}
