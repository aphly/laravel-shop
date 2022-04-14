<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCate extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon_cate';
    protected $primaryKey = ['coupon_id','cate_id'];
    public $timestamps = false;

    protected $fillable = [
        'coupon_id','cate_id'
    ];


}
