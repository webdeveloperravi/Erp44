<?php

namespace App\Http\Controllers\Admin\Organization;

use Auth;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Unit;
use App\Model\Admin\Organization\UnitConversion;

class UnitConversionController extends Controller
{
   
         public function index()
         {

             $unit_list=Unit::all();
         	return view('admin.amaster.organization.unit_conversion.index',compact('unit_list'));
         }

         public function getSubUnit($id)
         {

            $conversion_type_sub['sub']=Unit::where('id','!=',$id)->pluck('name','id');
            
            return response()->json($conversion_type_sub);

        }

          public function unitConversionList(){
 
        $unit_conv_list=UnitConversion::all();
        return view('admin.amaster.organization.unit_conversion.unit_conversion_list',compact('unit_conv_list'));
      

           }


        public function store(Request $request)
        {

         $validator = Validator::make($request->all(),[
            'main_unit' => "required|not_in:Select Unit",
            'sub_unit' => 'required',
            'conversion' =>'required'
        ]);
         
       if($validator->passes()){
                 
			$user_id = Auth::guard('admin')->id();
        $unit_conv_obj=new UnitConversion();
        $unit_conv_obj->unit_main_id=$request->main_unit;
        $unit_conv_obj->unit_sub_id=$request->sub_unit;
        $unit_conv_obj->conversion=$request->conversion;
        $unit_conv_obj->created_by=$user_id;
        $unit_conv_obj->save();
    
        
        $unit_conv_obj->masterIds()->create([
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

         public function edit($id)
        {
           
          $unit_conversion_edit=UnitConversion::where(['id'=>$id])->first();
          $unit=Unit::all();
          $sub_unit_edit=Unit::where('id','!=',$unit_conversion_edit->unit_main_id)->get();
         
         return view('admin.amaster.organization.unit_conversion.edit',compact('unit_conversion_edit','sub_unit_edit','unit'));


       

    }

    public function update(Request $request)
    {

      
      $validator = Validator::make($request->all(),[
         'main_unit' => "required|not_in:Select Unit",
         'sub_unit' => 'required',
         'conversion' =>'required'
     ]);
      
    if($validator->passes()){
              
     $unitConversion = UnitConversion::where('id',$request->id)->first();
     $unitConversion->update(['unit_main_id'=>$request->main_unit,'unit_sub_id'=>$request->sub_unit,'conversion'=>$request->conversion]);
     
     $unitConversion->masterIds()->create([
      'updated_id' =>Helper::getAdminId()
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
             UnitConversion::find($id)->update(['status'=>$status]);

             return response()->json(['success'=>'Unit Conversion Successfully Changed  Status!']);

          }


   
  



}
