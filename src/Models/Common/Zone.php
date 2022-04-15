<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $table = 'shop_zone';
    public $timestamps = false;

    protected $fillable = [
        'country_id','name','code','status'
    ];


}
