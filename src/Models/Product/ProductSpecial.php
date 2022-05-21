<?php

namespace Aphly\LaravelShop\Models\Product;

use Aphly\LaravelShop\Models\Common\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductSpecial extends Model
{
    use HasFactory;
    protected $table = 'shop_product_special';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'group_id',
        'price','date_start','date_end'
    ];

    protected function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Currency::format($value)
        );
    }


}
