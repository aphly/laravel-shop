<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class OptionValue extends Model
{
    use HasFactory;
    protected $table = 'shop_option_value';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','image','option_id'
    ];


}
