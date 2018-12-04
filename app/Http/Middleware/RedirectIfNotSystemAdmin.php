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
    public function handle($request, Closure $next)
    {
        if (Auth::guard('system_user')->check()) {
            $user = User::find(Auth::guard('system_user')->user()->id);

            if ($user->role->name == 'System Admin') {
                return $next($request);
            }
            if (Auth::guard('admin')->check()) {
                return $next($request);
            }
            if (Auth::guard('master')->check()) {
                return $next($request);
            }
        }

        return redirect('/login');
    }
}
