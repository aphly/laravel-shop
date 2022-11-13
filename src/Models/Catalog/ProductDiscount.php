<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductDiscount extends Model
{
    use HasFactory;
    protected $table = 'shop_product_discount';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id','price',
    ];


}
