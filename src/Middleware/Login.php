<?php

namespace ctbuh\Login\Middleware;

use Closure;

class Login
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
