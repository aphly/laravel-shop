<?php

namespace Aphly\LaravelShop\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'shop_review';
    public $timestamps = false;

    protected $fillable = [
        'product_id','uuid','author','text','rating','status','date_add','date_edit'
    ];


}
