<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setting\AdminRole;
use App\Model\Admin\Setting\AdminAction; 

class AdminRoleModuleController extends Controller
{
    public function edit($roleId)
    {  
        $modules = Module::where('guard_id',1)->get();
        $roleModulesIds = AdminRole::find($roleId)->adminModules()->get()->pluck('id')->toArray();
        $role = AdminRole::find($roleId);
        
        return view('admin.amaster.AdminRoleModule.edit',compact('modules','roleModulesIds','role'));
    }

    public function update(Request $request)
    {     
        // dd($request->all());
         $adminRole = AdminRole::find($request->roleId);
            
         $adminRole ->adminModules()->detach(); 
         
        foreach($request->modules as $mKey => $mVal){
           
           $create = $mVal['create'] ?? "";
           $read = $mVal['read'] ?? "";
           $update = $mVal['update'] ?? "";
           $delete = $mVal['delete'] ?? "";
           $adminRole->adminModules()->attach($mKey,[
                  'c' => $create == "on" ? "1" : "0",
                  'r' => $read == "on" ? "1" : "0",
                  'u' => $update == "on" ? "1" : "0",
                  'd' => $delete == "on" ? "1" : "0",
           ]); 
        }

        
        // return redirect()->route('manager.role.index');
    }
     
    // public function index($id)
    // {
    //     $role = AdminRole::find($id);
    //     return view('admin.amaster.admin_role_module.index',compact('role'));

    // }

    
    // public function create($role_id)
    // {   
    //     $modules =  Module::where('guard_id',1)->get();
    //     $role_id = AdminRole::findOrFail($role_id)->id;
    //     $role = AdminRole::findOrFail($role_id);
    //     return view('admin.amaster.admin_role_module.create',compact('role_id','modules','role'));
    // }

    
    // public function admin(Request $request)
    // { 
        
    //     $role = AdminRole::find($request->role_id); 
    //     $role->adminModules()->detach();
         
    //     foreach($request->modules as $mKey => $mVal){
           
    //        $create = $mVal['create'] ?? "";
    //        $read = $mVal['read'] ?? "";
    //        $update = $mVal['update'] ?? "";
    //        $delete = $mVal['delete'] ?? "";
    //        $role->adminModules()->attach($mKey,[
    //               'create' => $create == "on" ? "1" : "0",
    //               'read' => $read == "on" ? "1" : "0",
    //               'update' => $update == "on" ? "1" : "0",
    //               'delete' => $delete == "on" ? "1" : "0",
    //        ]); 
           
    //     }

    //     return redirect()->route('admin.role.create');   

    // }
     
    // public function edit($id)
    // {   
        
    //     $role = AdminRole::find($id); 
    //     $modules =  Module::where('guard_id',1)->get();
    //     $module_ids =  AdminRole::find($id)->adminModules()->get()->pluck('id')->toArray();
         
       
    //     return view('admin.amaster.admin_role_module.edit',compact('role','modules','module_ids'));
    // }

    // public function update(Request $request)
    // {    
    //     // $this->authorize('create');
    //     // $val = auth('admin')->user()->role->adminModules;
    //     // dd($val);

        
    //     $role = AdminRole::find($request->role_id);
    //     $role->adminModules()->detach();
        
    //     if(isset($request->modules)){
    //         foreach($request->modules as $mKey => $mVal){
           
    //             $create = $mVal['create'] ?? "";
    //             $ca = $mVal['ca'] ?? "";
    //             $read = $mVal['read'] ?? "";
    //             $ra = $mVal['ra'] ?? "";
    //             $update = $mVal['update'] ?? "";
    //             $ua = $mVal['ua'] ?? "";
    //             $delete = $mVal['delete'] ?? "";
    //             $da = $mVal['da'] ?? "";
    //             $role->adminModules()->attach($mKey,[
    //                    'create' => $create == "on" ? "1" : "0",
    //                    'ca' => $ca == "on" ? "1" : "0",
    //                    'read' => $read == "on" ? "1" : "0",
    //                    'ra' => $ra == "on" ? "1" : "0",
    //                    'update' => $update == "on" ? "1" : "0",
    //                    'ua' => $ua == "on" ? "1" : "0",
    //                    'delete' => $delete == "on" ? "1" : "0",
    //                    'da' => $da == "on" ? "1" : "0",
    //             ]); 
                
    //          }
    //     }

    //     $role = AdminRole::find($request->role_id); 
        
        
    //     return redirect()->route('admin.role.create');
    // }
 
}
