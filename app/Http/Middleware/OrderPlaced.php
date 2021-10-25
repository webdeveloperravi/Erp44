<?php

namespace App\Http\Middleware;

use Closure;

class OrderPlaced
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

        if (session()->has('order_id') && session()->has('order_placed')) {
            return $next($request);
        } else {
            return redirect()->route('9gemhome');
        }
    }
}
