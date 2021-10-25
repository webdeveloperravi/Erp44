<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Store\ManagerRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ManagerRoleController extends Controller
{
    
    public function index()
    {
       return view('store.manager_role.index');
    }

    
    public function create()
    {   
        // $parentRoles = ManagerRole::all();
        $parentRoles = ManagerRole::where('store_id',auth('store')->user()->id)->get();
        return view('store.manager_role.create',compact('parentRoles'));
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
                    'name' => 'required',
                    'alias' => 'required',
                    'description' => 'required',
                     ]);
        if($validator->passes()){
                $managerRole = ManagerRole::create([
                    'name' => $request->name,
                    'alias' => $request->alias,
                    'description' => $request->description,
                    'parent_id' =>  $request->parent_id ?? 0,
                    'store_id' => auth('store')->user()->id,
                ]);
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    } 

    
    public function all(){

        $roles = ManagerRole::where('store_id',auth('store')->user()->id)->where('parent_id',0)->get();
        return view('store.manager_role.role_list',compact('roles'));

    }

    public function edit($id)
    {   
        $role = ManagerRole::find($id);
        $parentRoles = ManagerRole::where('store_id',auth('store')->user()->id)->where('parent_id','<',$role->id)->get();
        $childrenRoles = ManagerRole::find($id)->getAllChildren(); 
        return view('store.manager_role.edit',compact('parentRoles','role','childrenRoles'));
    }

    
    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'alias' => 'required',
            'description' => 'required',
                     ]);
        if($validator->passes()){
            $managerRole = ManagerRole::where('id',$request->roleId)->first();
            $managerRole->update([
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                'parent_id' =>  $request->parent_id ?? 0,
                ]);
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
           
           return response()->json(['errors'=>$errors]);
        }
    }

    
    public function destroy($id)
    {
        
    }
}
