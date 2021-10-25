<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Model\Admin\Organization;
use Route;
use Session;

class CheckOrgDomain
{
    
    public function handle($request, Closure $next)
    {
        
        $subdomain = Route::getCurrentRoute()->parameters['domain'];
        
        $org =  Organization::where(['sub_domain'=>$subdomain]);
       
        if(!$org->exists()){
            // return redirect()->route('org.login',['subdomain'=>Session::get('sub_domain')]);
            return redirect()->route('errors',['code'=>1]);
           //dump( "This $subdomain domain does not register on 9gem.net");
           //dd(1);
        }else{
           $org_data = $org->first();
           if($org_data->status==0){
                dump("This $subdomain subdomain Not active. Contact to Adminstration  9gem.net </h1>");
                dd(1);
           }else{
               Session::put('org_id', $org_data->id);
               Session::put('sub_domain', $org_data->sub_domain);
               
               dump("this is register domain1 ");
           }
        }
        return $next($request);
    }
}
