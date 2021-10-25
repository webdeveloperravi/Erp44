<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\HSNCode;
use App\Model\Admin\Organization\TaxRate;
use App\Model\Admin\Master\AssignHsnCodeRate;
use Validator;
use Auth;
use App\Helpers\Helper;

class HSNCodeController extends Controller
{
    
         public function index()
         {
         	$tax_rate=TaxRate::where(['status'=>1])->get();

          return view('admin.amaster.hsn_code.index',compact('tax_rate'));
         }

         public function view(){
         	$hsn_code=HSNCode::all();
         	return view('admin.amaster.hsn_code.hsn_code_list',compact('hsn_code'));

         }    

        public function store(Request $request){

          $validator = Validator::make($request->all(),[
            'hsn_code' => 'required|unique:hsn_codes,hsn_code|min:2',
             
        ]);
          
        if($validator->passes()){
                  
          $user_id= Auth::guard('admin')->id();
          $hsn_code=new HSNCode();
          $hsn_code->hsn_code = $request->hsn_code;
          $hsn_code->description = $request->description;
          $hsn_code->created_by = $user_id;
          $hsn_code->save();
 
          $hsn_code->masterIds()->create([
  
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
                $hsn_code_data = HSNCode::find($id)->first();
                $tax_rate=TaxRate::where(['status'=>1])->get();
                return view('admin.amaster.hsn_code.edit_hsn_code',compact('tax_rate','hsn_code_data'));

        } 
 
       public function update(Request $request){
           
        $validator = Validator::make($request->all(),[
          'hsn_code' => "required",
           
      ]);
        
      if($validator->passes()){
                
        $hsnCode = HSNCode::where(['id'=>$request->hsn_code_id])->first();
        $hsnCode->update(['hsn_code'=>$request->hsn_code,'description'=>$request->description]);
        $hsnCode->masterIds()->create([
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

       	    HSNCode::where(['id'=>$id])->update(['status'=>$status]);   
         
              return response()->json(['success'=>Helper::message_format('HSN Code Status Changed','success')],200);

       }

      // to open assign hsn code  tax rate 
     
     protected function assign_hsncode_rate($id,$hsncode)
     {

           $tax_rate=TaxRate::where(['status'=>1])->get();
           $assign_hsn_code_rate= $this->assign_hsn_code_rate_view($id);
         return view('admin.amaster.hsn_code.assign_hsn_code_rate',compact('tax_rate','hsncode','id','assign_hsn_code_rate'));

     }
   
     protected function assign_hsn_code_rate_view($id)
     { 
        $assign_hsn_rate = AssignHsnCodeRate::where(['hsn_code_id'=>$id,'status'=>1])->first();
        
       return $assign_hsn_rate;
        //return view('admin.amaster.hsn_code.assign_hsn_code_view',compact('assign_hsn_rate'));

     }

     protected function assign_rate_store(Request $request)
     {
          $validator = Validator::make($request->all(),[
            'tax_rate' => 'required|not_in:Select Tax Rate',
            'manual_date' => 'required|',
          ]);
          
          if($validator->passes()){
                    
            $user_id= Auth::guard('admin')->id();
            $assign_hsn_obj=new AssignHsnCodeRate();
            $assign_hsn_obj->hsn_code_id = $request->hsn_code_id;
            $assign_hsn_obj->tax_rate_id = $request->tax_rate;
            $assign_hsn_obj->created_date = $request->manual_date;
            $assign_hsn_obj->status = 1;
            $assign_hsn_obj->created_by = $user_id;
            $assign_hsn_obj->save();
            
            //log history
            
              $assign_hsn_obj->masterIds()->create([
              'created_id' =>Helper::getAdminId()
              ]);
          
              
          return response()->json(['success'=>true]); 
          
          }else{
              $keys = $validator->errors()->keys();
              $vals  = $validator->errors()->all();
              $errors = array_combine($keys,$vals);
              
              return response()->json(['errors'=>$errors]);
          } 
     }

     protected function assign_hsn_code_edit($id)
     {
              
              $assign_hsn_rate =   $this->assign_hsn_code_rate_view($id);
              $tax_rate=TaxRate::where(['status'=>1])->get();
 
              
            
            return view('admin.amaster.hsn_code.assign_hsn_code_rate_edit',compact('assign_hsn_rate','tax_rate'));  

     }

     protected function assign_hsn_code_update(Request $request)
     {
 
          $assign_hsn_rate=Validator::make($request->all(),[

            'tax_rate' => 'required|not_in:Select Tax Rate',
            'manual_date' => 'required|',
             ]);
         if($assign_hsn_rate->fails()){
           return response()->json(["message"=>$assign_hsn_rate->errors()->all()],401);
           }
        else
        {
                //to make log for while update hsn_code tax rate update.  
                AssignHsnCodeRate::where(['id'=>$request->id])->update(['status'=>0]);

                 $user_id= Auth::guard('admin')->id();
                 $assign_hsn_obj=new AssignHsnCodeRate();
                 $assign_hsn_obj->hsn_code_id = $request->hsn_code_id;
                 $assign_hsn_obj->tax_rate_id = $request->tax_rate;
                 $assign_hsn_obj->created_date = $request->manual_date;
                 $assign_hsn_obj->status = 1;
                 $assign_hsn_obj->created_by = $user_id;
                 $assign_hsn_obj->save();

                 $assign_hsn_obj->masterIds()->create([
                  'updated_id' =>Helper::getAdminId()
                  ]);
              
               
          return response()->json(['success'=>Helper::message_format('Assigned Tax Rate Updated','success')],200);

        }


     }

}
