<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;
    protected $table = 'shop_option';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','status','type','status','is_filter'
    ];

    function value(){
        return $this->hasMany(OptionValue::class,'option_id');
    }
}
