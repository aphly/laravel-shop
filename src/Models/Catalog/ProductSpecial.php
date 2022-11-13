<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ProductSpecial extends Model
{
    use HasFactory;
    protected $table = 'shop_product_special';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id','priority','price','date_start','date_end'
    ];



}
