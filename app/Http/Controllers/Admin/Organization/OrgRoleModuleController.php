<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Store\StoreUserRoleModule;
use App\Model\Admin\Organization\OrgRole;

class OrgRoleModuleController extends Controller
{
    public function edit($roleId)
    {
        $modules = Module::where('guard_id',5)->get();
        $role = OrgRole::find($roleId);

        $roleModulesIds =  OrgRole::find($roleId)->modules()->get()->pluck('id')->toArray();
        return view('admin.amaster.organization.org_role_module.edit',compact('modules','role','roleModulesIds'));
    }

    public function update(Request $request)
    {
        $role = OrgRole::find($request->role_id); 
        
        $role ->modules()->detach(); 
        
        foreach($request->modules as $mKey => $mVal){
            
            $create = $mVal['create'] ?? "";
            $read = $mVal['read'] ?? "";
            $update = $mVal['update'] ?? "";
            $delete = $mVal['delete'] ?? "";
            $role->modules()->attach($mKey,[
                    'c' => $create == "on" ? "1" : "0",
                    'r' => $read == "on" ? "1" : "0",
                    'u' => $update == "on" ? "1" : "0",
                    'd' => $delete == "on" ? "1" : "0",
            ]); 
            $storeIds = UserStore::where('store_role_id',$request->role_id)->get()->pluck('id')->toArray(); 
            $managerRoleIds = ManagerRole::whereIn('store_id',$storeIds)->pluck('id')->toArray(); 
            
            StoreUserRoleModule::query() 
                ->whereIn('role_id',$managerRoleIds)
                ->when($request->has('modules'), function($query) use ($request){
                        return $query->whereNotIn('module_id',array_keys($request->modules));
                })
            ->delete(); 
        } 
        return response()->json(['success'=>true],202);
    }
}
