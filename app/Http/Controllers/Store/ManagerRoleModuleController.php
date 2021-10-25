<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setting\WarehouseRole;

class ManagerRoleModuleController extends Controller
{
    

    public function edit($roleId)
    { 
        $storeModuleIds = UserStore::find(auth('store')->user()->id)->role->modules()->get()->pluck('id')->toArray();  
        $modules = Module::where('guard_id',5)->get();
        $roleModulesIds = ManagerRole::find($roleId)->modules()->get()->pluck('id')->toArray();
        $role = ManagerRole::find($roleId);
        
        return view('store.manager_role_module.edit',compact('modules','roleModulesIds','storeModuleIds','role'));
    }

    public function update(Request $request)
    {     
         $managerRole = ManagerRole::find($request->roleId);
            
         $managerRole ->modules()->detach(); 
         
        foreach($request->modules as $mKey => $mVal){
           
           $create = $mVal['create'] ?? "";
           $read = $mVal['read'] ?? "";
           $update = $mVal['update'] ?? "";
           $delete = $mVal['delete'] ?? "";
           $managerRole->modules()->attach($mKey,[
                  'c' => $create == "on" ? "1" : "0",
                  'r' => $read == "on" ? "1" : "0",
                  'u' => $update == "on" ? "1" : "0",
                  'd' => $delete == "on" ? "1" : "0",
           ]); 
        }

        
        // return redirect()->route('manager.role.index');
    }
}
