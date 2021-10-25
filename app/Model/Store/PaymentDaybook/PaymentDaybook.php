<?php

namespace App\Model\Store\PaymentDaybook;

use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\DiscountRate;
use App\Model\Store\PaymentDaybook\PaymentDaybook;

class PaymentDaybook extends Model
{
    protected $table = 'ledgers';
    protected $guarded = [''];

    public function ledgerDetails(){
        return $this->hasMany(LedgerDetail::class,'ledger_id','id');
    }

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'from','id'); 
    }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'to','id');
    } 

    public function storeReceipt(){
        return $this->belongsTo(UserStore::class,'account_id','id');
    }  

    public function voucher(){
        return $this->belongsTo(Voucher::class,'voucher_type','id');
    }

    public function voucherTo(){
        return $this->belongsTo(Voucher::class,'voucher_type_to','id');
    }

    public function discount(){
        $this->belongsTo(DiscountRate::class,'discount_rate_id','id');
    }

    //Debit Credit
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = Self::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = Self::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
     
    //Balance
    public function countDebit($accountId,$ledgerId)
    {
        $authUser = UserStore::find($accountId);  
        $ledger = PaymentDaybook::find($ledgerId);
        
        $stockLedgers = PaymentDaybook::query()
                     ->where('voucher_type',9) 
                      ->where(['from'=>$accountId]) 
                      ->get()->pluck('id');        

        $countCarat = PaymentDaybook::whereIn("id",$stockLedgers)->where('updated_at','<=',$ledger->updated_at)->pluck("total_amount")->all(); 
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $authUser = UserStore::find($accountId);  

        $ledger = PaymentDaybook::find($ledgerId); 
        $stockLedgers = PaymentDaybook::query() 
                        ->where('voucher_type',9) 
                        ->where(['to'=>$accountId])
                        ->get()->pluck('id');
                        
        $countCarat = PaymentDaybook::whereIn("id",$stockLedgers)->where('updated_at','<=',$ledger->updated_at)->pluck("total_amount")->all();
        
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
    public function getTotalCredit($accountId){
        
        $authUser = UserStore::find($accountId);  

        $countCarat = PaymentDaybook::query()
                     ->where('voucher_type',9) 
                    ->where(['to'=>$accountId])
                    ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
        }); 

        return $countCarat;
    }

    public function getTotalDebit($accountId){
        
        $authUser = UserStore::find($accountId);  
        $countCarat = PaymentDaybook::query()
        ->where('voucher_type',9) 
                    ->where(['from'=>$accountId])
                    ->get()->pluck('total_amount');
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
