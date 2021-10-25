<?php

namespace App\Http\Controllers\Admin\Organization;

use Auth;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\DiscountRate;

class DiscountRateController extends Controller
{
       public function index(){

           return view('admin.amaster.organization.discountrate.index');
           
       }


         public function rateList(){
    
             $discount_list=DiscountRate::all();
            return view('admin.amaster.organization.discountrate.rate_list',compact('discount_list'));
      

         }

      public function store(Request $request)
      {  
        
          $validator = Validator::make($request->all(),[
            'name' => 'required|unique:org_discount_rate,name|max:255',
            'rate' => 'required|numeric|max:2',
        ]);
         
        if($validator->passes()){
            $user_id = Auth::guard('admin')->id();
            $discount_rate_obj=new DiscountRate();
            $discount_rate_obj->name=$request->name;
            $discount_rate_obj->rate=$request->rate;
            $discount_rate_obj->created_by=$user_id;
            $discount_rate_obj->save();
            return response()->json(['success'=>true]); 
          
        } 
        else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all();
         $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
          }
        
      }

      public function update(Request $request)
      {
        // dd($request->edit_rate);
         $dis = DiscountRate::find($request->id);
        $discountrate = Validator::make($request->all(),[
          'edit_name' => 'required|unique:org_discount_rate,name,'.$dis->id,
          'edit_rate' => 'required|numeric|digits:2',
          ]);

        if($discountrate->fails()){
          $keys = $discountrate->errors()->keys();
          $vals  = $discountrate->errors()->all();
          $errors = array_combine($keys,$vals);
         
         return response()->json(['errors'=>$errors]);
        }
        else
        {
        $dis->update(['name'=>$request->edit_name,'rate'=>$request->edit_rate]);
          return response()->json(['success'=>Helper::message_format('Organization Role Discount Rate Updated','primary')],200);
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
          DiscountRate::find($id)->update(['status'=>$status]);
          return response()->json(['success'=>Helper::message_format('Organization Role Discount Rate Status  Changed','success')],200);
      }
  }
