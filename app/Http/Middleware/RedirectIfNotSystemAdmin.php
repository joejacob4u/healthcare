<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class RedirectIfNotSystemAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'web')
    {
      if (Auth::guard($guard)->check())
      {
         $user = User::find(Auth::guard($guard)->user()->id);
         return redirect('admin/login');
      }
        return $next($request);
    }
}
