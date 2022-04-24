<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'shop_cart';
    public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','session_id','quantity','json','date_add'
    ];


}
