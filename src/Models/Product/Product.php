<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'shop_product';
    public $timestamps = false;

    protected $fillable = [
        'sku','name','quantity','image','price',
        'shipping','points','stock_status_id','weight','weight_class_id',
        'length','width','height','length_class_id','subtract',
        'minimum','status','viewed','sale','sort','date_add'
    ];

    function desc(){
        return $this->hasOne(ProductDesc::class);
    }

    function img(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    public function getProducts($data = array()) {
        
    }
}
