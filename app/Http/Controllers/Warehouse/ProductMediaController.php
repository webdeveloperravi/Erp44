<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductMediaController extends Controller
{
    
    public function index()
    {
        // $product = InvoiceDetailGradeProduct::where('gem',$gem)->first();
        return view('warehouse.media.index');
    }

  
    public function create($gin)
    {   
        $product = InvoiceDetailGradeProduct::where('gin',$gin)->first();
        // dd($product);
        return view('warehouse.media.create',compact('product'));
    } 
}
