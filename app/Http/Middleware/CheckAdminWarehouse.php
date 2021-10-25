<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckAdminWarehouse
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
   
        if(Auth::guard('admin')->check() || Auth::guard('warehouse')->check()){

            return $next($request);
        }
        $prefix = $request->route()->action['prefix'];
          
           if($prefix=="admin"){
                        return redirect()->route('admin');

                    }else{
                        return redirect()->route('warehouse');
                    }
    }
}
