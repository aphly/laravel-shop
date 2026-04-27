<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Aphly\LaravelShop\Models\Setting\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AfterSales extends Model
{
    use HasFactory;
    protected $table = 'shop_after_sales';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','uid','is_received','is_opened','status','delete_at','id'
    ];

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    function img(){
        return $this->hasMany(AfterSalesImage::class,'after_sales_id');
    }

}
