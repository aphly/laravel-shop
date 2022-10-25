<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\LaravelCommon\Models\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductDiscount extends Model
{
    use HasFactory;
    protected $table = 'shop_product_discount';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id','group_id','price'
    ];

    protected function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Currency::format($value)
        );
    }
}
