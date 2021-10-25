<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\Ledger;
use App\Http\Controllers\Controller;

class PaymentLedgerController extends Controller
{
    public function index(Request $request){
         
        return view('store.payment_ledger.index');
    }
    
    //Issue Payment
    public function createIssuePayment(){
          
        $accounts = UserStore::all();
        return view('store.payment_ledger.issue_payment.create',compact('accounts'));
    }
    
    public function saveIssuePayment(Request $request){
        
        $issuePayment = Ledger::create([
            'debit_by' => auth('store')->user()->id, 
            'credit_to' => $request->credit_to,
            'amount' => $request->amount
        ]);
        return response()->json(['success' => true]);
    }
    
    //Receive Payment
    public function createReceivePayment(){

        $accounts = UserStore::all();
        return view('store.payment_ledger.receive_payment.create',compact('accounts'));
    }
    
    public function saveReceivePayment(Request $request)
    {
        
        $receivePayment = Ledger::create([
            'debit_by' => $request->debit_by,
            'credit_to' => auth('store')->user()->id,
            'amount' => $request->amount
        ]);
        return response()->json(['success' => true]);
    }

    //Ledger View

    public function view(){
        $accounts = UserStore::all();
        return view('store.payment_ledger.view',compact('accounts'));
    }

    public function all($accountId){
        
        // $paymentLedgers = Ledger::where(['debit_by'=>$accountId,'credit_to'=>auth('store')->user()->id])->where(['debit_by' => auth('store')->user()->id,'credit_to'=> $accountId])->get();
        $paymentLedgers = Ledger::where('debit_by',$accountId)->orWhere('credit_to',$accountId)->get();

        return view('store.payment_ledger.all',compact('paymentLedgers','accountId'));
    }

}
