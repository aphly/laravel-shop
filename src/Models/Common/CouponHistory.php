<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon_history';
    public $timestamps = false;

    protected $fillable = [
        'coupon_id','order_id','uuid','amount','date_add'
    ];


}
