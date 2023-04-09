<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOption extends Model
{
    use HasFactory;
    protected $table = 'shop_product_option';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'option_id',
        'value','required'
    ];

    function value_arr(){
        return $this->hasMany(ProductOptionValue::class,'product_option_id','id');
    }

    function option(){
        return $this->hasOne(Option::class,'id','option_id');
    }


}
