<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'shop_user_wishlist';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','product_id'
    ];

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
