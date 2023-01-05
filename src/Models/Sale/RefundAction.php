<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefundAction extends Model
{
    use HasFactory;
    protected $table = 'shop_refund_action';
    public $timestamps = false;

    protected $fillable = [
        'name','cn_name'
    ];


}
