<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Admin\Setting\WarehouseAction;
use App\Model\Admin\Setting\WarehouseRoleAction;

class WarehouseRoleModuleController extends Controller
{
    public function edit($id)
    {   
        
        $role = WarehouseRole::find($id); 
        $modules =  Module::where('guard_id',2)->get();
        $module_ids =  WarehouseRole::find($id)->warehouseModules()->get()->pluck('id')->toArray();
        
        $warehouseRoleActions =  WarehouseRoleAction::where('role_id',$id)->get();
        $actions = WarehouseAction::all();  
        $role_action_ids =  WarehouseRoleAction::where('role_id',$id)->pluck('action_id'); 
       
        return view('admin.amaster.WarehouseRoleModule.edit',compact('role','modules','module_ids','warehouseRoleActions','actions','role_action_ids'));
    }

    public function update(Request $request)
    {     
        $role = WarehouseRole::find($request->roleId);
        $role->warehouseModules()->detach();
        
        if(isset($request->modules)){
            foreach($request->modules as $mKey => $mVal){
           
                $create = $mVal['create'] ?? "";
                $ca = $mVal['ca'] ?? "";
                $read = $mVal['read'] ?? "";
                $ra = $mVal['ra'] ?? "";
                $update = $mVal['update'] ?? "";
                $ua = $mVal['ua'] ?? "";
                $delete = $mVal['delete'] ?? "";
                $da = $mVal['da'] ?? "";
                $role->warehouseModules()->attach($mKey,[
                       'create' => $create == "on" ? "1" : "0",
                       'ca' => $ca == "on" ? "1" : "0",
                       'read' => $read == "on" ? "1" : "0",
                       'ra' => $ra == "on" ? "1" : "0",
                       'update' => $update == "on" ? "1" : "0",
                       'ua' => $ua == "on" ? "1" : "0",
                       'delete' => $delete == "on" ? "1" : "0",
                       'da' => $da == "on" ? "1" : "0",
                ]); 
                
             }
        }

        $role = WarehouseRole::find($request->roleId); 
        $role->warehouseRoleActions()->detach();
        if(isset($request->actions)){

            foreach($request->actions as $aKey => $aVal){
               
               $create = $aVal['allow'] ?? "";
               $read = $aVal['authorization'] ?? ""; 
               $role->warehouseRoleActions()->attach($aKey,[
                      'allow' => $create == "on" ? "1" : "0",
                      'authorization' => $read == "on" ? "1" : "0", 
               ]); 
            }
        } 
    }
 
}
