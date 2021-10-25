<?php

namespace App\Http\Middleware\Store;

use Closure;
use App\Model\Admin\WhiteListIpAddress;

class RestrictIpAddressStoreMiddleware
{
    public function handle($request, Closure $next)
    {  
        if(auth('store')->user()->ip_blocking){
            $whiteListIps = auth('store')->user()->managerIps->pluck('ip_address')->toArray();
             if (in_array($request->ip(), $whiteListIps)) {
                return $next($request);
            } 
            return redirect()->route('ipNotAuthorized2'); 
        }
        return $next($request);
    }      
}
