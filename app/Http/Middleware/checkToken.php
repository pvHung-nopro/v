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
        // $user = Auth::check();
         $user =  $request->user()->id;
     if(!$user){
          return response()->json([
            'message' => 'Unauthorize',
            'status'  => false,
            'code'    => 401,
    ]);
     }


        return $next($request);
                }
}
