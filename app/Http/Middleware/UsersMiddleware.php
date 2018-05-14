<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class UsersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && (!empty(Auth::user()->healthsystem_id) && Auth::user()->healthsystem_id != 0))
        {
            return $next($request);
        }

        return redirect('/login');

    }
}
