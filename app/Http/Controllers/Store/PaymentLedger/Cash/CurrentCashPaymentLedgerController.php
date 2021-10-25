<?php

namespace App\Http\Controllers\Store\PaymentLedger\Cash;

use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use App\Model\Store\PaymentLedger\Cash\CurrentCashPaymentLedger;
 

 

class CurrentCashPaymentLedgerController extends Controller
{
    public function index(){
        
        $authUser = UserStore::find(auth('store')->user()->id);
        $paymentLedgers = CurrentCashPaymentLedger::where('from',$authUser->id)->orWhere('to',$authUser->id)->get()->reject(function($ledger){
            return $ledger->voucher_type != '5'; 
        }); 
        return view('store.PaymentLedger.Cash.CurrentLedger.index',compact('paymentLedgers','authUser')); 
    } 
 
 
    
}
