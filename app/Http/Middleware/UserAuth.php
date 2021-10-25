<?php

namespace App\Http\Middleware;

use Closure;

class UserAuth
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
        if (session()->has('user_login')) {
            return $next($request);
        } else {
            return redirect()->route('9gem_user_login')->with('message', 'Please Login First To Move forward');
        }
    }
}
