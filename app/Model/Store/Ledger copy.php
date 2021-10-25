<?php

namespace App\Model\Store;

use App\Model\Store\Ledger;
use App\Model\Store\Status;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $guarded = [''];

    public function ledgerDetails(){
        return $this->hasMany(LedgerDetail::class,'ledger_id','id');
    }

    public function storeIssue(){
        return $this->belongsTo(UserStore::class,'from','id');
    }

    public function storeReceipt(){
        return $this->belongsTo(UserStore::class,'to','id');
    }

    // public function managerIssue(){
    //       return $this->belongsTo(UserStore::class,'manager_id_from','id');
    // }

    // public function managerReceipt(){
   
    //  return $this->belongsTo(UserStore::class,'manager_id_to','id');
    // }



    //Payment Ledger Functions
    public function getDebitAmount($accountId,$ledgerId){
        
        // $ledger = Ledger::find($ledgerId);
        // if($ledger->to == $accountId){
        //     return $ledger->qty_total;
        // }else{
        //     return false;
        // }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }

    // public function getValues($accountId,$ledgerId){
        
    //     $totalDebit = $this->countDebit($accountId,$ledgerId);
    //     $totalCredit = $this->countCredit($accountId,$ledgerId);

    //     if($totalDebit > $totalCredit){
    //         return $totalDebit - $totalCredit." Dr.";
    //     }else{
    //         return $totalCredit - $totalDebit." Cr.";
    //     }
    // }

    public function getValues($accountId,$ledgerId){
        
        $totalDebit = $this->countDebit($accountId,$ledgerId);
        $totalCredit = $this->countCredit($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }

    // public function countDebit($accountId,$ledgerId){
        
    //     $ledger = Ledger::find($ledgerId);
    //     // $stockLedgers = Ledger::where('credit_to',$accountId)->get()->pluck('id');
    //     $stockLedgers = Ledger::where(['account_id_to'=>$accountId,'account_id_from'=>auth('store')->user()->id])->get()->pluck('id');
    //     $countCarat = Ledger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
    //     $countCarat = collect($countCarat);
    //     $countCarat = $countCarat->reduce(function ($carry, $item) {
    //         return $carry + $item;
    //      }); 
    //      return $countCarat;
    // }

       public function countDebit($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        // $stockLedgers = Ledger::where('credit_to',$accountId)->get()->pluck('id');
        $stockLedgers = Ledger::where(['to'=>$accountId,'from'=>auth('store')->user()->id])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    // public function countCredit($accountId,$ledgerId){
        
    //     $ledger = Ledger::find($ledgerId);
    //     // $stockLedgers = Ledger::where('debit_by',$accountId)->get()->pluck('id');
    //     $stockLedgers = Ledger::where(['account_id_from'=>$accountId,'account_id_to'=>auth('store')->user()->id])->get()->pluck('id');
        
    //     $countCarat = Ledger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
    //     $countCarat = collect($countCarat);
    //     $countCarat = $countCarat->reduce(function ($carry, $item) {
    //         return $carry + $item;
    //      }); 
    //      return $countCarat;
    // }
    
    public function countCredit($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        // $stockLedgers = Ledger::where('debit_by',$accountId)->get()->pluck('id');
        $stockLedgers = Ledger::where(['from'=>$accountId,'to'=>auth('store')->user()->id])->get()->pluck('id');
        
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    // public function getTotalDebit($accountId){
        
    //     $countCarat = Ledger::where(['account_id_to'=>$accountId,'account_id_from'=>auth('store')->user()->id])->get()->pluck('qty_total');
    //     $countCarat = collect($countCarat);
    //     $countCarat = $countCarat->reduce(function ($carry, $item) {
    //         return $carry + $item;
    //      }); 
    //      return $countCarat;
    // }

    // public function getTotalCredit($accountId){
        
    //     $countCarat = Ledger::where(['account_id_from'=>$accountId,'account_id_to'=>auth('store')->user()->id])->get()->pluck('qty_total');
    //     $countCarat = collect($countCarat);
    //     $countCarat = $countCarat->reduce(function ($carry, $item) {
    //         return $carry + $item;
    //      }); 
    //      return $countCarat;
    // }

    // public function getTotalBalance($accountId){
        
    //    $totalDebit = $this->getTotalDebit($accountId);
    //    $totalCredit = $this->getTotalCredit($accountId);
    //    if($totalDebit > $totalCredit){
    //        return $totalDebit - $totalCredit." Dr.";
    //    }else{
    //     return $totalCredit - $totalDebit." Cr.";
    //    }
    // }



     public function getTotalDebit($accountId){
        
        $countCarat = Ledger::where(['to'=>$accountId,'from'=>auth('store')->user()->id])->get()->pluck('qty_total');

        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
        // dd($countCarat);
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        

        $countCarat = Ledger::where(['from'=>$accountId,'to'=>auth('store')->user()->id])->get()->pluck('qty_total'); 
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


  
    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable','statusable_type','statusable_id');
    }

    public function authGuard()
    {
        return $this->belongsTo(Guard::class,'guard_id','id');
     }

}
