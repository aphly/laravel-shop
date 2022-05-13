<?php

namespace Aphly\LaravelShop\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'shop_customer_group';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name','description','sort'
    ];


}
