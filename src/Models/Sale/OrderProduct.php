<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'shop_order_product';
    public $timestamps = false;

    protected $fillable = [
        'order_id','product_id','name','image','sku','quantity','price','price_format','price_old','price_old_format',
        'total','total_format','total_old','total_old_format','discount','discount_format'

    ];

    function orderOption(){
        return $this->hasMany(OrderOption::class,'order_product_id','id');
    }

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
