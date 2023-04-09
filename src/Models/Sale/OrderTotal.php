<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTotal extends Model
{
    use HasFactory;
    protected $table = 'shop_order_total';
    public $timestamps = false;

    protected $fillable = [
        'order_id','title','value','sort'
    ];

}
