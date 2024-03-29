<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOptionValue extends Model
{
    use HasFactory;
    protected $table = 'shop_product_option_value';
    public $timestamps = false;

    protected $fillable = [
        'product_option_id','product_id','option_id','option_value_id','product_image_id',
        'quantity','subtract','price','sort'
    ];

    function option_value(){
        return $this->hasOne(OptionValue::class,'id','option_value_id');
    }

    function productImage(){
        return $this->hasOne(ProductImage::class,'id','product_image_id');
    }

}
