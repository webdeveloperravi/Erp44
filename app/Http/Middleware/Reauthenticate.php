<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Reauthenticate
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
        if(!request()->ajax()){
            if(request()->ip() == "::1"){
                return $next($request);
               }  
            if((time() - Session::get('reauthenticate.last_authentication')) > Session::get('reauthenticate.timeout')){
                
                Session::put('reauthenticate.requested_url',\Request::url() ?? route('store.dashboard'));
                return redirect()->route('reauthenticate.index');
    
            }
        }
        return $next($request);
    }
}
