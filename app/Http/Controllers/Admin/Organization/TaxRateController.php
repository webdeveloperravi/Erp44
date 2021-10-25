<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Organization\TaxRate;
use App\Model\Admin\Organization\TaxType;
use Auth;
use Validator;

class TaxRateController extends Controller
{
   

    public function index()
    {
        $tax_type=TaxType::all();
        return view('admin.amaster.organization.tax_rate.index',compact('tax_type'));
    }

    public function taxRateList(){
            
            $tax_rate_list=TaxRate::all();
            return view('admin.amaster.organization.tax_rate.tax_rate_list',compact('tax_rate_list'));

    }

    public function store(Request $request)
    {    
       
    $validator = Validator::make($request->all(),[
      'tax_type' => 'required|not_in:Select Tax Type',
      'rate' => 'numeric|min:2|max:75' 
     
    ]);
     
    if($validator->passes()){
       dd(123);
        $user_id = Auth::guard('admin')->id();
        $tax_rate_obj=new TaxRate();
        $tax_rate_obj->org_tax_type_id=$request->tax_type;
        $tax_rate_obj->rate=$request->rate;
        $tax_rate_obj->created_by=$user_id;
        $tax_rate_obj->save();
       
        $tax_rate_obj->masterIds()->create([
   
            'created_id' => auth('admin')->user()->id,

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
          $tax_rate_edit=TaxRate::where('id',$id)->first();
          $tax_type=TaxType::all();
         return view('admin.amaster.organization.tax_rate.edit',compact('tax_rate_edit','tax_type'));
     }

    public function update(Request $request)
    {  
      $validator = Validator::make($request->all(),[
        'tax_type' => 'required|not_in:Select Tax Type',
        'rate' => 'required|numeric|digits:2',
      ]);
       
      if($validator->passes()){
         
       $taxRate =  TaxRate::find($request->id)->first();
       $taxRate->update(['org_tax_type_id'=>$request->tax_type,'rate'=>$request->rate]);
        $taxRate->masterIds()->create([
   
            'updated_id' => auth('admin')->user()->id,

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
             TaxRate::find($id)->update(['status'=>$status]);

             return response()->json(['success'=>'Tax Rate Successfully Changed  Status!']);



         }


    




}
