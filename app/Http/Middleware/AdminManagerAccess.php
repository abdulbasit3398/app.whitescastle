<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminManagerAccess
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
        if(Auth::user() && Auth::user()->type != 'admin' && Auth::user()->type != 'manager')
        {
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
