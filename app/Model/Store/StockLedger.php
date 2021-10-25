<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use App\Model\Store\StockLedger;
use App\Model\Store\MonitoryLedger;
use App\Model\Store\StockLedgerDetail;
use App\Model\Warehouse\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGrade;

class StockLedger extends Model
{   
    protected $guarded = [''];
    protected $table = "stock_ledgers";
  
    public function stockLedgerDetails(){
        return $this->hasMany(StockLedgerDetail::class,'stock_ledger_id','id');
    }

    public function monitoryLedger(){
        return $this->hasOne(MonitoryLedger::class,'stock_ledger_id','id');
    }

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'debit_by','id');
    }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'credit_to','id');
    } 

    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = StockLedger::find($ledgerId);
        if($ledger->debit_by == auth('store')->user()->id){
            return $ledger->qty;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = StockLedger::find($ledgerId);
        if($ledger->credit_to == auth('store')->user()->id){
            return $ledger->qty;
        }else{
            return false;
        }
    }

    public function getValues($accountId,$ledgerId){
        
        $totalDebit = $this->countDebit($accountId,$ledgerId);
        $totalCredit = $this->countCredit($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }

    public function countDebit($accountId,$ledgerId){
        
        $ledger = StockLedger::find($ledgerId);
        // $stockLedgers = StockLedger::where('credit_to',$accountId)->get()->pluck('id');
        $stockLedgers = StockLedger::where(['credit_to'=>$accountId,'debit_by'=>auth('store')->user()->id])->get()->pluck('id');
        
        $countCarat = StockLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        
        $ledger = StockLedger::find($ledgerId);
        // $stockLedgers = StockLedger::where('debit_by',$accountId)->get()->pluck('id');
        $stockLedgers = StockLedger::where(['debit_by'=>$accountId,'credit_to'=>auth('store')->user()->id])->get()->pluck('id');
        
        $countCarat = StockLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;

    }
    

    public function getTotalDebit($accountId){
        
        $countCarat = StockLedger::where(['credit_to'=>$accountId,'debit_by'=>auth('store')->user()->id])->get()->pluck('qty');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }
    

    public function getTotalCredit($accountId){
        
        $countCarat = StockLedger::where(['debit_by'=>$accountId,'credit_to'=>auth('store')->user()->id])->get()->pluck('qty');
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
