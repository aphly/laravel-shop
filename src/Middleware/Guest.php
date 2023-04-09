<?php

namespace Aphly\LaravelShop\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Guest
{
    public function handle(Request $request, Closure $next)
    {
        $guest = Cookie::get('guest');
        if(!$guest){
            Cookie::queue('guest',Str::random(32),24*3600);
        }
        return $next($request);
    }



}
