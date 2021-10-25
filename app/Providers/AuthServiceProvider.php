<?php

namespace App\Providers;

use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Model\Store\StoreUserRoleModule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        \Auth::shouldUse('store');
        //Create
        Gate::define('store-create', function($user,$routeName){
             
            if(auth('store')->user()->type == "lab" || auth('store')->user()->type == "org"){
                return true;
            }elseif(auth('store')->user()->type == "user"){
                
                $managerRoleId = auth('store')->user()->managerRole->id; 
                $moduleId = Module::where('route',$routeName)->first()->id;
                return StoreUserRoleModule::where('role_id',$managerRoleId)
                ->where('module_id',$moduleId)
                ->where('c','1')->exists() ? true : false;
            }
        });

        //Read
        Gate::define('store-read', function($user,$routeName){
            if(auth('store')->user()->type == "lab" || auth('store')->user()->type == "org"){
                  return true;
            }elseif(auth('store')->user()->type == "user"){
                
                $managerRoleId = auth('store')->user()->managerRole->id; 
                $moduleId = Module::where('route',$routeName)->first()->id;
                return StoreUserRoleModule::where('role_id',$managerRoleId)
                ->where('module_id',$moduleId)
                ->where('r','1')->exists() ? true : false;
            }
        });
        //Update
        Gate::define('store-update', function($user,$routeName){
            if(auth('store')->user()->type == "lab" || auth('store')->user()->type == "org"){
                  return true;
            }elseif(auth('store')->user()->type == "user"){
                
                $managerRoleId = auth('store')->user()->managerRole->id; 
                $moduleId = Module::where('route',$routeName)->first()->id;
                return StoreUserRoleModule::where('role_id',$managerRoleId)
                ->where('module_id',$moduleId)
                ->where('u','1')->exists() ? true : false;
            }
        });
        // Delete
        Gate::define('store-delete', function($user,$routeName){
            if(auth('store')->user()->type == "lab" || auth('store')->user()->type == "org"){
                  return true;
            }elseif(auth('store')->user()->type == "user"){
                
                $managerRoleId = auth('store')->user()->managerRole->id; 
                $moduleId = Module::where('route',$routeName)->first()->id;
                return StoreUserRoleModule::where('role_id',$managerRoleId)
                ->where('module_id',$moduleId)
                ->where('d','1')->exists() ? true : false;
            }
        });
    }
}
