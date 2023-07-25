<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'shop_contact_us';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','email','viewed','content'
    ];


}
