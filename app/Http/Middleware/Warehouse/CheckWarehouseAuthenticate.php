<?php

namespace App\Http\Middleware\Warehouse;

use Closure;
use Auth;

class CheckWarehouseAuthenticate
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
        
         if(!Auth::guard('warehouse')->check()){

             return redirect()->route('warehouse');//"not ware house login";//redirect()->route('warehouse.login');
        }
       
         return $next($request);
    }
}
