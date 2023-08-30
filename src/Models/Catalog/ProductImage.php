<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'shop_product_image';
    public $timestamps = false;

    protected $fillable = [
        'product_id','image','sort','remote','option_value_id','type'
    ];


}
