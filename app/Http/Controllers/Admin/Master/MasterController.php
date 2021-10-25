<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Master;
use Validator;
use App\Helpers\Helper;
use Auth;

class MasterController extends Controller
{
   
public function index()
{
	 return view('admin.amaster.master.index');
}


public function master_list()
{
	 $master_list=Master::all();
  	 return view('admin.amaster.master.master_list',compact('master_list'));
}

public function store(Request $request){
         
   $validator = Validator::make($request->all(),[
      'name' => 'required|unique:masters,name|min:2',
      'description' => 'required',
  ]);
      
   if($validator->passes()){
            
      $user_id= Auth::guard('admin')->id();
      $master_obj=new Master();
      $master_obj->name = ucfirst($request->name);
      $master_obj->description = $request->description;
      $master_obj->created_by = $user_id;
      $master_obj->save();

      $master_obj->masterIds()->create([
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
      'name' => 'required',
      'description' => 'required',
  ]);
   
    if($validator->passes()){
           
     $master=Master::where(['id'=>$request->id])->first();
      $master->update(['name'=>$request->name,'description'=>$request->description]);
      $master->masterIds()->create([
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

protected function status($id,$status){
  
     if($status==1)
     {
        $status=0;
     }
     else
     {
         $status=1;
     }
     Master::where(['id'=>$id])->update(['status'=>$status]);
        return response()->json(['success'=>Helper::message_format('Status Changed ','success')],200);
}

}
