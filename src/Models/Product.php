<?php

namespace Aphly\LaravelShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $fillable = [
        'cate_id',
        'name',
        'price',
        'old_price',
        'points',
        'weight',
        'quantity',
        'status',
        'is_stock'
    ];

}
