<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckStoreAuthenticate
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
        // $route = $request->route();
        // $domain = $route->parameter('subdomain');
        // dd($domain);
        if(!Auth::guard('store')->check()){
             
             return redirect()->route('store');//"not ware house login";//redirect()->route('warehouse.login');
        }
        return $next($request);
    }
}
