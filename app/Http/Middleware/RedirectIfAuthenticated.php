<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check())
        {
            $user = User::find(Auth::guard($guard)->user()->id);
            
            if($user->roles->contains('name','Business Partner'))
            {
                return $next($request);
            } 
             
            return redirect('/home');
        }

        return $next($request);
    }
}
