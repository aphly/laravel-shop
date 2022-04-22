<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function index(Request $request)
    {
        $path = storage_path('app/private/shop_init.sql');
        DB::unprepared(file_get_contents($path));
        return 'ok';
    }


}
