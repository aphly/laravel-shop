<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AfterSalesHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_after_sales_history';
    //public $timestamps = false;

    protected $fillable = [
        'after_sales_id','uid','content','notify'
    ];


}
