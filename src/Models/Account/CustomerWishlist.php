<?php

namespace Aphly\LaravelShop\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWishlist extends Model
{
    use HasFactory;
    protected $table = 'shop_customer_wishlist';
    protected $primaryKey = ['uuid','product_id'];
    public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','date_add'
    ];

}
