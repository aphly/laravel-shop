<?php

namespace Aphly\LaravelShop\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'shop_customer_wishlist';
    protected $primaryKey = ['uuid','product_id'];
    public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','date_add'
    ];

}
