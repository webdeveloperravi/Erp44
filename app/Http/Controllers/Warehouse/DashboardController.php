<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Model\Warehouse\Vendor;
use App\Model\Warehouse\Invoice;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetail; 
use App\Model\Warehouse\ManagerChallan;  
use App\Model\Admin\Master\ProductCategory;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Warehouse\PacketProcessingChallan;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
 


class DashboardController extends Controller
{
    public function index()
    {  
    //---------  Super Widgets ------------
    if(auth('warehouse')->user()->role->id == 1){
         //Draft Purchase Invoices
        $draftPurchaseInvoices = $this->countDraftInvoices();
        
        //Unauthorized Invoices
        $unauthorizedInvoices = $this->countUnauthorizedInvoices();

        //Completed Invoices
        $completedInvoices = $this->countCompletedInvoices();
        
        //Gradesort Pending Invoices 
        $gradesortPendingInvoices = Invoice::where('complete',1)->whereHas('invoiceDetail',function($query){
                                        $query->where('complete',0);   
                                    })->count(); 
        
        //Generate ID Pending Invoices  
        $generateIdPendingInvoices = Invoice::where('complete',1)->whereHas('invoiceDetail',function($query){
                                              $query->where('complete',1)->whereHas('gradesorts',function($q){
                                                    $q->where('generate_id',0);
                                              }); 
                                            })->count();  

        //Issue For Weight Pending 
        $notIssuedForWeight =  Invoice::whereHas('invoiceDetail',function($q){
                                        $q->whereHas('gradesorts',function($q){
                                            $q->where(['issue_to_manager'=>0,'generate_id'=>1]);
                                        });
                                    })->count();

        //Issued Weight Challans
        $issuedWeightChallans = ManagerChallan::withTrashed()->where('finsh',0)->count();      
        
        //Accept Weight Challan Packets
        $acceptWeightChallanPackets = InvoiceDetailGradePacket::where(['authorization'=>0,'return_to_super'=>1])->count();

        //Not Issued Packet Process
        $notIssuedPacketProcess  = InvoiceDetailGradePacket::where('authorization',1)->whereDoesntHave('packetChallans')->count();
        
        //PacketProessing Challan
        $packetProcessingChallans = PacketProcessingChallan::where('status','!=','return-to-super')->count();
        
        //Pending Process Packets To Accept
        $pendingProcessPacketsToAccept = PacketProcessingChallan::with('packet')->where(['authorization'=>0,'status'=>'return-to-super'])->count();
        
        //Final Packets
        $finalPackets = PacketProcessingChallan::where('authorization',1)->latest()->count();

        return view('warehouse.dashboard.index',compact(
            'draftPurchaseInvoices',
            'unauthorizedInvoices',
            'completedInvoices',
            'gradesortPendingInvoices',
            'generateIdPendingInvoices',
            'notIssuedForWeight',
            'issuedWeightChallans',
            'acceptWeightChallanPackets',
            'notIssuedPacketProcess',
            'packetProcessingChallans',
            'pendingProcessPacketsToAccept',
            'finalPackets', 
        ));

    }else{
         //---------  Manager Widgets ------------
         
        //Draft Purchase Invoices
        $draftPurchaseInvoices = $this->countDraftInvoices();
         
        //Completed Invoices
        $completedInvoices = $this->countCompletedInvoices();

        //Pending Weight Challans
        $weightChallans = ManagerChallan::with([
            'super:id,name',
            'invoiceDetailGrade.invoiceDetail.invoice:id,invoice_number',
            'invoiceDetailGrade.invoiceDetail.product:id,name',
            'invoiceDetailGrade.invoiceDetail.assign_product:id,name',
            'invoiceDetailGrade.grade:id,alias', 
        ])->where(['manager_id'=>auth('warehouse')->user()->id,'finsh'=>0])->latest()->count();
        
        //Weight Packets
        $managerChallansGradeIds = ManagerChallan::where(['manager_id'=> auth('warehouse')->user()->id])->pluck('invoice_detail_grade_id')->toArray();
        $managerWeightChallanPackets = InvoiceDetailGradePacket::where('return_to_super',1)->whereIn('invoice_detail_grade_id',$managerChallansGradeIds)->count();
        
        //Packet Process Challans
        $managerPacketProcessChallans =PacketProcessingChallan::with('packet','manager','super')->where('manager_id',auth('warehouse')->user()->id)
        ->where('status','!=','return-to-super')
        ->latest()->count();

        //    $managerFinalPackets = PacketProcessingChallan::with('packet')->where([
        //                                                     'manager_id',auth('warehouse')->user()->id,
        //                                                     'status'=>'return-to-super'
        //                                                     ])->count();

        $managerFinalPackets = InvoiceDetailGradePacket::whereHas('packetChallans',function($q){
                                        $q->where([
                                            'manager_id'=>auth('warehouse')->user()->id,
                                            'status'=>'return-to-super']);
                                    })->count();

        return view('warehouse.dashboard.index',compact(
            'draftPurchaseInvoices', 
            'completedInvoices', 
            'weightChallans',
            'managerWeightChallanPackets',
            'managerPacketProcessChallans',
            'managerFinalPackets'
        ));
    }
    }
        
    public function countDraftInvoices()
    {    
        if(auth('warehouse')->user()->role->id == 1){
            return Invoice::where('complete',0)->count(); 
        }else{
            return Invoice::where(['user_id_receive'=> auth('warehouse')->user()->id,'complete'=>0])->count(); 
        }
    }

    public function getDraftInvoices()
    {
        if(auth('warehouse')->user()->role->id == 1){
            return Invoice::where('complete',0)->get(); 
            }else{
            return Invoice::where(['user_id_receive'=> auth('warehouse')->user()->id,'complete'=>0])->get(); 
            }
    }

    public function countUnauthorizedInvoices()
    {    
        if(auth('warehouse')->user()->role->id == 1){
            return Invoice::where(['complete'=>1,'authorization'=>0])->count(); 
        }else{ }
    }

    public function countCompletedInvoices()
    {    
        if(auth('warehouse')->user()->role->id == 1){
            return Invoice::where(['complete'=>1,'authorization'=>1])->count(); 
        }else{
            return Invoice::where(['user_id_receive'=> auth('warehouse')->user()->id,'complete'=>1])->count(); 
        }
    }

    public function getCompletedInvoices()
    {
        if(auth('warehouse')->user()->role->id == 1){
            return Invoice::where('complete',1)->get(); 
            }else{
            return Invoice::where(['user_id_receive'=> auth('warehouse')->user()->id,'complete'=>1])->get(); 
            }
    } 

    

    public function pendingInvoices()
    {
        $invoices = $this->getDraftInvoices();
        $heading = "Draft Invoices";
        return view('warehouse.dashboard.invoice.invoice_list',compact('invoices','heading'));
    } 

    public function unauthorizedInvoices()
    {
        $invoices = $this->getUnauthorizedInvoices();
        $heading = "Unauthorized Invoices";
        return view('warehouse.dashboard.invoice.invoice_list',compact('invoices','heading'));
    }

    public function completedInvoices(){
        
        $invoices = $this->getCompletedInvoices(); 
        $heading = "Complete Invoices";
        return view('warehouse.dashboard.invoice.invoice_list',compact('invoices','heading'));
    }


    public function gradesortPendingInvoices()
    {
        $invoices = Invoice::where('complete',1)->whereHas('invoiceDetail',function($query){
                                $query->where('complete',0);   
                            })->get();
        $heading = "GradeSort Pending Invoices";
        return view('warehouse.dashboard.invoice.invoice_list',compact('invoices','heading'));
    }

    public function generateIdPendingInvoices()
    {
        $invoices = Invoice::where('complete',1)->whereHas('invoiceDetail',function($query){
            $query->where('complete',1)->whereHas('gradesorts',function($q){
                $q->where('generate_id',0);
            }); 
        })->get();
        $heading = "Generate ID Pending Invoices";
        return view('warehouse.dashboard.invoice.invoice_list',compact('invoices','heading'));
    }

    public function notIssuedToManagerInvoices()
    { 
        $invoices = Invoice::whereHas('invoiceDetail',function($q){
                                $q->whereHas('gradesorts',function($q){
                                         $q->where(['issue_to_manager'=>0,'generate_id'=>1]);
                                });
                            })->get();
        $heading = "Issue for Weight Pending Invoices";
        return view('warehouse.dashboard.invoice.invoice_list',compact('invoices','heading'));
    }

    public function challansForWeight()
    {  
        if(auth('warehouse')->user()->role->id == 1){
            $challans = ManagerChallan::withTrashed()->get(); 
            $heading = "Issued Weight Challans";
        }else{
            abort(403);
        }
       return view('warehouse.dashboard.challan.challans_for_weight',compact('challans','heading'));
    }

    public function packetProcessNotIssued()
    {
        $packets = InvoiceDetailGradePacket::where('authorization',1)->whereDoesntHave('packetChallans')->get();
        return view('warehouse.dashboard.challan.packetProcessNotIssued',compact('packets'));
    }

    public function packetProcessIssued()
    {
        $packets = InvoiceDetailGradePacket::whereHas('packetChallans')->get();
        return view('warehouse.dashboard.challan.packetProcessIssued',compact('packets'));
    }

    // public function packetProcessChallans(){
    //     $challans = PacketProcessingChallan::all();
    //     return view('warehouse.dashboard.challan.challans_for_packet_processing',compact('challans'));
    // }



    public function productPurchaseView($invoiceId){
        $invoice = Invoice::findOrFail($invoiceId);
         
        $products = ProductCategory::where(['status'=>1])->get();
        $vendors = Vendor::all(); 

        return view('warehouse.product_purchase.index',compact('products','vendors','invoice'));
    }

   


    // public function managerWeightCompleted()
    // {
    //     $challans = ManagerChallan::where('status','weight_complete')->get();
    //     return view('warehouse.dashboard.challan.weight_completed',compact('challans'));
    // }

//     public function managerWeightPending(){

//             $challans = ManagerChallan::where('status','in_progress')->get();

//    return view('warehouse.dashboard.challan.weight_completed',compact('challans'));

//     }

//     public function managerPacketProcessCompleted(){

//             $packets = InvoiceDetailGradePacket::all();

//    return view('warehouse.dashboard.packet_process.complete',compact('packets'));

//     }

    public function managerPacketProcessDetail($packet_id)
    {
             $invoiceDetailGradePacket = InvoiceDetailGradePacket::find($packet_id);
              
             $packetProcessDetail = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$invoiceDetailGradePacket->id])->get();
             return view('warehouse.dashboard.packet_process.detail',compact('packetProcessDetail'));
    }

    // public function managerPacketReturnSuperPending(){

    //         $packets = InvoiceDetailGradePacket::where(['return_to_super'=>0])->get();
   
    //      return view('warehouse.dashboard.packet_process.return_to_super',compact('packets'));
    // }
    
    // public function managerPacketReturnSuperCompleted(){

    //         $packets = InvoiceDetailGradePacket::where(['return_to_super'=>1])->get();
   
    //      return view('warehouse.dashboard.packet_process.return_to_super',compact('packets'));
    // }

    // public function issuedPackets(){

    //      $issuedPacketsSuper = PacketProcessingChallan::where('status','pending')->get();

    // return view('warehouse.dashboard.packet_process.issue_packets_super',compact('issuedPacketsSuper'));

    // }

    // public function ginCompleted(){

    //        $ginProducts = InvoiceDetailGradeProduct::where(['final'=>1])->get();

    //     return view('warehouse.dashboard.packet_process_gin.completed',compact('ginProducts'));
    // }
    
    public function managerWeightChallanPackets()
    {
        $managerChallansGradeIds = ManagerChallan::where(['manager_id'=> auth('warehouse')->user()->id])->pluck('invoice_detail_grade_id')->toArray();
        $managerWeightChallanPackets = InvoiceDetailGradePacket::where('return_to_super',1)->whereIn('invoice_detail_grade_id',$managerChallansGradeIds)->get();
        return view('warehouse.dashboard.managerPackets.index',compact('managerWeightChallanPackets'));
    }


    
}
