<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class RedirectIfNotAdmin
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

         if($user->role->name == 'System Admin' || $$user->role->name == 'Admin')
         {
            return $next($request);
         }
      }

      return redirect('/login');
    }
}
