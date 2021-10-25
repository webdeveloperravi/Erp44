<?php

namespace App\Http\Controllers\Warehouse\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ManagerChallan;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use PDF;
class ManagerChallanPacketController extends Controller
{    
    protected $productsCount = "";
    protected $packet ="";  

    public function index()
    {
        $challans = ManagerChallan::where('manager_id',auth('warehouse')->user()->id)->where('status','weight_complete')->orderBy('id','desc')->get();
        return view('warehouse.manager.packet.index',compact('challans'));
    }

    public function finish($id){
        
        $grade = ManagerChallan::where('invoice_detail_grade_id',$id)->first();
        $grade->update(['status'=> 'weight_complete']);
        // return redirect()->route('manager.challan.packet.all',$id);
        return response()->json('success',202);
    }
     
    public function all($gradeId)
    {   
        //Finish Weight Status on ManagerWeightChallan
        // $grade = ManagerChallan::where('invoice_detail_grade_id',$gradeId)->first();
        // $grade->update(['status'=> 'weight_complete']);
         
        $rattis =  $this->getRattis($gradeId); 
        $grade = InvoiceDetailGrade::find($gradeId);
        $challan = ManagerChallan::where('manager_id',auth('warehouse')->user()->id)->where('invoice_detail_grade_id',$gradeId)->first();

        return view('warehouse.manager.packet.all',compact('rattis','gradeId','grade','challan'));
    }

    public function getRattis($gradeId){
        $products = InvoiceDetailGradeProduct::where('invoice_detail_grade_id',$gradeId)->where('invoice_detail_grade_packet_id',0)->get()->pluck('ratti_id')->toArray();
        $products =  array_unique($products);
        return  $rattis = ProductMWeightRange::find($products); 
    }

    public function create($ratti_id,$gradeId){
        
        $products = InvoiceDetailGradeProduct::where('invoice_detail_grade_id',$gradeId)->where('ratti_id',$ratti_id)->get();
        $ratti = ProductMWeightRange::find($ratti_id);
        if(count($products) !== 0){
            return view('warehouse.manager.packet.create',compact('products','ratti_id','gradeId','ratti'));
        }else{
            return response()->json('no',201);
        }
    }
 
    public function store($rattiId,$gradeId)
    {   
        $products = $this->getProducts($rattiId,$gradeId);
        $this->productsCount = count($products);

        if($this->productsCount > 0){
           $this->packet =  $this->createPacket($rattiId,$gradeId,$this->productsCount);
           foreach($products as $product){
               
               $product->update(['invoice_detail_grade_packet_id'=> $this->packet->id,]);
            
            if($products->last() == $product) {
                // last iteration
                $products =  count($this->getProducts($rattiId,$gradeId));
                if($products > 0){
                    $this->store($rattiId,$gradeId);
                } 
            } 
           }
        // return redirect()->route('manager.challan.packet.list',$gradeId);
        
        return response()->json('success',202);
        }else{
            return redirect()->route('manager.challan.packet.list',$gradeId);
            // return "Completed";
        }
     }

     public function countPacketsLeftForReturning($gradeId)
     {  
        return InvoiceDetailGradePacket::where(['invoice_detail_grade_id'=> $gradeId,'return_to_super'=> 0])->count();
     }

    

    public function getProducts($rattiId,$gradeId){
        
        return InvoiceDetailGradeProduct::where(['invoice_detail_grade_id'=>$gradeId,'ratti_id'=>$rattiId])->where('invoice_detail_grade_packet_id',0)->limit(20)->get();
    }

    public function createPacket($rattiId,$gradeId, $piece){
         
        if(InvoiceDetailGradePacket::first()){
            $nmbr = InvoiceDetailGradePacket::latest()->first()->number+1;
        }else{
            $nmbr = 1001;
        }

        return $packet =  InvoiceDetailGradePacket::create([
            'number' => $nmbr,
            'invoice_detail_grade_id' => $gradeId, 
            'ratti_id' => $rattiId,
            'total_piece'=> $piece
        ]);
    } 

    public function listPackets($gradeId){

        $packets =  InvoiceDetailGradePacket::where('invoice_detail_grade_id',$gradeId)->get();
        
        return view('warehouse.manager.packet.list_packets',compact('packets','gradeId'));

    }

    public function returnToSuper($packetId)
    {
        // $invoiceDetailGrade = InvoiceDetailGrade::find($gradeId);
        $gradePacket = InvoiceDetailGradePacket::find($packetId);
        $gradePacket->update(['return_to_super' => 1]); 
        // if($this->countPacketsLeftForReturning($gradePacket->invoice_detail_grade_id) == 0 ){
        //     $challan = new ManagerChallan;
        //     if($challan->packetsComplete($gradePacket->invoice_detail_grade_id)){
                
        //     }
        // }
        $challan = new ManagerChallan;
        if(!$challan->weightComplete($gradePacket->invoice_detail_grade_id) && !$challan->packetsComplete($gradePacket->invoice_detail_grade_id)){
            if($challan->returnedToSuper($gradePacket->invoice_detail_grade_id)){
                ManagerChallan::where(['manager_id'=> auth('warehouse')->user()->id, 'invoice_detail_grade_id'=>$gradePacket->invoice_detail_grade_id])->update(['finsh'=> 1]); 
            }
        }

         
        return redirect()->back();
    } 

    public function printPacketLabel($packetId)
    {   
        
        try{
            // retreive all records from db
         $gradePacket = InvoiceDetailGradePacket::find($packetId); 
         view()->share('packet',$gradePacket);
         $pdf = PDF::loadView('warehouse.gradesort_product.printPacketlabel');
         
         // download PDF file with download method
         return $pdf->download('packet_'.$gradePacket->number.'.pdf');
         }catch(DOMPDF_Exception $e){
             echo '<pre>',print_r($e),'</pre>';
         }
    }


}
