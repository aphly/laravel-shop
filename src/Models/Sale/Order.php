<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'shop_order';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','email','address_id','address_firstname','address_lastname','address_address_1','address_address_2',
		'address_city','address_postcode','address_country','address_country_id','address_zone','address_zone_id','address_telephone',
		'shipping_id','shipping_name','shipping_desc','shipping_cost','shipping_free_cost','shipping_geo_group_id','payment_method_id',
		'payment_method_name','total','comment','currency_id','currency_code','currency_value','order_status_id',
		'ip','user_agent','accept_language'
    ];


}
