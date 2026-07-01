<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductCost extends Model
{
    use HasFactory;
    protected $table = 'shop_product_cost';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id','price'
    ];

}
