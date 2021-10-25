<?php


namespace App\Http\Controllers\Admin\Setting;
use Auth;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setting\AdminRole;

class AdminRoleController extends Controller
{
       
          
        public function create(){
             
            $guard=Guard::orderBy('name','asc')->get();
            $parent_roles = AdminRole::all();
             
            return view('admin.amaster.AdminRole.create',compact('guard','parent_roles'));
        }

        protected function roleList()
        {
        // $roles=AdminRole::all();
        $roles = AdminRole::where('parent_id',0)->get();

        return view('admin.amaster.AdminRole.role_list',compact('roles'));
        }
    
         

    protected function store(Request $request)
    {  
        $validator = Validator::make($request->all(),[
            'role_name' => 'required|unique:warehouse_roles,name,department',
            'alias' => 'required|max:255', 
        ]);
            
        if($validator->passes()){

            $user_id = Auth::guard('admin')->id();
            $role = AdminRole::create([
                                    'name' =>$request->role_name,
                                    'guard_id' => 2,
                                    'alias' => $request->alias,
                                    'parent_id' => $request->parent_id ?? "0",
                                ]);
            return response()->json(['success'=>true],200); 
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
    }
    }

    public function attachModules($role_id){
         
        $modules =  Module::where('guard_id',2)->get();
        
        return view('admin.amaster.AdminRole.modulesattach',compact('role_id','modules'));
    }

    public function saveModules(Request $request){

        $role = AdminRole::where('id',$request->role_id)->first(); 

        $role->modules()->sync($request->modules);
        return "success";
    }
               
        

        protected function edit($id){

             $role = AdminRole::find($id);
             $parent_roles=AdminRole::where('parent_id','!=',$role->id)->get();
             return view('admin.amaster.AdminRole.edit',compact('parent_roles','role'));   

        }

        public function update(Request $request){ 
           
            $validator = Validator::make($request->all(),[  
                'name' => 'required|unique:warehouse_roles,name,'.$request->id,
                'alias' => 'required|max:255', 
            ]); 
                   
            if($validator->passes()){
                
                $role = AdminRole::find($request->id);
               
                $role->update([
                    'parent_id' => $request->parent_id,
                    'name' => $request->name,
                    'alias' => $request->alias,
                ]);
                return response()->json(['success'=>true],200); 
            }else{
                $keys = $validator->errors()->keys();
                $vals  = $validator->errors()->all();
                $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
            }
        } 

        public function statusUpdate($id){
            
            $role = AdminRole::where('id',$id)->first();
            // dd($role);
            if($role->status == 0){
                $status = 1;
            }else{
                $status = 0;
            }
            $role->update([
                'status' => $status,
               ]);
            //    dd($role->status);
               return response()->json(['success'=>Helper::message_format('Status updated','success')],200);
        }
}
