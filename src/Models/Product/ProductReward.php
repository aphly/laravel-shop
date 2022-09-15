<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductReward extends Model
{
    use HasFactory;
    protected $table = 'shop_product_reward';
    protected $primaryKey = ['product_id','group_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'group_id',
        'points'
    ];

}
