<?php

namespace App\Model\Store\StockLedger;

use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Master\Voucher;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StockLedger\CurrentLedger;
 
 

class CurrentLedger extends Model
{
    protected $guarded = [''];
    protected $table = 'ledgers';

    public function ledgerDetails(){
        return $this->hasMany(LedgerDetail::class,'ledger_id','id');
    }

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'from','id'); 
    }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'to','id');
    } 

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable','statusable_type','statusable_id');
    }

    public function authGuard()
    {
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_type','id');
    }
    
    //Debit Credit Amount
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    //Debit Credit Piece
    public function getDebitPiece($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }
    
    public function getCreditPiece($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }
    
    //Amount Balance
    public function countDebitAmount($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId);
        $stockLedgers = CurrentLedger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = CurrentLedger::whereIn("id",$stockLedgers)
        ->where('created_at','<=',$ledger->created_at)
        ->where('voucher_type',2)
        ->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCreditAmount($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId); 
        $stockLedgers = CurrentLedger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = CurrentLedger::whereIn("id",$stockLedgers)
        ->where('created_at','<=',$ledger->created_at)
        ->where('voucher_type',2)
        ->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getBalanaceAmount($accountId,$ledgerId){
        
        $totalDebit = $this->countDebitAmount($accountId,$ledgerId);
        $totalCredit = $this->countCreditAmount($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Cr.";
        }else{
            return $totalCredit - $totalDebit." Dr.";
        }
    }
    
    //Piece Balance
    public function countDebitPiece($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId);
        $stockLedgers = CurrentLedger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = CurrentLedger::whereIn("id",$stockLedgers)
        ->where('created_at','<=',$ledger->created_at)
        ->where('voucher_type',2)
        ->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCreditPiece($accountId,$ledgerId){
        
        $ledger = CurrentLedger::find($ledgerId); 
        $stockLedgers = CurrentLedger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = CurrentLedger::whereIn("id",$stockLedgers)
        ->where('created_at','<=',$ledger->created_at)
        ->where('voucher_type',2)
        ->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getBalanacePiece($accountId,$ledgerId){
        
        $totalDebit = $this->countDebitPiece($accountId,$ledgerId);
        $totalCredit = $this->countCreditPiece($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Cr.";
        }else{
            return $totalCredit - $totalDebit." Dr.";
        }
    }
    
    //Total Amount Balance
    public function getTotalDebitAmount($accountId){
        
        $countCarat = CurrentLedger::where(['from'=>$accountId])
        ->where('voucher_type',2)
        ->get()
        ->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCreditAmount($accountId){
        
        $countCarat = CurrentLedger::where(['to'=>$accountId])
        ->where('voucher_type',2)->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalBalanceAmount($accountId){
        
       $totalDebit = $this->getTotalDebitAmount($accountId);
       $totalCredit = $this->getTotalCreditAmount($accountId);
       if($totalDebit > $totalCredit){
           return $totalDebit - $totalCredit." Dr.";
       }else{
        return $totalCredit - $totalDebit." Cr.";
       }
    }
    
    //Total Piece Balance
    public function getTotalDebitPiece($accountId){
        
        $countCarat = CurrentLedger::where(['from'=>$accountId])
        ->where('voucher_type',2)
        ->get()
        ->pluck('qty_total');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCreditPiece($accountId){
        
        $countCarat = CurrentLedger::where(['to'=>$accountId])
        ->where('voucher_type',2)->get()->pluck('qty_total');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalBalancePiece($accountId){
        
       $totalDebit = $this->getTotalDebitPiece($accountId);
       $totalCredit = $this->getTotalCreditPiece($accountId);
       if($totalDebit > $totalCredit){
           return $totalDebit - $totalCredit." Dr.";
       }else{
        return $totalCredit - $totalDebit." Cr.";
       }
    }

}
