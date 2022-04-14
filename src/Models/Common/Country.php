<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'shop_country';
    public $timestamps = false;

    protected $fillable = [
        'name','iso_code_2','iso_code_3','postcode_required','status'
    ];


}
