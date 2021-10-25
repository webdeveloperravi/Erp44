<?php
namespace App\Services;
use App\Model\Guard\UserStore;
use App\Model\Store\PaymentDaybook\PaymentDaybook;

class Balance {

    
     //Total Debit Credit Balance
     public static function getTotalCredit($accountId){
        
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

    public static function getTotalDebit($accountId){
        
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

    public static function getTotalBalance($accountId)
    {
       $totalDebit = Self::getTotalDebit($accountId);
       $totalCredit = Self::getTotalCredit($accountId); 
       if(($totalDebit - $totalCredit) == 0){
        return  ['amount' => $totalDebit - $totalCredit,'type'=> 'dr'];
       }
       if($totalDebit > $totalCredit){
           return  ['amount' => $totalDebit - $totalCredit,'type'=> 'dr'];
       }else{
           return  ['amount' => $totalCredit - $totalDebit,'type'=> 'cr'];
       }
    }
}