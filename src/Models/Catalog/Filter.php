<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Filter extends Model
{
    use HasFactory;
    protected $table = 'shop_filter';
    public $timestamps = false;

    protected $fillable = [
        'filter_group_id','name','sort'
    ];

    function group(){
        return $this->hasOne(FilterGroup::class,'id','filter_group_id');
    }
}
