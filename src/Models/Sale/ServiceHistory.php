<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceHistory extends Model
{
    use HasFactory;
    protected $table = 'shop_service_history';
    //public $timestamps = false;

    protected $fillable = [
        'service_id','service_action_id','service_status_id','notify','comment'
    ];


}
