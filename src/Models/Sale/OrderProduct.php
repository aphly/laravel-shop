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
        'order_id','product_id','name','sku','quantity','price','price_format','total','total_format','reward'
    ];

    function orderOption(){
        return $this->hasMany(OrderOption::class,'order_product_id','id');
    }
}
