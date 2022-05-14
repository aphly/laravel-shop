<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class CouponCategory extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon_category';
    protected $primaryKey = ['coupon_id','category_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'coupon_id','category_id'
    ];


}
