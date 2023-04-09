<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponProduct extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon_product';
    protected $primaryKey = ['coupon_id','category_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'coupon_id','product_id'
    ];


}
