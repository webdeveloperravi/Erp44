<?php

namespace App\Http\Middleware\Store;

use Closure;  
use App\Model\Store\OrgRoleModule;
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Model\Store\StoreUserRoleModule; 

class StoreRoleModuleMiddleware
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
        $authUser = $request->user('store');  

        $module =  Module::where('route',Route::current()->getName())->first() ?? false; 
        
        // if(in_array($module->id,Session::get('myModules'))){
        //     return $next($request);
        // }else{
        //     abort(404);
        // }
        if($module){
            if(in_array($authUser->type,['org','lab'])){
                
                $storeUserRoleModule = OrgRoleModule::where(['role_id'=> $authUser->role->id,'module_id'=>$module->id])->exists();
                    if($storeUserRoleModule){
                        return $next($request);
                    }else{
                        abort(404);
                    }
            }elseif(in_array($authUser->type,['user'])){
                $storeUserRoleModule =  StoreUserRoleModule::where(['module_id'=>$module->id,'role_id'=> $authUser->managerRole->id ])->exists(); 
                if($storeUserRoleModule){
                    return $next($request);
                }else{
                    abort(404);
                }
            }else{
                abort(404);
            }
        } 
        return $next($request);
        
    }
}
