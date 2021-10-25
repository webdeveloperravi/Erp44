<?php

namespace App\Http\Controllers\Store\PaymentLedger;

use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use App\Model\Store\PaymentLedger\CurrentPaymentLedger;
 
 

 

class CurrentPaymentLedgerController extends Controller
{
    public function index(){
        
        $authUser = UserStore::find(auth('store')->user()->id);
        $paymentLedgers = CurrentPaymentLedger::where('from',$authUser->id)->orWhere('to',$authUser->id)->get()->reject(function($ledger){
            return  $ledger->voucher_type != "CSH"; 
        }); 
        return view('store.PaymentLedger.CurrentLedger.index',compact('paymentLedgers','authUser')); 
    } 
 
 
    
}
