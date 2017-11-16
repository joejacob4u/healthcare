<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class RedirectIfNotSystemAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'system_user')
    {
      if (Auth::guard($guard)->check())
      {
         $user = User::find(Auth::guard($guard)->user()->id);

         if($user->role->name == 'System Admin')
         {
            return $next($request);
         }
      }

      return redirect('/login');

    }
}
