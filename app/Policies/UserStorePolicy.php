<?php

namespace App\Policies;

use App\User;
use App\UserStore;
use App\Model\Admin\Setting\Module;
use App\Model\Store\StoreUserRoleModule;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserStorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {   
        
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserStore  $userStore
     * @return mixed
     */
    public function view(User $user, UserStore $userStore)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    { 
        // return true;
        // if(auth('store')->user()->type == "lab" || auth('store')->user()->type == "org"){
 

        // }elseif(auth('store')->user()->type == "user"){
            
        //     $managerRoleId = auth('store')->user()->managerRole->id;
        //     $routeName = request()->route()->getName();
        //     $moduleId = Module::where('route',$routeName)->first()->id;
        //     return StoreUserRoleModule::where('role_id',$managerRoleId)
        //     ->where('module_id',$moduleId)
        //     ->where('c','1')->exists() ? true : false ;
        // }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserStore  $userStore
     * @return mixed
     */
    public function update(User $user, UserStore $userStore)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserStore  $userStore
     * @return mixed
     */
    public function delete(User $user, UserStore $userStore)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserStore  $userStore
     * @return mixed
     */
    public function restore(User $user, UserStore $userStore)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserStore  $userStore
     * @return mixed
     */
    public function forceDelete(User $user, UserStore $userStore)
    {
        //
    }
}
