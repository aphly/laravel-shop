<?php

namespace Aphly\LaravelShop\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Str;

class Guest
{
    public function handle(Request $request, Closure $next)
    {
        $guest = session('guest');
        if(!$guest){
            session(['guest'=>Str::random(32)]);
        }
        return $next($request);
    }



}
