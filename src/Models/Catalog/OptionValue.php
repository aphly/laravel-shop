<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionValue extends Model
{
    use HasFactory;
    protected $table = 'shop_option_value';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','image','option_id','remote'
    ];


}
