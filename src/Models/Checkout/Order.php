<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'shop_order';
    public $timestamps = false;

    protected $fillable = [
        'uuid','firstname','lastname','email','telephone','total','status'
    ];


}
