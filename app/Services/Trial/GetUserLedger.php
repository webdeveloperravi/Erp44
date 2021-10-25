<?php
namespace App\Services\Trial;

use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore; 
use App\Services\GetUserDebitCreditAmount;

class GetUserLedger
{
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others','customer'])->pluck('id')->toArray();
        return array_merge($ids,[$storeId]); 
    }

    //Get User Ledgers
    public static function getApprovalLedgers($userId)
    { 
        
        $ids1 = Ledger::where('from',$userId)->pluck('id')->toArray();
        $ids2 = Ledger::where('to',$userId)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                            return $ledger->voucher_type != '2'; 
                     });
    }

    public static function getFinalLedgers($userId)
    { 
        
        $ids1 = Ledger::where('from',$userId)->pluck('id')->toArray();
        $ids2 = Ledger::where('to',$userId)->pluck('id')->toArray(); 
        
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

    public static function getInvoiceLedgers($userId)
    { 
        $ids1 = Ledger::where('from',$userId)->pluck('id')->toArray();
        $ids2 = Ledger::where('to',$userId)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                            return 
                            $ledger->voucher_type != '3' && 
                            $ledger->voucher_type != '4';
                     });
    }

    public static function getCashLedgers($userId)
    { 
        $ids1 = Ledger::where('from',$userId)->pluck('id')->toArray();
        $ids2 = Ledger::where('to',$userId)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                            return $ledger->voucher_type != '9';
                     });
    }

    //Debit Credit
    public static function countDebitAmount($userId,$ledgerFrom,$totalAmount){
         
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

    //User Approval Debit Credit Balance
    public static function countDebitApprovalLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::where('voucher_type','2')->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function countCreditApprovalLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::where('voucher_type','2')->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getApprovalLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId);  
        $totalDebit = Self::countDebitApprovalLedger($userId,$ledger);
        $totalCredit = Self::countCreditApprovalLedger($userId,$ledger); 

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //User Final Debit Credit Balance
    public static function countDebitFinalLedger($userId,$ledger)
    {   
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4,9])->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function countCreditFinalLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4,9])->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getFinalLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId);  
        $totalDebit = Self::countDebitFinalLedger($userId,$ledger);
        $totalCredit = Self::countCreditFinalLedger($userId,$ledger);
        
        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //User Invoice Debit Credit Balance
    public static function countDebitInvoiceLedger($userId,$ledger)
    {   
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4])->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function countCreditInvoiceLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4])->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getInvoiceLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId);  
        $totalDebit = Self::countDebitInvoiceLedger($userId,$ledger);
        $totalCredit = Self::countCreditInvoiceLedger($userId,$ledger);
        
        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //User Cash Debit Credit Balance
    public static function countDebitCashLedger($userId,$ledger)
    {   
        $stockLedgers = Ledger::whereIn('voucher_type',[9])->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function countCreditCashLedger($userId,$ledger)
    { 
        $stockLedgers = Ledger::whereIn('voucher_type',[9])->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('id','<=',$ledger->id)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getCashLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId);  
        $totalDebit = Self::countDebitCashLedger($userId,$ledger);
        $totalCredit = Self::countCreditCashLedger($userId,$ledger);
        
        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }

    //User Approval Total Balance
    public static function getApprovalTotalDebitAmount($userId)
    {  
        $stockLedgers = Ledger::where('voucher_type','2')->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getApprovalTotalCreditAmount($userId)
    {  
        $stockLedgers = Ledger::where('voucher_type','2')->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getApprovalLedgerTotal($userId)
    {
        $debit = Self::getApprovalTotalDebitAmount($userId);
        $credit = Self::getApprovalTotalCreditAmount($userId);
        
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //User Final Total Balance
    public static function getFinalTotalDebitAmount($userId)
    {  
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4,9])->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getFinalTotalCreditAmount($userId)
    {  
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4,9])->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getFinalLedgerTotal($userId)
    {
        $debit = Self::getFinalTotalDebitAmount($userId);
        $credit = Self::getFinalTotalCreditAmount($userId);
        
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //User Invoice Total Balance
    public static function getInvoiceTotalDebitAmount($userId)
    {  
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4])->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getInvoiceTotalCreditAmount($userId)
    {  
        $stockLedgers = Ledger::whereIn('voucher_type',[3,4])->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getInvoiceLedgerTotal($userId)
    {
        $debit = Self::getInvoiceTotalDebitAmount($userId);
        $credit = Self::getInvoiceTotalCreditAmount($userId);
        
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //User Cash Total Balance
    public static function getCashTotalDebitAmount($userId)
    {  
        $stockLedgers = Ledger::whereIn('voucher_type',[9])->where(['from'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getCashTotalCreditAmount($userId)
    {  
        $stockLedgers = Ledger::whereIn('voucher_type',[9])->where(['to'=>$userId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->pluck("total_amount")->all();
        return StoreHelper::countTotal($countCarat);
    }

    public static function getCashLedgerTotal($userId)
    {
        $debit = Self::getCashTotalDebitAmount($userId);
        $credit = Self::getCashTotalCreditAmount($userId);
        
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 


}