<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Model\Warehouse\ManagerPacket;
use App\Model\Guard\UserWarehouse;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Warehouse\PacketProcessingChallan;
use App\Model\Warehouse\InvoiceDetailGradePacket;

class PacketController extends Controller
{


    public function index()
    {
        $packets =  InvoiceDetailGradePacket::where('return_to_super',1)->where('authorization',1)->orderBy('updated_at','desc')->get();
    
        return view('warehouse.packet.index',compact('packets'));
    }

    public function issueToManager($packetId){

        $users =  UserWarehouse::where('id','!=',auth('warehouse')->user()->id)->get();
        $packet = InvoiceDetailGradePacket::find($packetId);
        return view('warehouse.packet.issue_to_manager',compact('users','packet'));
    }

    public function issueToManagerStore(Request $request){
        

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
         

        $managerPacket = PacketProcessingChallan::create([
            'manager_id' => $request->manager_id,
            'super_id' => auth('warehouse')->user()->id,
            'packet_id' => $request->packet_id,
            'challan_number' => $challanNumber,
            'status' => 'pending',
            'date' => $request->date ?? "No Date",
        ]);
        // $invoice =  InvoiceDetailGrade::where('id',$request->grade_id)->first();
        // $invoice->issue_to_manager = 1;
        // $invoice->save(); 
        
        if($managerPacket){
            return response()->json('success',200);
        }else{
           return response()->json('fail',400);
        }

        //  $managerPacket =   ManagerPacket::create([
        //      'manager_id' => $request->manager_id,
        //      'packet_id' => $request->packet_id,
        //      'date' => $request->date,
        //      'super_id' => auth('warehouse')->user()->id,
        //  ]);

         
    } 
}
}
