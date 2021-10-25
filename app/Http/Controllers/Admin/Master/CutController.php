<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Cut;
use Auth;
use App\Helpers\Helper;
use Validator;

class CutController extends Controller
{
    public function index(){
      
      return view('admin.amaster.cut.create');

    }

    public function cutList(){
   
         $cut_list  = Cut::all();
         return view('admin.amaster.cut.view',compact('cut_list'));
     }
   

    public function store(Request $request){
    
      $validator = Validator::make($request->all(),[
        'name' => 'required', 
        'alias' => 'required',
        'description' => 'required'
         
    ]);
     
   if($validator->passes()){
             
    $cut = new cut();
    $cut->name = $request->name;
    $cut->alias = $request->alias;
    $cut->description = $request->description;
    $cut->created_by = 1;
    $cut->save();  

    $cut->masterIds()->create([
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
        'alias' => 'required',
        'description' => 'required'
         
    ]);
     
   if($validator->passes()){


      $cut_update = cut::find($request->id);
       
       $cut_update->update([
        'name' => $request->name,
        'alias' => $request->alias,
        'description' => $request->description,
         ]);
         $cut_update->masterIds()->create([
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

       	    cut::where(['id'=>$id])->update(['status'=>$status]);   
         
              return response()->json(['success'=>Helper::message_format('Status Changed','success')],200);
    }

}
