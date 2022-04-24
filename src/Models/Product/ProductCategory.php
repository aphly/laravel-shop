<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'shop_product_category';
    protected $primaryKey = ['product_id','category_id'];
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'category_id'
    ];

}
