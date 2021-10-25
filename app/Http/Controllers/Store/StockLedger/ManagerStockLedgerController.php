<?php

namespace App\Http\Controllers\Store\StockLedger;
 
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail; 
use App\Model\Admin\Master\Product;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller; 
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Store\StockLedger\ManagerStockLedger;

class ManagerStockLedgerController extends Controller
{
    public function index(Request $request)
    {
        $managers = Helper::getManagersByTree();
        return view('store.StockLedger.ManagerStockLedger.index',compact('managers')); 
    } 

    public function all($managerId)
    {
        $stockLedgers = ManagerStockLedger::with('userIssue','userReceipt')
                          ->where('from',$managerId)
                          ->orWhere('to',$managerId)
                          ->latest()
                          ->get()->reject(function($ledger){
            return $ledger->voucher_type != '2'; 
        })
         ; 
        return view('store.StockLedger.ManagerStockLedger.all',compact('stockLedgers','managerId'));
    }

    public function details($id)
    {   
        $ledger = ManagerStockLedger::with('ledgerDetails')->where('id',$id)->first();
       
        return view('store.StockLedger.details',compact('ledger'));
    }
    
}
