<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotMaintenanceAdmin
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
            if (Auth::guard('system_user')->user()->role->name == 'Facility Manager/Director' || Auth::guard('system_user')->user()->role->name == 'System Admin') {
                return $next($request);
            }
        }

        return redirect('/login');
    }
}
