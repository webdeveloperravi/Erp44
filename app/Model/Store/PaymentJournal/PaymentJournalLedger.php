<?php

namespace App\Model\Store\PaymentJournal;

use App\Model\Store\Bank;
use App\Model\Store\Ledger;
use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use Illuminate\Database\Eloquent\Model; 
use App\Model\Store\PaymentJournal\PaymentJournalLedger;
 
 
class PaymentJournalLedger extends Model
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

    public function paymentAccount()
    {
        return $this->belongsTo(Bank::class,'account_id','id');
    }

    public function getTotalAmount()
    {
  

        $countCarat = Ledger::where('from',auth()->user()->id)->where('voucher_type',7)->get()->pluck('total_amount')->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;

    }

    //Payment PaymentIssueLedger Functions
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = PaymentJournalLedger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = PaymentJournalLedger::find($ledgerId);
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
        
        $ledger = PaymentJournalLedger::find($ledgerId);
        // $stockPaymentIssueLedgers = PaymentJournalLedger::where('credit_to',$accountId)->get()->pluck('id');
        $stockPaymentIssueLedgers = PaymentJournalLedger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = PaymentJournalLedger::whereIn("id",$stockPaymentIssueLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $ledger = PaymentJournalLedger::find($ledgerId);
        // $stockPaymentIssueLedgers = PaymentJournalLedger::where('debit_by',$accountId)->get()->pluck('id');
        $stockPaymentIssueLedgers = PaymentJournalLedger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = PaymentJournalLedger::whereIn("id",$stockPaymentIssueLedgers)->where('created_at','<=',$ledger->created_at)->pluck("amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }
    

    public function getTotalDebit($accountId){
        
        $countCarat = PaymentJournalLedger::where(['from'=>$accountId])->get()->pluck('amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        
        $countCarat = PaymentJournalLedger::where(['to'=>$accountId])->get()->pluck('amount');
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
