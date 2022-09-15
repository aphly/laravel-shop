<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductDesc extends Model
{
    use HasFactory;
    protected $table = 'shop_product_desc';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'description',
        'meta_title','meta_description','meta_keyword'
    ];

}
