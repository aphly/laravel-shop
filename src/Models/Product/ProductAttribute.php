<?php

namespace Aphly\LaravelShop\Models\Product;

use Aphly\LaravelShop\Models\Common\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $table = 'shop_product_attribute';
    protected $primaryKey = ['product_id','attribute_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'text'
    ];

    function attribute(){
        return $this->hasOne(Attribute::class,'id','attribute_id');
    }
}
