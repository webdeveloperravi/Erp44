<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use App\Model\Store\StockLedger;
use App\Model\Store\PaymentLedger;
use App\Model\Warehouse\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGrade;

class MonitoryLedger extends Model
{   
    protected $guarded = [''];
    protected $table = "monitory_ledgers";
  
    public function stockLedger(){
        return $this->belongsTo(StockLedger::Class,'stock_ledger_id','id');
    }

    

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'debit_by','id');
    }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'credit_to','id');
    }
    
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = PaymentLedger::find($ledgerId);
        if($ledger->debit_by == auth('store')->user()->id){
            return $ledger->amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = PaymentLedger::find($ledgerId);
        if($ledger->credit_to == auth('store')->user()->id){
            return $ledger->amount;
        }else{
            return false;
        }
    }

    public function getValues($accountId,$ledgerId){
        
        $totalDebit = $this->countDebit($accountId,$ledgerId);
        $totalCredit = $this->countCredit($accountId,$ledgerId);
        // return $debit - $credit;

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Dr.";
        }else{
         return $totalCredit - $totalDebit." Cr.";
        }
    }

    public function countDebit($accountId,$ledgerId){
        
        
        $ledger = PaymentLedger::find($ledgerId);
        $paymentLedgers = PaymentLedger::where('credit_to',$accountId)->get()->pluck('id');
        // dd($paymentLedgers);
        
        $countCarat = PaymentLedger::whereIn("id",$paymentLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        // $countCarat = PaymentLedger::whereIn('id',$paymentLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        // dd($countCarat);
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;

    }

    public function countCredit($accountId,$ledgerId){
        
        
        $ledger = PaymentLedger::find($ledgerId);
        $paymentLedgers = PaymentLedger::where('debit_by',$accountId)->get()->pluck('id');
        // dd($paymentLedgers);
        
        $countCarat = PaymentLedger::whereIn("id",$paymentLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        // $countCarat = PaymentLedger::whereIn('id',$paymentLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        // dd($countCarat);
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;

    }
    

    public function getTotalDebit($accountId){
        
        $countCarat = PaymentLedger::where('credit_to',$accountId)->get()->pluck('amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        
        $countCarat = PaymentLedger::where('debit_by',$accountId)->get()->pluck('amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalBalance($accountId){
        
       $totalDebit = $this->getTotalDebit($accountId);
       $totalCredit = $this->getTotalCredit($accountId);
       if($totalDebit > $totalCredit){
           return $totalDebit - $totalCredit." Dr.";
       }else{
        return $totalCredit - $totalDebit." Cr.";
       }
    }
}
