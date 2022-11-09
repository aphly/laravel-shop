<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_order_history';
    public $timestamps = false;

    protected $fillable = [
        'order_id','order_status_id','notify','comment'
    ];


}
