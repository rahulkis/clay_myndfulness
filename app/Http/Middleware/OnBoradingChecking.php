<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnBoradingChecking
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
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        if (!$user->isOnBoardingCompleted()) {
            abort("Please complete onboarding quesitons first", 400);
        }
        return $next($request);
    }
}
