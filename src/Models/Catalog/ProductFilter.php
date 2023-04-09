<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductFilter extends Model
{
    use HasFactory;
    protected $table = 'shop_product_filter';
    protected $primaryKey = ['product_id','category_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'filter_id'
    ];

}
