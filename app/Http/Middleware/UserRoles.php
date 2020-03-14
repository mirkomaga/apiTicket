<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserRoles
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->checkRules() == '1'){
            return $next($request);
        }
        return response('Non hai i permessi per accedere', 401)->header('Content-Type', 'text/plain');
    }
}
