<?php

namespace App\Http\Controllers\Store\PaymentLedger\Bank;

use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use App\Model\Store\PaymentLedger\Bank\CurrentBankPaymentLedger;
 
class CurrentBankPaymentLedgerController extends Controller
{
    public function index(){
        
        $authUser = UserStore::find(auth('store')->user()->id);
        $paymentLedgers = CurrentBankPaymentLedger::where('from',$authUser->id)->orWhere('to',$authUser->id)->get()->reject(function($ledger){
            return $ledger->voucher_type != '6'; 
        }); 
        return view('store.PaymentLedger.Bank.CurrentLedger.index',compact('paymentLedgers','authUser')); 
    }
    
    
}
