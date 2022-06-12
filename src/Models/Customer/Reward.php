<?php

namespace Aphly\LaravelShop\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Reward extends Model
{
    use HasFactory;
    protected $table = 'shop_customer_reward';
    public $timestamps = false;

    protected $fillable = [
        'uuid','order_id','description',
        'points','date_add'
    ];

}
