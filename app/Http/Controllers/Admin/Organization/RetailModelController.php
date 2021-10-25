<?php

namespace App\Http\Controllers\Admin\Organization;

use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\RetailType;
use App\Model\Admin\Organization\RetailModel;
use App\Model\Admin\Organization\DiscountRate;

class RetailModelController extends Controller
{
    
     public function index(){
    
    
      return view('admin.amaster.organization.retail_model.index');
      
       }

      public function create(){

      $retail_types   = RetailType::all();
      $discount_rates = DiscountRate::all();
      
      $retail_model_list  = RetailModel::all();
      return view('admin.amaster.organization.retail_model.create',compact('retail_types','discount_rates','retail_model_list'));
       }

       public function showParentList(){

        return view('admin.amaster.organization.retail_model.retail_model_parent_list',compact('retail_model_list'));
       }

      public function view(){
       $retailModels  = RetailModel::where('parent_id',0)->get();
      return view('admin.amaster.organization.retail_model.retail_model_list',compact('retailModels'));
            } 

      public function oneView($id){
        $retailModel = RetailModel::find($id);
        return view('admin.amaster.organization.retail_model.view',compact('retailModel'));
      }

      protected function store(Request $request){
     
             
        
          $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'alias' => 'required',
            'description' => 'required',
            'retailType' => 'required|not_in:0',
            'discountRate' => 'required|not_in:0',
          ]);

          

          if($validator->passes()){
  
           $retailModel = RetailModel::create([
               'name' => $request->name,
               'alias' => $request->alias,
               'description' => $request->description,
               'parent_id' => $request->parentId ?? 0, 
               'retail_type_id' => $request->retailType,
               'discount_id' => $request->discountRate,
           ]); 

           $retailModel->masterIds()->create([
            'created_id' => Helper::getAdminId()
          ]);
          return response()->json(['success'=> true],200);
        }else{
         $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
     }
          
      }

      public function edit($id){
      
      $retailModel = RetailModel::find($id);
      
      if($retailModel->parent_id == 1){
        $discountRates = DiscountRate::orderBy("rate","desc")->get();
      }else{
        $retailModelParent = RetailModel::find($retailModel->parent_id);
        $parentDiscount = $retailModelParent->discount->rate ?? 0;
       
        if($parentDiscount !== 0){
          $discountRates = DiscountRate::where('rate','<',$parentDiscount)->orderBy("rate","desc")->get();
          // dd($discountRates);
        }else{
          $discountRates = DiscountRate::orderBy("rate","desc")->get();
        }
      }
      
   

      $retailTypes   = RetailType::all(); 
      $retailModels = RetailModel::where('parent_id','<',$retailModel->id)->get();

      return view('admin.amaster.organization.retail_model.edit',compact('retailModel','retailTypes','discountRates','retailModels'));
      }

      public function update(Request $request){
           
         
        $validator = Validator::make($request->all(), [
          'name' => 'required', 
            'alias' => 'required',
            'description' => 'required',
            'retailType' => 'required|not_in:0',
            'discountRate' => 'required|not_in:0',
        ]);

        if($validator->passes()){
         $retailModel = RetailModel::where('id',$request->retailModelId)->first();
         $retailModel->update([
             'name' => $request->name,
             'alias' => $request->alias,
             'description' => $request->description,
             'parent_id' => $request->parentId ?? 0,
             'retail_type_id' => $request->retailType,
             'discount_id' => $request->discountRate,
         ]); 
         
 $retailModel->masterIds()->create([
  'updated_id' => Helper::getAdminId()
]);

        return response()->json(['success'=> true],200);
      }else{
       $keys = $validator->errors()->keys();
   $vals  = $validator->errors()->all();
   $errors = array_combine($keys,$vals);
  
  return response()->json(['errors'=>$errors]);
   }

   }

   public function getDiscountRates($id){
   
    if($id == 1){
      $discountRates = DiscountRate::orderBy("rate","desc")->get();
    }else{
      $retailModelParent = RetailModel::find($id);
      $parentDiscount = $retailModelParent->discount->rate ?? 0;
    
      if($parentDiscount !== 0){
        $discountRates = DiscountRate::where('rate','<',$parentDiscount)->orderBy("rate","desc")->get(); 
      }else{
        $discountRates = DiscountRate::orderBy("rate","desc")->get();
      }
    }

      return view('admin.amaster.organization.retail_model.getdiscountrates',compact('discountRates')); 
   }

   public function statusUpdate($id){
            
    $role = RetailModel::where('id',$id)->first();
    // dd($role);
    if($role->status == 0){
        $status = 1;
    }else{
        $status = 0;
    }
    $role->update([
        'status' => $status,
       ]); 
       return response()->json(['success'=>Helper::message_format('Status updated','success')],200);
}

 }
