<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon_history';
    //public $timestamps = false;

    protected $fillable = [
        'coupon_id','order_id','uuid','amount'
    ];


}
