<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Admin\Setting\WarehouseAction;
use App\Model\Admin\Setting\WarehouseRoleAction;

class WarehouseRolePermissionController extends Controller
{
     
    public function index($roleId)
    {    
        $roleActions = WarehouseRoleAction::where('role_id',$roleId)->get();
        $role = WarehouseRole::find($roleId); 

        return view('admin.amaster.warehouse_role_permission.index',compact('roleActions','role'));
    }

    
    public function create($role_id)
    {   
        
        $actions = WarehouseAction::all();
        $role = WarehouseRole::find($role_id);
        return view('admin.amaster.warehouse_role_permission.create',compact('role_id','role','actions'));
    }

    
    public function store(Request $request)
    { 
        
        $role = WarehouseRole::find($request->role_id); 
        // $role->warehouseRolePermissions()->detach();
        if(!empty($request->actions))
        {
        foreach($request->actions as $aKey => $aVal){
           
           $create = $aVal['allow'] ?? "";
           $read = $aVal['authorization'] ?? ""; 
           
           $role->warehouseRoleActions()->attach($aKey,[
                  'allow' => $create == "on" ? "1" : "0",
                  'authorization' => $read == "on" ? "1" : "0", 
           ]);


           
        }
      }
        return redirect()->route('warehouse.role.permission.index',$request->role_id);   

    }
     
    public function edit($id)
    {    
        $warehouseRoleActions =  WarehouseRoleAction::where('role_id',$id)->get();
        $actions = WarehouseAction::all(); 
        $role_action_ids =  WarehouseRoleAction::where('role_id',$id)->pluck('action_id')->toArray(); 
        $role = WarehouseRole::find($id); 

        return view('admin.amaster.warehouse_role_permission.edit',compact('role','warehouseRoleActions','role_action_ids','actions'));
    }

    public function update(Request $request)
    {    
        
       
        $role = WarehouseRole::find($request->role_id); 
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
 
        return redirect()->route('warehouse.role.permission.index',$request->role_id);
    }
 
}
