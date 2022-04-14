<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;
    protected $table = 'shop_product_option';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'option_id',
        'value','required'
    ];

}
