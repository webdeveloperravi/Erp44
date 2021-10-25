<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\MakeType;
use App\Helpers\Helper;
use Session;
use Auth; 
use Validator;

class MakeTypeController extends Controller
{
    public function index(){
  	
  	return view('admin.amaster.maketypes.create');
    
    }
    
    public function makeTypeList(){
     
     $make_type_list = MakeType::all();
     return view('admin.amaster.maketypes.view',compact('make_type_list'));
    }

    public function store(Request $request)
    { 

    $validator = Validator::make($request->all(),[
      'name' => 'required', 
      'alias' => 'required',
      'description' => 'required'
     
      ]);
      
      if($validator->passes()){
              
        $make_type = new MakeType();
        $make_type->name = $request->name;
        $make_type->alias = $request->alias;
        $make_type->description = $request->description;
        $make_type->created_by = 1;
        $make_type->save(); 

        $make_type->masterIds()->create([
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
        
      //Validator

    $validator = Validator::make($request->all(),[
      'name' => 'required', 
      'alias' => 'required',
      'description' => 'required'
     
    ]);
    
    if($validator->passes()){
            
    
      $make_type_update = MakeType::find($request->id);
      
      $make_type_update->update([
        
        'name' => $request->name,
        'alias' => $request->alias,
        'description' => $request->description,
         ]);
         $make_type_update->masterIds()->create([
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

       	    MakeType::where(['id'=>$id])->update(['status'=>$status]);   
         
              return response()->json(['success'=>Helper::message_format('Status Changed','success')],200);
    }

}
