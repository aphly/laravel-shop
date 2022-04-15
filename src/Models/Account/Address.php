<?php

namespace Aphly\LaravelShop\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'shop_address';

    protected $fillable = [
        'uuid','firstname','lastname','address','city','postcode','country_id','zone_id','telephone'
    ];


}
