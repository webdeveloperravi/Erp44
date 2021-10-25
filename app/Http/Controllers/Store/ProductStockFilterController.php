<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductStockFilterController extends Controller
{
    public function index(){
         
        $products = Product::all();
        $grades = ProductMGrade::all();
        $rattis = ProductMWeightRange::all();

        return view('store.productStockFilter.index',compact('products','grades','rattis'));
    }  
 
    public function getProducts(Request $request)
    {      
        $products = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id','in_stock')
                                                ->with('product','productGrade','ratti') 
                                                ->when($request->product_id != 0 , function($query) use ($request) {
                                                        $query->where('product_id',$request->product_id);
                                                })
                                                ->when($request->grade_id != 0 , function($query) use ($request) {
                                                        $query->where('grade_id',$request->grade_id);
                                                })
                                                ->when($request->ratti_id != 0 , function($query) use ($request) {
                                                        $query->where('ratti_id',$request->ratti_id);
                                                })
                                                ->get();
        return view('store.productStockFilter.all',compact('products'));
    } 
}
