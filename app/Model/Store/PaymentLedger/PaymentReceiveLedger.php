<?php

namespace App\Model\Store\PaymentLedger;

use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\PaymentLedger\PaymentReceiveLedger;
 
 
class PaymentReceiveLedger extends Model
{
    protected $guarded = [''];
    protected $table = 'ledgers';

    public function ledgerDetails(){
        return $this->hasMany(LedgerDetail::class,'ledger_id','id');
    }

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'from','id'); }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'to','id');
    } 

    //Payment PaymentReceiveLedger Functions
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = PaymentReceiveLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = PaymentReceiveLedger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->amount;
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
        
        $ledger = PaymentReceiveLedger::find($ledgerId);
        // $stockPaymentReceiveLedgers = PaymentReceiveLedger::where('credit_to',$accountId)->get()->pluck('id');
        $stockPaymentReceiveLedgers = PaymentReceiveLedger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = PaymentReceiveLedger::whereIn("id",$stockPaymentReceiveLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $ledger = PaymentReceiveLedger::find($ledgerId);
        // $stockPaymentReceiveLedgers = PaymentReceiveLedger::where('debit_by',$accountId)->get()->pluck('id');
        $stockPaymentReceiveLedgers = PaymentReceiveLedger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = PaymentReceiveLedger::whereIn("id",$stockPaymentReceiveLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }
    

    public function getTotalDebit($accountId){
        
        $countCarat = PaymentReceiveLedger::where(['from'=>$accountId])->get()->pluck('amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        
        $countCarat = PaymentReceiveLedger::where(['to'=>$accountId])->get()->pluck('amount');
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

 

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable','statusable_type','statusable_id');
    }

    public function authGuard()
    {
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

}
