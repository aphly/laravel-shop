<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Option extends Model
{
    use HasFactory;
    protected $table = 'shop_option';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','status','type','status'
    ];


}
