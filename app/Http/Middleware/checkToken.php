<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class checkToken
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
        if (!Auth::guard('api')->check()) {
            // $user = Auth::guard('api')->user();

         return    response()->json([
               'status'=>false,
               'errors'=>'vui long login'
            ]);
        }

         return $next($request);

    }
}
