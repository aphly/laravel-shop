<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;
    protected $table = 'shop_returns';
    public $timestamps = false;

    protected $fillable = [
        'uuid','firstname','lastname','email','telephone','total','status'
    ];


}
