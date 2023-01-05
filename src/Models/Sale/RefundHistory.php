<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefundHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_refund_history';
    //public $timestamps = false;

    protected $fillable = [
        'refund_id','refund_status_id','notify','comment'
    ];


}
