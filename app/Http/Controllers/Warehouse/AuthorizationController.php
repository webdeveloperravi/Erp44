<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Model\Warehouse\Invoice;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\PacketProcessingChallan;
use App\Model\Warehouse\InvoiceDetailGradePacket;

class AuthorizationController extends Controller
{
    public function index(){
       return view('warehouse.authorization.index');    
    }
    
    //Invoice
    public function invoiceIndex()
    {
       return view('warehouse.authorization.invoice.index');
    }

    public function invoices(){
        
        $invoices = Invoice::where(['authorization'=>0,'complete'=>'1'])->latest()->get();
        $heading = "Invoice Authorization";
        return view('warehouse.authorization.invoice.invoices',compact('invoices','heading'));
    }
    
    public function invoice($invoiceId){
        $invoice = Invoice::find($invoiceId);
        return view('warehouse.authorization.invoice.invoice',compact('invoice'));
    }

    public function invoiceAuthorize($invoiceId){
        $invoice = Invoice::where('id',$invoiceId)->first();
        $invoice->update(['authorization'=>1,'authorized_by'=> auth('warehouse')->user()->id]);
        return true;
    }
    
    //Weight Packet
    public function receivePacketIndex()
    {
       return view('warehouse.authorization.weightPacket.index');
    }

    public function receivePackets(){
        
        $packets = InvoiceDetailGradePacket::where(['authorization'=>0,'return_to_super'=>1])->latest()->get();
        return view('warehouse.authorization.weightPacket.receive_packets',compact('packets'));
    }

    public function  receivePacket($packetId){
        $packet = InvoiceDetailGradePacket::where('id',$packetId)->first();
        $packet->update(['authorization'=>1,'authorized_by'=> auth('warehouse')->user()->id]);
        return true;
    }
    
    //Packet Process
    public function packetProcessIndex()
    {
       return view('warehouse.authorization.packetProcess.index');
    }

    public function receivePacketProcess(){
        
        $packetProcessingChallans = PacketProcessingChallan::with('packet')->where(['authorization'=>0,'status'=>'return-to-super'])->latest()->get(); 
        return view('warehouse.authorization.packetProcess.receive_packet_process',compact('packetProcessingChallans'));
    }

    public function receivePacketProcess2($packetProcessingChallan){
         
        $packetProcessingChallan = PacketProcessingChallan::where('id',$packetProcessingChallan)->first(); 
        if($packetProcessingChallan){
            $packetProcessingChallan->update(['authorization'=>1,'authorized_by'=> auth('warehouse')->user()->id]);
        }
        return true;
    }
}
