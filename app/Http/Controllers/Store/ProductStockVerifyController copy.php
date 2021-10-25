<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductStockVerifyController extends Controller
{
    public function index(){
         
        $products = Product::all();
        $grades = ProductMGrade::all();
        $rattis = ProductMWeightRange::all();

        return view('store.productStockVerify.index',compact('products','grades','rattis'));
    }

    public function getProducts(Request $request){
        
        $product = Product::find($request->product_id);
        $grade = ProductMGrade::find($request->grade_id);
        $ratti = ProductMWeightRange::find($request->ratti_id);

        $verifiedProducts = InvoiceDetailGradeProduct::where([
                    'product_id' => $request->product_id, 
                    'grade_id' => $request->grade_id,
                    'ratti_id' => $request->ratti_id,
                    'verified' => '1'
                    ])->get();

        $unVerifiedProducts = InvoiceDetailGradeProduct::where([
                    'product_id' => $request->product_id, 
                    'grade_id' => $request->grade_id,
                    'ratti_id' => $request->ratti_id,
                    'verified' => '0'
                    ])->get();

        return view('store.productStockVerify.all',compact('verifiedProducts','unVerifiedProducts','product','grade','ratti'));
    }

    public function verify(Request $request){
        
        
        $verifiedProduct = InvoiceDetailGradeProduct::where([
            'product_id' => $request->product_id, 
            'grade_id' => $request->grade_id,
            'ratti_id' => $request->ratti_id,
            'gin' => $request->gin
        ])->first();
        if($verifiedProduct){
           $verifiedProduct->update(['verified' => '1']);
           Session::flash('success_msg', " SuccessFully Verified".$verifiedProduct->gin);
           return response()->json(['success'=> true]);
        }else{
           $unVerifiedProduct = InvoiceDetailGradeProduct::where('gin',$request->gin)->first();
           if($unVerifiedProduct){
            Session::flash('error_msg', "Product Not Match".$unVerifiedProduct->gin); 
            return response()->json(['failed'=> true]);
           }else{
            Session::flash('not_found', "Product Not Found"); 
            return response()->json(['notFound'=> true]);  
           }
        }
    }
}
