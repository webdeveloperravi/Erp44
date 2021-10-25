<?php

namespace App\Http\Controllers\Admin\Organization;

use Auth;
use Route;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request; 
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\AddressType;

class AddressTypeController extends Controller
{
        public function childTitle(){
           $route = Route::current();
           $name = Route::currentRouteName();
           $action = Route::currentRouteAction();
           $meta_title=Module::where(['route'=>$name])->first();
           return $meta_title;
        }
        
        public function index(){
          $meta_title= $this->childTitle();
         	return view('admin.amaster.organization.address.index',compact('meta_title'));
         }


         public function typeList(){
    
             $type_list=AddressType::all();
             return view('admin.amaster.organization.address.type_list',compact('type_list'));
           }

         public function store(Request $request)
         {  
          $validator = Validator::make($request->all(),[
            'name' => 'required|unique:org_address_type|max:255',
          ]); 
         
          if($validator->passes()){
            $user_id = Auth::guard('admin')->user()->id;
            $type = AddressType::create([
              'name' => $request->name,
              'created_by' => $user_id
            ]);

            
           $type->masterIds()->create([
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

         public function update(Request $request)
         {  
          $validator = Validator::make($request->all(),[
            'name' => 'required|unique:org_address_type,name,'.$request->id, 
          ]); 
          if($validator->passes()){
            $addressType = AddressType::find($request->id);
            $addressType->update(['name'=>$request->name]);
            $addressType->masterIds()->create([
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
             AddressType::find($id)->update(['status'=>$status]);

             return response()->json(['success'=>'Address Type Successfully Changed  Status!']);



         }





}
