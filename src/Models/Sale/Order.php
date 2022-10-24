<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'shop_order';
    public $timestamps = false;

    protected $fillable = [
        'uuid','firstname','lastname','email','telephone','total','status'
    ];


}
