<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturn extends Model
{
    use HasFactory;
    protected $table = 'shop_order_return';
    public $timestamps = false;

    protected $fillable = [
        'uuid','firstname','lastname','email','telephone','total','status'
    ];


}
