<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\ProductUnit;
use Auth;
use Session;
class ProductUnitController extends Controller
{
    
    public function index($id)
    {
        
       
        $unit = ProductUnit::where(['product_type_id'=>$id])->get();
        return view('admin.amaster.unit.index', compact('unit','id'));
    }

    

   
    public function store(Request $request)
    {
        
         $validatedData = $request->validate([

        'name'=>"required|unique:product_units|max:255",

    ]);
         
		$user_id = Auth::guard('admin')->id();
        $unit = new ProductUnit;
        $unit->name = $request->name;
        $unit->product_type_id = $request->product_type_id;
        $unit->created_by = $user_id;
        $unit->save();
        Session::flash("success"," Record Saved.");

        return back();
    }

    
    
    
    public function update(Request $request, $id)
    {
         dd(123);


        Session::flash("success"," Record Updated.");
    }

   
    
}
