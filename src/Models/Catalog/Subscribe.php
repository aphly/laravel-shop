<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscribe extends Model
{
    use HasFactory;
    protected $table = 'shop_subscribe';
    protected $primaryKey = 'id';

    //public $timestamps = false;

    protected $fillable = [
        'email','status'
    ];


}
