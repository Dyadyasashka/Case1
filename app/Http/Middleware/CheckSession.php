<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('session_id')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
