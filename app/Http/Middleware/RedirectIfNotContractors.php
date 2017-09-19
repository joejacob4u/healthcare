<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Trade;

class RedirectIfNotContractors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        if (Auth::guard($guard)->check())
        {
           $user = User::find(Auth::guard($guard)->user()->id);
           
           if($user->is_contractor)
           {
               return $next($request);
           } 
 
        }
  
        return redirect('/login');
  
    }
}
