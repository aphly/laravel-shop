<?php

namespace Aphly\LaravelShop\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ServiceImage extends Model
{
    use HasFactory;
    protected $table = 'shop_service_image';
    public $timestamps = false;

    protected $fillable = [
        'service_id','image','remote'
    ];


}
