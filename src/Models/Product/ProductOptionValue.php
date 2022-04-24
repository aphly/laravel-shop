<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductOptionValue extends Model
{
    use HasFactory;
    protected $table = 'shop_product_option_value';
    public $timestamps = false;

    protected $fillable = [
        'product_option_id','product_id','option_id','option_value_id',
        'quantity','subtract','price','points','weight'
    ];

}
