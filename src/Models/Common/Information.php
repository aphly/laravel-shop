<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Information extends Model
{
    use HasFactory;
    protected $table = 'shop_information';
    //public $timestamps = false;
    protected $fillable = [
        'title','content','viewed','status'
    ];

}
