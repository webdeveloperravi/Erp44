<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ManagerChallan;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Guard\UserWarehouse;

class IssueToManagerController extends Controller
{
    
    public function create($grade_id)
    {  
      $grade = InvoiceDetailGrade::find($grade_id);   
      $users =  UserWarehouse::where('id','!=',auth('warehouse')->user()->id)->get();
      return view('warehouse.issue_to_manager.create',compact('users','grade'));
    }

     
    public function store(Request $request)
    {   
       
        $validator = Validator::make($request->all(),[
            'manager_id' => 'required',
            'date' => 'required', 
          ]); 
          
          
          if ($validator->passes()) {
           
            if(ManagerChallan::first()){
                $challanNumber =  ManagerChallan::latest()->first()->challan_number+1;
              }else{
                $challanNumber = 1001;
              }
         
         
        $managerChallan = ManagerChallan::create([
            'manager_id' => $request->manager_id,
            'super_id' => auth('warehouse')->user()->id,
            'invoice_detail_grade_id' => $request->grade_id,
            'challan_number' => $challanNumber,
            'status' => 'pending',
            'date' => $request->date ?? "No Date",
        ]);
        $invoice =  InvoiceDetailGrade::where('id',$request->grade_id)->first();
        $invoice->issue_to_manager = 1;
        $invoice->save(); 
        
        return response()->json("success",200);
    }else{
        return response()->json(["error"=> $validator->errors()->all()],200);
    }
 
}
}
