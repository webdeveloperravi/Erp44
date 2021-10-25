<?php

namespace App\Model\Store\PaymentLedger\Cash;

use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use Illuminate\Database\Eloquent\Model;   
use App\Model\Store\PaymentLedger\Cash\CurrentCashPaymentLedger;

class StoreCheckManagerCashPaymentLedger extends Model
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
    
    //Debit Credit
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = CurrentCashPaymentLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = CurrentCashPaymentLedger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    //Balance
    public function countDebit($accountId,$ledgerId){
        
        $ledger = CurrentCashPaymentLedger::find($ledgerId);
        $stockLedgers = CurrentCashPaymentLedger::where('voucher_type','5')->where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = CurrentCashPaymentLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $ledger = CurrentCashPaymentLedger::find($ledgerId); 
        $stockLedgers = CurrentCashPaymentLedger::where('voucher_type','5')->where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = CurrentCashPaymentLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getBalanace($accountId,$ledgerId){
        
        $totalDebit = $this->countDebit($accountId,$ledgerId);
        $totalCredit = $this->countCredit($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }
    
    //Total Debit Credit Balance
    public function getTotalDebit($accountId){
        
        $countCarat = CurrentCashPaymentLedger::where('voucher_type','5')->where(['from'=>$accountId])->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        
        $countCarat = CurrentCashPaymentLedger::where('voucher_type','5')->where(['to'=>$accountId])->get()->pluck('total_amount');
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
           return $totalDebit - $totalCredit." Cr.";
       }else{
        return $totalCredit - $totalDebit." Dr.";
       }
    }

}
