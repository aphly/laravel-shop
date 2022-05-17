<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Information extends Model
{
    use HasFactory;
    protected $table = 'shop_information';
    public $timestamps = false;

    protected $fillable = [
        'title','sort','status','description','meta_title','meta_keyword','meta_description'
    ];


}
