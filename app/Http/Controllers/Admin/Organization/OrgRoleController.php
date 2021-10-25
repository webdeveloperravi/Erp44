<?php

namespace App\Http\Controllers\Admin\Organization;

use Auth;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Unit;
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Organization\TaxType;
use App\Model\Admin\Organization\RetailModel;

class OrgRoleController extends Controller
{
   
           public function index(){
             

            return view('admin.amaster.organization.org_roles.index');

          }

          public function orgRoleList(){
                
                $orgRoles=OrgRole::all(); 
                return view('admin.amaster.organization.org_roles.org_role_list',compact('orgRoles'));
           
          }

         public function store(Request $request){
              
               
            $validator = Validator::make($request->all(),[
               'name' => 'required|unique:org_roles|max:255',
               'description' => 'required',
                
           ]);
            
          if($validator->passes()){
                    
            $user_id = Auth::guard('admin')->id();
            $prof_perm_obj=new OrgRole();
            $prof_perm_obj->name=$request->name;
            $prof_perm_obj->description=$request->description;
            $prof_perm_obj->created_by=$user_id;
            $prof_perm_obj->save();

            $prof_perm_obj->masterIds()->create([
               'created_id' => Helper::getAdminId()
             ]);
            return response()->json(['success'=>true]); 
            
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
           
           return response()->json(['errors'=>$errors]);
        }
      } 

         public function update(Request $request){
         
                       
            $validator = Validator::make($request->all(),[
               'name' => 'required|unique:org_roles,id,'.$request->id, 
               'description' => 'required',
           ]);
            
          if($validator->passes()){
                    
            $orgRole = OrgRole::where('id',$request->id)->first();
            $orgRole->update([
               'name'=>$request->name,
               'description'=>$request->description,
            ]);

            $orgRole->masterIds()->create([
               'updated_id' => Helper::getAdminId()
             ]);
            return response()->json(['success'=>true]); 
            
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
           
           return response()->json(['errors'=>$errors]);
        } 
        }

        public function status($id,$status)
          {

             if($status==1)
             {
                $status=0;
             }
             else
             {
                $status=1;  
             }
             OrgRole::find($id)->update(['status'=>$status]);

             return response()->json(['success'=>Helper::message_format('Organization Role Status Changed','primary')],200);
         }

         public function editConfig($id){
            // dd("Saab");
            $taxTypes = TaxType::all();
            $units = Unit::all();
            $retailModels = RetailModel::all();
            $orgRole = OrgRole::find($id);
            return view('admin.amaster.organization.org_roles.editConfig',compact('orgRole','taxTypes','units','retailModels')); 
         }

         public function updateConfig(Request $request){
            
            $orgRole = OrgRole::where('id',$request->orgRoleId);
            $orgRole->update([
               'retail_model_id' => $request->retailModelId,
               'tax_type_id' => $request->taxType,
               'unit_id' => $request->unitType,
               'ip_blocking_feature' => $request->ip_blocking_feature,
               'stock_visibility' => $request->stock_visibility,
            ]);
            return "success";
         }
}
