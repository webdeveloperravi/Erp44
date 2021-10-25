<?php

namespace App\Http\Middleware;

use Closure; 
use App\Model\Guard\UserStore;
use App\Model\Store\OrgRoleModule;
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Route;
use App\Model\Store\StoreUserRoleModule;
use App\Model\Admin\Master\WarehouseRoleModule;

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
        // $user = $request->user('store');
       
        // $requestRouteName =  Route::current()->getName();

        // $module =  Module::where('route',$requestRouteName)->first();
        
        // $authUser = UserStore::find(auth('store')->user()->id);
        // if(!empty($module)){

        //     if($authUser->type == 'org'){
        //         $storeUserRoleModule = OrgRoleModule::where(['role_id'=> $authUser->role->id,'module_id'=>$module->id])->exists();
        //         if($storeUserRoleModule){
        //             return $next($request);
        //         }else{
        //             abort(404);
        //         }
        //     }
        //     if($authUser->type == 'user'){
        //         // dd('saab');
        //         $storeUserRoleModule =  StoreUserRoleModule::where(['module_id'=>$module->id,'role_id'=> $authUser->managerRole->id ])->exists(); 
        //         if($storeUserRoleModule){
        //             return $next($request);
        //         }else{
        //             abort(404);
        //         }
        //     }
        // }
        return $next($request);
        
    }
}
