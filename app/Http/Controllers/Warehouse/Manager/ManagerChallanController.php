<?php

namespace App\Http\Controllers\Warehouse\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ManagerChallan;
use App\Model\Warehouse\InvoiceDetailGrade;

class ManagerChallanController extends Controller
{
    
    public function index()
    {
         $challans =  ManagerChallan::with([
             'super:id,name',
             'invoiceDetailGrade.invoiceDetail.invoice:id,invoice_number',
             'invoiceDetailGrade.invoiceDetail.product:id,name',
             'invoiceDetailGrade.invoiceDetail.assign_product:id,name',
             'invoiceDetailGrade.grade:id,alias', 
             ])->where('manager_id',auth('warehouse')->user()->id)->latest()->get();
             $heading = 'Weight Challans';
         return view('warehouse.manager.challan.index',compact('challans','heading'));  
    }

    public function preview($id)
    {
        $challan =  ManagerChallan::with([
            'super:id,name',
            'super.role:id,name',
            'invoiceDetailGrade.invoiceDetail.invoice:id,invoice_number',
            'invoiceDetailGrade.invoiceDetail.product:id,name',
            'invoiceDetailGrade.invoiceDetail.assign_product:id,name',
            'invoiceDetailGrade.grade:id,alias', 
            ])->where(['manager_id'=>auth('warehouse')->user()->id,'id'=>$id])->first(); 
            // $heading = 'Weight Challans';
        return view('warehouse.manager.challan.preview',compact('challan'));
    }

    public function rejectChallan($challanId){
         
        $invoiceDetailId = ManagerChallan::where(['manager_id'=>auth('warehouse')->user()->id,'id'=>$challanId])->first()->invoice_detail_grade_id;  
          InvoiceDetailGrade::where('id',$invoiceDetailId)->update(['issue_to_manager'=>0]); 
         $challan =  ManagerChallan::find($challanId)->delete();  
         return redirect()->back();
    }

    public function acceptChallan($challanId)
    {
       return ManagerChallan::where('id',$challanId)->update(['accept_challan'=>1]);
    }
 
}
