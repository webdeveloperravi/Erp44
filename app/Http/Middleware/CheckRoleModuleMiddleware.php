<?php

namespace App\Http\Middleware;

use Closure; 
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Route;
use App\Model\Admin\Master\WarehouseRoleModule;

class CheckRoleModuleMiddleware
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
        $user = $request->user('warehouse');
       
        $requestRouteName =  Route::current()->getName();
        $module =  Module::where('route',$requestRouteName)->first();
        if(!empty($module)){
            $warehouseModules =  WarehouseRoleModule::where('module_id',$module->id)->get();
            // dd($warehouseModule->role_id,$user->role->id);
            if(!empty($warehouseModules)){
                 
                foreach($warehouseModules as $module){
                    
                    if($module->role_id == $user->role->id){
                        return $next($request);
                    }
                    if($warehouseModules->last() == $module){ 
                        return redirect()->route('warehousemodulenotfound'); 
                    }
                }
            }
        }
        return $next($request);
        
    }
}
