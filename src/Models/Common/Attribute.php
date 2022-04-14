<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $table = 'shop_attribute';
    public $timestamps = false;

    protected $fillable = [
        'name','attribute_group_id','sort'
    ];


}
