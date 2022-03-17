<?php

namespace Aphly\LaravelShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    use HasFactory;
    protected $table = 'product_img';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'src',
        'sort'
    ];

}
