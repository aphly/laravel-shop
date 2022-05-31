<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'shop_coupon';
    public $timestamps = false;

    protected $fillable = [
        'name','code','type','discount','is_login',
        'shipping','total','date_start','date_end','uses_total',
        'uses_user','status','date_add'
    ];

    public function getTotal($total) {

    }
}
