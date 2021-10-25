<?php

namespace App\Http\Controllers\Admin\Master;

use App\Model\Admin\Organization\Unit;
use App\Model\Admin\Master\ProductCategoryMaster;

  use App\Http\Controllers\Controller;
  use App\Model\Admin\Master\ProductCategory;
  use Illuminate\Http\Request;
  use App\Model\Admin\Master\ProductTaxProfilea as TaxProfile;
    use App\Model\Admin\Master\ProductCategoryUnit;
  use App\Model\Admin\Master\Master;
  use Auth;
  use Session;
  use Validator;

class ProductCategoryController extends Controller
{
    
   public function index()
      {
       $unit=Unit::where('status',1)->get();
        $masters=Master::where('status',1)->get();
        return view('admin.amaster.product_category.index',compact('unit','masters'));
        
      }
  
   public function productCategoryList()
         {
            $product_type =  ProductCategory::all();
            return view('admin.amaster.product_category.list',compact('product_type'));
         }

   public function store(Request $request)
    {    
      $validator = Validator::make($request->all(),[
        'name' => 'required|unique:product_category|max:255',
        // 'image' => 'required|image:mimes:jpeg,jpg,png,gif.svg|max:3072',
        'alias' => 'required'
        ]);
        
      if($validator->passes()){
                
        $user_id = Auth::guard('admin')->id();
        $ptype =  new ProductCategory();
        $ptype->name = $request->name;
        $ptype->created_by = $user_id;
        $ptype->alias = $request->alias;
        if($request->hasFile('image')){
          $files = $request->file('image');
          $destinationPath = 'admin/image/product_type'; // upload path
          $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
          $files->move($destinationPath, $profilefile);
          $image = "image/product_type/".$profilefile;
          $ptype->image = $image;
        }
       $ptype->save();
      //  if($request->master){
      //    foreach ($request['masters'] as $value) {
      //      $ptype->masters()->attach($value);
      //    }
      //    }
       return response()->json(['success'=>true]); 
        
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
      } 
    }

    public function status($id,$status){

      if($status==1)
      {
        $status=1;

      }
      else
      {
        $status=0;
      }
      ProductCategory::where(['id'=>$id])->update(['status'=>$status]);
       
    }
  
  public function edit($id)
  {
  

    $product_edit=  ProductCategory::find($id);
    $product_type = ProductCategory::find($id);

     
    $masters = Master::where(['status'=>1])->get();
         
          return view('admin.amaster.product_category.edit',compact('product_edit','masters'));

  }
  
    
    public function update(Request $request)
    {
           
         
           $product_type_id=$request->product_type_id;  // get color  id

         // validation is part

         $validatedData = $request->validate([

        'name' => "required|unique:product_category,name,$product_type_id",
        // 'hsn_code' => "required|unique:product_category,hsn_code,$product_type_id",
    ]);
     
  
          
          if (!$request->hasFile('image')) {
               
                $pro_update= ProductCategory::where(['id'=>$request->product_type_id])->update(['name'=>$request->name,'image'=>$request->preview_image,'alias'=>$request->alias]);
                 Session::flash("success"," Record Updated.");
                
                $product_type_id=ProductCategory::where(['id'=>$request->product_type_id])->first();
               
          //       if($request->masters!=''){

          //        foreach ($request['masters'] as $value) {
           
          //  $product_type_id->masters()->detach();

                
          //      }

          //        foreach ($request['masters'] as $value) {
           
          //  $product_type_id->masters()->attach($value);

                
          //      }
          //    }
                return redirect('admin/product-category');

          }

          else
          {
           
          
           $files = $request->file('image');
            $destinationPath = 'admin/image/product_type'; // upload path
            $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilefile);
            $image = "image/product_type/".$profilefile;
            $ptype = $image;

             $pro_update= ProductCategory::where(['id'=>$request->product_type_id])->update(['name'=>$request->name,'image'=>$image, 'alias'=>$request->alias]);
               $product_type_id=ProductCategory::where(['id'=>$request->product_type_id])->first();
              Session::flash("success"," Record Updated.");
            //       if($request->masters!=''){
            //   foreach ($request['masters'] as $value) {
            //    $product_type_id->masters()->detach();
            //  }
            //   foreach ($request['masters'] as $value) {
            //   $product_type_id->masters()->attach($value);
            //    }
            //  }
         
              return redirect('admin/product-category');
          }

        
    }

    
    public function destroy($id)
    {
       
        ProductCategory::where('id', $id)->delete();      
        return back();
    }

   protected function showAssignUnAssignUnit($id,$assign)
   {
    
      $pro_cat_unit=ProductCategoryUnit::where(['pro_cat_id'=>$id,'status'=>1])->get(); 
      $pro_cat_info=ProductCategory::where(['id'=>$id])->first();     
      $units = Unit::all();
      return view('admin.amaster.product_category.unit_assign',compact('pro_cat_info','units','assign','pro_cat_unit'));

   } 

  //  protected function unitAssigned($id,$assign)
  //  {   
  //           if($assign==1)
  //           {
  //            return $this->showAssignUnAssignUnit($id,$assign);        
  //           }
  //           else
  //           {
  //           return  $this->showAssignUnAssignUnit($id,$assign);     
  //           }

  // }

  // protected function storeUnit(Request $request)
  //  {
  //       if($request->assign==0)
  //       {
  //         foreach ($request['unit'] as $value) {
  //          $cat_unit = new ProductCategoryUnit();
  //          $cat_unit->pro_cat_id=$request->pro_cate_id;  
  //          $cat_unit->unit_id=$value; 
  //          $cat_unit->created_by=1;
  //          $cat_unit->save();
  //          }
  //          $pro_cat_info=ProductCategory::where(['id'=>$request->pro_cate_id])->update(['assign'=>1]);
  //          return response()->json('Saved');   
  //       }
  //       else
  //       {
  //          ProductCategoryUnit::where(['pro_cat_id'=>$request->pro_cate_id])->update(['status'=>0]);
  //         foreach ($request['unit'] as $val) {
         
  //          $cat_unit = new ProductCategoryUnit();
  //          $cat_unit->pro_cat_id=$request->pro_cate_id;  
  //          $cat_unit->unit_id=$val; 
  //          $cat_unit->created_by=1;
  //          $cat_unit->save();

  //          } 
  //         return response()->json('Updated');
  //       }

 //  }  

  // MasterAttach View
  public function masterAttachView($productCatogyId){
     
    $productCategory = ProductCategory::with('masters')->where('id',$productCatogyId)->first(); 
    $productCategoryMasterIds = ProductCategoryMaster::where('product_types_id',$productCatogyId)->pluck('masters_id')->toArray();
    $masters=Master::whereNotIn('id',$productCategoryMasterIds)->get();
   return view('admin.amaster.product_category.masterAttach',compact('productCategory','masters'));
  }

  // Attched Master To ProductCategory
  public function masterAttach(Request $request){
   $productCategory = ProductCategory::find($request->productCategoryId);
   $productCategory->masters()->detach();
   $productCategory->masters()->attach($request->masters);
   return response()->json(['success'=> true],200);
  
    }

    // UnitAttach View
    public function unitAttachView($productCatogyId){
     
      $productCategory = ProductCategory::with('units')->where('id',$productCatogyId)->first(); 
      $productCategoryUnitIds = ProductCategoryUnit::where('pro_cat_id',$productCatogyId)->pluck('unit_id')->toArray();
      $units=Unit::whereNotIn('id',$productCategoryUnitIds)->get();
     return view('admin.amaster.product_category.unitAttach',compact('productCategory','units'));
    }
  
    // Attched Unit To ProductCategory
    public function unitAttach(Request $request){
     $productCategory = ProductCategory::find($request->productCategoryId);
     $productCategory->units()->detach();
     $productCategory->units()->attach($request->units);
     return response()->json(['success'=> true],200);
    
      }  
     

}
