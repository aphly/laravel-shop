<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salesperson extends Model
{
    use HasFactory;
    protected $table = 'shop_salesperson';
    //public $timestamps = false;

    protected $fillable = [
        'name','platform','status'
    ];

}
