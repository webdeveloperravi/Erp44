<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\PacketProcessingChallan;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class PacketProductController extends Controller
{
    public function index(){

        // $packets = InvoiceDetailGradePacket::where('return_to_super',1)->get(); 
        if(auth('warehouse')->user()->role->id == 1){
            $packetProcessChallans = PacketProcessingChallan::where('authorization',1)->latest()->get(); 
        }else{
            $packetProcessChallans = PacketProcessingChallan::where(['status'=>'return-to-super','manager_id'=>auth('warehouse')->user()->id])->latest()->get(); 
        }
    	return view('warehouse.packet_product.index',compact('packetProcessChallans')); 
    }

    public function products($packetId){
      
       $products = InvoiceDetailGradeProduct::where('invoice_detail_grade_packet_id',$packetId)->get();
       return view('warehouse.packet_product.products',compact('products'));

    }

    public function view($productId){
       
        $product = InvoiceDetailGradeProduct::find($productId);
        
    	return view('warehouse.packet_product.view',compact('product'));
    	
    }

}
