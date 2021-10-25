<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Session;

class CheckAdminAuthenticate
{

  public function handle($request, Closure $next)
  {
    if (Auth::guard('admin')->check()) {
      //  $last_seen = Carbon::create(Auth::guard('admin')->user()->last_seen);
      //  $last_seen->addMinutes(300);
      //  $current_time = Carbon::now();

      //  $diff_seen=  $last_seen->diffInMinutes($current_time);  
      // if($diff_seen >= 300){ 
      //      return redirect()->route('admin.logout');
      // }else{
      //    Auth::guard('admin')->user()->update([
      //      'last_seen' => Carbon::now(),
      //      ]);

      //    return $next($request);
      // }
      return $next($request);
    } else {
      return redirect()->route('admin');
    }
  }
}
