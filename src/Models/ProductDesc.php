<?php

namespace Aphly\LaravelShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDesc extends Model
{
    use HasFactory;
    protected $table = 'product_desc';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'description',
        'old_price',
        'points',
        'weight',
        'quantity',
        'is_stock'
    ];

}
