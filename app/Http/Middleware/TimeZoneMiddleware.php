<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimeZoneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if($user){
            $timezone = $user->time_zone;
            if($timezone){
                date_default_timezone_set($timezone);
            }
        }
        return $next($request);
    }

}
