<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnExchangeReason extends Model
{
    use HasFactory;
    protected $table = 'shop_return_exchange_reason';
    public $timestamps = false;

    protected $fillable = [
        'name','cn_name'
    ];


}
