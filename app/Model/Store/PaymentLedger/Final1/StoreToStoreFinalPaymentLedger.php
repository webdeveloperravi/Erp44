<?php

namespace App\Model\Store\PaymentLedger\Final1;

use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Master\Voucher;
use Illuminate\Database\Eloquent\Model;   
use App\Model\Store\PaymentLedger\Final1\StoreToStoreFinalPaymentLedger;
 
class StoreToStoreFinalPaymentLedger extends Model
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

    public function voucherType()
    {
        return $this->belongsTo(Voucher::class,'voucher_type','id');
    }
    
    //Debit Credit
    public function getDebitAmount($accountId,$ledgerId){
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  

        $ledger = StoreToStoreFinalPaymentLedger::find($ledgerId);
        if(in_array($ledger->from,$store1Accounts)){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId)
    {

        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  

        $ledger = StoreToStoreFinalPaymentLedger::find($ledgerId);
        if(in_array($ledger->to,$store1Accounts)){
            return $ledger->total_amount;
        }else{
            return false;
        }
    }
    
    //Balance
    public function countDebit($accountId,$ledgerId){
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  

        $stockLedgers = StoreToStoreFinalPaymentLedger::whereIn('voucher_type',[3,4,5,6,7])->whereIn('to',$store1Accounts)->get()->pluck('id');

        $ledger = StoreToStoreFinalPaymentLedger::find($ledgerId);
        $countCarat = StoreToStoreFinalPaymentLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  
        $stockLedgers = StoreToStoreFinalPaymentLedger::whereIn('voucher_type',[3,4,5,6,7])->whereIn('from',$store1Accounts)->get()->pluck('id');

        $ledger = StoreToStoreFinalPaymentLedger::find($ledgerId); 
        
        $countCarat = StoreToStoreFinalPaymentLedger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("total_amount")->all();
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
    public function getTotalDebit($accountId)
    {
        $authUser = UserStore::find(auth('store')->user()->id);
        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]); 
        $store2Accounts = UserStore::where(['org_id'=>$authUser->id,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = array_merge($store2Accounts,[$authUser->id]); 

        $countCarat = StoreToStoreFinalPaymentLedger::whereIn('voucher_type',[3,4,5,6,7])->whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        $authUser = UserStore::find(auth('store')->user()->id);

        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  
        $store2Accounts = UserStore::where(['org_id'=>$authUser->id,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = array_merge($store2Accounts,[$authUser->id]); 

        $countCarat = StoreToStoreFinalPaymentLedger::whereIn('voucher_type',[3,4,5,6,7])->whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->get()->pluck('total_amount');
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
