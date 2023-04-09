<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderOption extends Model
{
    use HasFactory;
    protected $table = 'shop_order_option';
    public $timestamps = false;

    protected $fillable = [
        'order_id','order_product_id','product_option_id','product_option_value_id','name','value','type'
    ];


}
