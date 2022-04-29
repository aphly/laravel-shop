<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class FilterGroup extends Model
{
    use HasFactory;
    protected $table = 'shop_filter_group';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','status'
    ];


}
