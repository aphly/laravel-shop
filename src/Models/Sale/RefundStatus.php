<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefundStatus extends Model
{
    use HasFactory;
    protected $table = 'shop_refund_status';
    public $timestamps = false;
    protected $fillable = [
        'name','cn_name'
    ];


}
