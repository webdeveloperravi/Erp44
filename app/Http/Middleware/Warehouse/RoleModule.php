<?php

namespace App\Http\Middleware\Warehouse;

use Closure; 
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Route;
use App\Model\Admin\Master\WarehouseRoleModule;

class RoleModule
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

       

        $authUser = $request->user('warehouse');    
            $module =  Module::where('route',Route::current()->getName())->first() ?? false; 
            if($module){ 
                    $adminUserRoleModule = WarehouseRoleModule::where(['role_id'=> $authUser->role->id,'module_id'=>$module->id])->exists();
                        if($adminUserRoleModule){
                            return $next($request);
                        }else{
                            abort(404);
                        }
                
            }  
        return $next($request);
    }
}
