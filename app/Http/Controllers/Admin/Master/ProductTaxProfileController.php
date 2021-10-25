<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductCategory as ProductType;
use App\Model\Admin\Master\ProductTaxProfile as TaxProfile;
use Session;
use Auth;
class ProductTaxProfileController extends Controller
{
  

    public function index()
    {
    	
        $productType =  ProductType::where('status',1)->pluck('name','hsn_code');
        
        //dd($productType);

        $tax = TaxProfile::all();
       
        return view('admin.amaster.tax_profile.index',compact('productType','tax'));
    }

   
    public function store(Request $request)
    {   

        $request->validate(['hsn_code'=>'required','igst'=>'required'],
                            ['hsn_code.required'=>'Choose the product']);

    
        if(TaxProfile::where(['hsn_code'=>$request->hsn_code])->exists())
        {
            
               Session::flash('error','This Tax Value Already exists');
               //dd("exist");
            
               return back();

        }

        $user_id = Auth::guard('admin')->id();
        $tax = new TaxProfile();
        $tax->fill($request->all());
        $tax->created_by = $user_id;
        $tax->save();

        return back();
    }

  
    public function status($id, $status)
    { 

          if($status==0)
          {
              $status=1;
          }
          else
          {
            $status=0;
          }
 
          TaxProfile::find($id)->update(['status'=>$status]);

        return back();
    }


  
     
    public function update(Request $request, $id)
    {
        //
    }

        
}
