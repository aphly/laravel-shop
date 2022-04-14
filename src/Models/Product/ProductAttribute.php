<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $table = 'shop_product_desc';
    protected $primaryKey = ['product_id','attribute_id'];
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'text'
    ];

}
