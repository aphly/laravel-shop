<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnExchangeHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_return_exchange_history';
    //public $timestamps = false;

    protected $fillable = [
        'return_exchange_id','return_exchange_status_id','notify','comment'
    ];


}
