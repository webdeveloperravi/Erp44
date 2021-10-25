<?php

namespace App\Http\Controllers\Store\PaymentLedger\Bank;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller; 
use App\Model\Store\PaymentLedger\Bank\StoreCheckManagerBankPaymentLedger;
 

class StoreCheckManagerBankPaymentLedgerController extends Controller
{
    public function index(Request $request){

        $managers = Helper::getManagersByTree();
         
        return view('store.PaymentLedger.Bank.StoreCheckManagerLedger.index',compact('managers')); 
    } 

    public function allTransactions($managerId)
    {
        $paymentLedgers = StoreCheckManagerBankPaymentLedger::
                                        where('from',$managerId)
                                        ->orWhere('to',$managerId) 
                                        ->get()->reject(function($ledger){
                                            return $ledger->voucher_type != '6'; 
                                        })
                                        ; 

        return view('store.PaymentLedger.Bank.StoreCheckManagerLedger.allTransactions',compact('paymentLedgers','managerId'));
    }
 
    
}
