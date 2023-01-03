<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturnHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_order_return_history';
    //public $timestamps = false;

    protected $fillable = [
        'order_return_id','order_return_status_id','notify','comment'
    ];


}
