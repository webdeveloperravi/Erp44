<?php

namespace App\Http\Controllers\Store\PaymentLedger\Cash;
 
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail; 
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;   
use App\Model\Store\PaymentLedger\Cash\StoreCheckManagerCashPaymentLedger;

class StoreCheckManagerCashPaymentLedgerController extends Controller
{
    public function index(Request $request){

        $managers = Helper::getManagersByTree();
         
        return view('store.PaymentLedger.Cash.StoreCheckManagerLedger.index',compact('managers')); 
    } 

    public function allTransactions($managerId)
    {
        $paymentLedgers = StoreCheckManagerCashPaymentLedger::
                                        where('from',$managerId)
                                        ->orWhere('to',$managerId)
                                        // ->whereIn('voucher_type','5') 
                                        ->get()->reject(function($ledger){
                                            return $ledger->voucher_type != '5'; 
                                        })
                                         ; 

        return view('store.PaymentLedger.Cash.StoreCheckManagerLedger.allTransactions',compact('paymentLedgers','managerId'));
    }
 
    
}
