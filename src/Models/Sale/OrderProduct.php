<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'shop_order_product';
    public $timestamps = false;

    protected $fillable = [
        'order_id','product_id','name','image','sku','quantity','price','price_format','total','total_format','reward','discount','discount_format','real_total','real_total_format'
    ];

    function orderOption(){
        return $this->hasMany(OrderOption::class,'order_product_id','id');
    }
}
