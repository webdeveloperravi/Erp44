<?php

namespace App\Http\Controllers\Store\StockLedger;
 
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller; 
use App\Model\Store\StockLedger\CurrentLedger;

class CurrentLedgerController extends Controller
{
    public function index(){
        
        $authUser = UserStore::find(auth('store')->user()->id);
        $stockLedgers = CurrentLedger::with('userIssue','userReceipt')
                        ->where('from',$authUser->id)
                       ->orWhere('to',$authUser->id)
                       ->latest()
                       ->get()->reject(function($ledger){
            if($ledger->voucher_type == '2'){
                return false;
            }elseif($ledger->voucher_type == '4'){
            
                return false;
            } else{
                return true;
            }
        }); 
        
        return view('store.StockLedger.CurrentLedger.index',compact('stockLedgers','authUser')); 
    } 
 

    public function details($id)
    {   
        $ledger = CurrentLedger::with('ledgerDetails')->where('id',$id)->first(); 
         
       
        return view('store.StockLedger.details',compact('ledger'));
    }
    
}
