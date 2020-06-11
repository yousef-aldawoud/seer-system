<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AnalystMiddleware
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

        if(Auth::check()){

            if(Auth::user()->hasRole(["admin","analyst"])){
                return $next($request);
            }
            return redirect()->route('login');
        }
        return redirect()->route('login');
    }
}
