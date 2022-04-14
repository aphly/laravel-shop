<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon_product';
    public $timestamps = false;

    protected $fillable = [
        'coupon_id','product_id'
    ];


}
