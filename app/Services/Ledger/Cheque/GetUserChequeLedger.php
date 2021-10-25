<?php
namespace App\Services\Ledger\Cheque;

use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore; 
use App\Services\GetUserDebitCreditAmount;

class GetUserChequeLedger
{
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others','customer'])->pluck('id')->toArray();
        return array_merge($ids,[$storeId]); 
    }

    //Get User Ledgers
    public static function getChequeLedgers($userId)
    { 
        
        $ids1 = Ledger::where('from',$userId)->pluck('id')->toArray();
        $ids10 = Ledger::where('to',$userId)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids10))
                     ->get()
                     ->reject(function($ledger){
                            return $ledger->voucher_type != '10'; 
                     });
    }

    //Debit Credit
    public static function countDebitAmount($userId,$ledgerFrom,$totalAmount)
    {
        if($ledgerFrom == $userId){
            return $totalAmount;
        }else{
            return false;
        } 
    }
    
    public static function countCreditAmount($userId,$ledgerTo,$totalAmount)
    {
        if($ledgerTo == $userId){
            return $totalAmount;
        }else{
            return false;
        } 
    }

    //User Cheque Debit Credit Balance
    public static function countDebitChequeLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::where('voucher_type','10')->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function countCreditChequeLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::where('voucher_type','10')->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getChequeLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId);  
        $totalDebit = Self::countDebitChequeLedger($userId,$ledger);
        $totalCredit = Self::countCreditChequeLedger($userId,$ledger); 

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }

    //User Cheque Total Balance
    public static function getChequeTotalDebitAmount($userId)
    {  
        $stockLedgers = Ledger::where('voucher_type','10')->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getChequeTotalCreditAmount($userId)
    {  
        $stockLedgers = Ledger::where('voucher_type','10')->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getChequeLedgerTotal($userId)
    {
        $debit = Self::getChequeTotalDebitAmount($userId);
        $credit = Self::getChequeTotalCreditAmount($userId);
        
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

     

}