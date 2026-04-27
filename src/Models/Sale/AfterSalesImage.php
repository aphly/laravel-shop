<?php

namespace Aphly\LaravelShop\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class AfterSalesImage extends Model
{
    use HasFactory;
    protected $table = 'shop_after_sales_image';
    public $timestamps = false;

    protected $fillable = [
        'after_sales_id','image','disk'
    ];


}
