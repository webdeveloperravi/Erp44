<?php

namespace App\Http\Controllers\Store\PaymentLedger\Journal;

use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller; 
use App\Model\Store\PaymentLedger\Journal\CurrentJournalPaymentLedger;
 

 

class CurrentJournalPaymentLedgerController extends Controller
{
    public function index(){
        
        $authUser = UserStore::find(auth('store')->user()->id);
        $paymentLedgers = CurrentJournalPaymentLedger::where('from',$authUser->id)->orWhere('to',$authUser->id)->get()->reject(function($ledger){
            return $ledger->voucher_type != '7'; 
        }); 
        return view('store.PaymentLedger.Journal.CurrentLedger.index',compact('paymentLedgers','authUser')); 
    } 
 
 
    
}
