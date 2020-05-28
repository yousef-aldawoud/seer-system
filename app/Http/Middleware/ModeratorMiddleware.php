<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ModeratorMiddleware
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

            if(Auth::user()->hasRole(["admin","moderator"])){
                return $next($request);
            }
            return redirect()->route('login');
        }
        return redirect()->route('login');
    }
}
