<?php

namespace Aphly\LaravelShop\Models\Setting;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ipv4 extends Model
{
    use HasFactory;
    protected $table = 'shop_ipv4';
    //public $timestamps = false;
    protected $fillable = [
        'country_iso','ip_start','ip_end','ip_start_int','ip_end_int'
    ];

}
