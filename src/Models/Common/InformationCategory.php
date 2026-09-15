<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class InformationCategory extends Model
{
    use HasFactory;
    protected $table = 'shop_information_category';
    public $timestamps = false;

    protected $fillable = [
        'name','status'
    ];


}
