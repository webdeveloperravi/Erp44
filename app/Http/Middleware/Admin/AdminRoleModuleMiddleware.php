<?php

namespace App\Http\Middleware\Admin;

use Closure;  
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Route; 
use App\Model\Admin\Setting\AdminRoleModule; 

class AdminRoleModuleMiddleware
{ 
    public function handle($request, Closure $next)
    {   
        $authUser = $request->user('admin');   
        if($authUser->id != '101'){
            $module =  Module::where('route',Route::current()->getName())->first() ?? false; 
            if($module){ 
                    $adminUserRoleModule = AdminRoleModule::where(['role_id'=> $authUser->role->id,'module_id'=>$module->id])->exists();
                        if($adminUserRoleModule){
                            return $next($request);
                        }else{
                            abort(404);
                        }
                
            } 
        } 
        return $next($request);
    }
}
