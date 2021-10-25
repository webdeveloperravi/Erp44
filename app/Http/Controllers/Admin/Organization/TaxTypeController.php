<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Organization\TaxType;
use Auth; 
use Validator;
class TaxTypeController extends Controller
{
    
    public function index()
    {
         
        return view('admin.amaster.organization.tax_type.index');

    }

    public function taxTypeList(){
 
        $tax_type_list=TaxType::all();
        return view('admin.amaster.organization.tax_type.tax_type_list',compact('tax_type_list'));
      

    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:org_tax_type,name|max:255',
        ]);
         
        if($validator->passes()){

            $user_id = Auth::guard('admin')->id();
            $tax_type_obj=new TaxType();
            $tax_type_obj->name=$request->name;
            $tax_type_obj->created_by=$user_id;
            $tax_type_obj->save();

            //log  history
           $tax_type_obj->masterIds()->create([
          'created_id' => auth('admin')->user()->id
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
            'name' => 'required|unique:org_tax_type,name,'.$request->id,
        ]);
         
        if($validator->passes()){
            $taxType = TaxType::where('id',$request->id)->first();
            $taxType->update(['name'=>$request->name]);
            //log history
            $taxType->masterIds()->create([
                'updated_id' => auth('admin')->user()->id
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
             TaxType::find($id)->update(['status'=>$status]);

             return response()->json(['success'=>'Tax Type Successfully Changed  Status!']);



         }

}
