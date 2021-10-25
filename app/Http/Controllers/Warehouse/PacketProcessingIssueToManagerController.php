<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Model\Guard\UserWarehouse;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ManagerChallan;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Warehouse\InvoiceDetailGradePacket;

class PacketProcessingIssueToManagerController extends Controller
{
     
    public function create($packetId)
    {  
      $packet = InvoiceDetailGradePacket::find($packetId);  
    //   $users =  WarehouseUser::where('parent_id',auth('warehouse')->user()->role->id)->get();
      $users =  UserWarehouse::all();
      return view('warehouse.issue_to_manager.create',compact('users','packet'));
    }

    
    public function store(Request $request)
    {   
       
        $validator = Validator::make($request->all(),[
            'manager_id' => 'required',
            'date' => 'required', 
          ]); 

          if ($validator->passes()) {
        
            if(PacketProcessingChallan::first()){
              $challanNumber =  PacketProcessingChallan::latest()->first()->challan_number+1;
            }else{
              $challanNumber = 1001;
            }

        $packetProcessingChallan = PacketProcessingChallan::create([
            'manager_id' => $request->manager_id,
            'super_id' => auth('warehouse')->user()->id,
            'packet_id' => $request->packet_id,
            'challan_number' =>$challanNumber,
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
