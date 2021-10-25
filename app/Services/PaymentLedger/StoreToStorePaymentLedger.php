<?php
namespace App\Services\PaymentLedger;

use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;

class StoreToStorePaymentLedger{
    
     
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others','customer'])->pluck('id')->toArray();
        return array_merge($ids,[$storeId]); 
    }

    

    //Final Ledgers
    public static function getLedgers($userId)
    {
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);  
        
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                             return  
                             $ledger->voucher_type != '3' &&
                             $ledger->voucher_type != '9' &&
                             $ledger->voucher_type != '4';
                     });
    }

    //Debit Credit
    public static function debit($userId,$ledgerFrom,$totalAmount)
    {
        if(in_array($ledgerFrom,Self::getStoreAccountIds($userId))){
            return $totalAmount;
        }else{
            return false;
        }
    }
    
    public static function credit($userId,$ledgerTo,$totalAmount)
    {
        if(in_array($ledgerTo,Self::getStoreAccountIds($userId))){
            return $totalAmount;
        }else{
            return false;
        }
    }

     public static function countDebitFinalLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store1Accounts)
                       ->whereIn('to',$store2Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '3' &&
                        $ledger->voucher_type != '9' &&
                        $ledger->voucher_type != '4';
                        })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);  
    }

    public static function countCreditFinalLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store2Accounts)
                       ->whereIn('to',$store1Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '3' &&
                        $ledger->voucher_type != '9' &&
                        $ledger->voucher_type != '4';
                         }) 
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);
    }

    public static function getFinalLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId); 
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $totalDebit = Self::countDebitFinalLedger($store1Accounts,$store2Accounts,$ledger);
        $totalCredit = Self::countCreditFinalLedger($store1Accounts,$store2Accounts,$ledger);

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    } 
    
    public static function getFinalTotalDebitAmount($store1Accounts,$store2Accounts)
    {  
        
         $stockLedgers = Ledger::query()
         ->whereIn('voucher_type',[3,4,9])
         ->whereIn('to',$store1Accounts)
         ->whereIn('from',$store2Accounts)
         ->get()
         ->pluck('id');

            $countCarat = Ledger::query()
                    ->whereIn("id",$stockLedgers)
                //    ->where('id','<=',$ledger->id)
                    ->pluck("total_amount")->all();

            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat;
    }

    public static function getFinalTotalCreditAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
        ->whereIn('voucher_type',[3,4,9])
        ->whereIn('from',$store1Accounts)
        ->whereIn('to',$store2Accounts)
        ->get()
        ->pluck('id');

            $countCarat = Ledger::query()
                    ->whereIn("id",$stockLedgers)
                //    ->where('id','<=',$ledger->id)
                    ->pluck("total_amount")->all();

            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat;
    }

    public static function getFinalLedgerTotal($userId)
    {
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $credit = Self::getFinalTotalDebitAmount($store1Accounts,$store2Accounts);
        $debit = Self::getFinalTotalCreditAmount($store1Accounts,$store2Accounts);
        
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    

}