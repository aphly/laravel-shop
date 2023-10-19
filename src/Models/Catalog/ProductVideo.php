<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductVideo extends Model
{
    use HasFactory;
    protected $table = 'shop_product_video';
    public $timestamps = false;

    protected $fillable = [
        'product_id','video','sort','remote','type'
    ];


}
