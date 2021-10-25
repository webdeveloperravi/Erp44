<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App\Model\Admin\WhiteListIpAddress;

class RestrictIpAddressAdminMiddleware
{
    public function handle($request, Closure $next)
    {  
        // if(auth('admin')->user()->ip_blocking){
        //     $whiteListIps = auth('admin')->user()->managerIps->pluck('ip_address')->toArray();
        //      if (in_array($request->ip(), $whiteListIps)) {
        //         return $next($request);
        //     } 
        //     return redirect()->route('ipNotAuthorized2'); 
        // }
        return $next($request);
    }      
}
