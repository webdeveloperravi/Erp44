<?php

namespace App\Model\Store\StockLedger;

use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Master\Voucher;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StockLedger\ManagerStockLedger;

class ManagerStockLedger extends Model
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
    
    //Amount Debit Credit
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }

    //Piece Debit Credit
    public function getDebitPiece($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }
    
    public function getCreditPiece($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }
    
    //Balance Amount
    public function countDebitAmount($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId);
        $stockLedgers = ManagerStockLedger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = ManagerStockLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCreditAmount($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId); 
        $stockLedgers = ManagerStockLedger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = ManagerStockLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("total_amount")->all();
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
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }

    //Balance Piece
    public function countDebitPiece($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId);
        $stockLedgers = ManagerStockLedger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = ManagerStockLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCreditPiece($accountId,$ledgerId){
        
        $ledger = ManagerStockLedger::find($ledgerId); 
        $stockLedgers = ManagerStockLedger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = ManagerStockLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
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
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }


    
    //Total Amount
    public function getTotalDebitAmount($accountId){
        
        $countCarat = ManagerStockLedger::where(['from'=>$accountId])->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCreditAmount($accountId){
        
        $countCarat = ManagerStockLedger::where(['to'=>$accountId])->get()->pluck('total_amount');
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
           return $totalDebit - $totalCredit." Cr.";
       }else{
        return $totalCredit - $totalDebit." Dr.";
       }
    }
    
    //Total Piece
    public function getTotalDebitPiece($accountId){
        
        $countCarat = ManagerStockLedger::where(['from'=>$accountId])->get()->pluck('qty_total');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCreditPiece($accountId){
        
        $countCarat = ManagerStockLedger::where(['to'=>$accountId])->get()->pluck('qty_total');
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
           return $totalDebit - $totalCredit." Cr.";
       }else{
        return $totalCredit - $totalDebit." Dr.";
       }
    } 

    public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_type','id');
    }

}
