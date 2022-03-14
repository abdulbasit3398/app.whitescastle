<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminAccess
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
        if(Auth::user() && Auth::user()->type != 'admin')
        {
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
