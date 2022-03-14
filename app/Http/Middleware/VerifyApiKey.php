<?php

namespace App\Http\Middleware;

use Closure;

class VerifyApiKey
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
        $api_key = $request->header('ApiKey');
        if ($api_key != env('API_KEY')) {
            return response()->json([
                'status' => false,
                'message' => 'wrong_api_key'
            ]);
        }

        return $next($request);
    }
}
