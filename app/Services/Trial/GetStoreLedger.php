<?php
namespace App\Services\Trial;

use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore; 
use App\Services\GetUserDebitCreditAmount;

class GetStoreLedger
{
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others','customer'])->pluck('id')->toArray();
        return array_merge($ids,[$storeId]); 
    }

    public static function getStoreUserAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user'])->pluck('id')->toArray();
        return array_merge($ids,[$storeId]); 
    }

    public static function getStoreBankAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        return  UserStore::where('org_id',$storeId)->whereIn('type',['bank'])->pluck('id')->toArray(); 
    }

    public static function getStoreOthersAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
       return   UserStore::where('org_id',$storeId)->whereIn('type',['others'])->pluck('id')->toArray();
        
    }

    //Approval Ledgers
    public static function getApprovalLedgers($userId)
    {
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);  
        
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                            return $ledger->voucher_type != '2'; 
                     });
    }

    //Final Ledgers
    public static function getFinalLedgers($userId)
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

    //Invoice Ledgers
    public static function getInvoiceLedgers($userId)
    {
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);  
        
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                             return $ledger->voucher_type != '3' && 
                             $ledger->voucher_type != '4';
                     });
    }

    //Cash Ledgers
    public static function getCashLedgers($userId)
    {
        $store1Accounts = Self::getStoreUserAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);  
        
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                             return  
                             $ledger->voucher_type != '9';
                     });
    }

    //Bank Ledgers
    public static function getBankLedgers($userId)
    {
        $store1Accounts = Self::getStoreBankAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);  
        
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                             return  
                             $ledger->voucher_type != '9';
                     });
    }

    //Others Ledgers
    public static function getOthersLedgers($userId)
    {
        $store1Accounts = Self::getStoreOthersAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);  
        
        $ids1 = Ledger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        $ids2 = Ledger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        
        return Ledger::with('userIssue','userReceipt')
                     ->whereIn('id',array_merge($ids1,$ids2))
                     ->get()
                     ->reject(function($ledger){
                             return  
                             $ledger->voucher_type != '9';
                     });
    }
    
    //Debit Credit
    public static function countDebitAmount($userId,$ledgerFrom,$totalAmount)
    {
        if(in_array($ledgerFrom,Self::getStoreAccountIds($userId))){
            return $totalAmount;
        }else{
            return false;
        }
    }
    
    public static function countCreditAmount($userId,$ledgerTo,$totalAmount)
    {
        if(in_array($ledgerTo,Self::getStoreAccountIds($userId))){
            return $totalAmount;
        }else{
            return false;
        }
    }

    //Approval Balance
    public static function countDebitApprovalLedger($store1Accounts,$store2Accounts,$ledger)
    {    
        $amounts = Ledger::whereIn('from',$store1Accounts)
                       ->whereIn('to',$store2Accounts)
                       ->where('id','<=',$ledger->id)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '2';
                       })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);  
    }

    public static function countCreditApprovalLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store2Accounts)
                       ->whereIn('to',$store1Accounts)
                       ->where('id','<=',$ledger->id)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '2';
                       })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);
    }

    public static function getApprovalLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId); 
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $totalDebit = Self::countDebitApprovalLedger($store1Accounts,$store2Accounts,$ledger);
        $totalCredit = Self::countCreditApprovalLedger($store1Accounts,$store2Accounts,$ledger);

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //Final Balance
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
    
    //Invoice Balance
    public static function countDebitInvoiceLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store1Accounts)
                       ->whereIn('to',$store2Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '3' && 
                        $ledger->voucher_type != '4';
                        })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);  
    }

    public static function countCreditInvoiceLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store2Accounts)
                       ->whereIn('to',$store1Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '3' && 
                        $ledger->voucher_type != '4';
                         }) 
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);
    }

    public static function getInvoiceLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId); 
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $totalDebit = Self::countDebitInvoiceLedger($store1Accounts,$store2Accounts,$ledger);
        $totalCredit = Self::countCreditInvoiceLedger($store1Accounts,$store2Accounts,$ledger);

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //Cash Balance
    public static function countDebitCashLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store1Accounts)
                       ->whereIn('to',$store2Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '9';
                        })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);  
    }

    public static function countCreditCashLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store2Accounts)
                       ->whereIn('to',$store1Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '9';
                        })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);
    }

    public static function getCashLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId); 
        $store1Accounts = Self::getStoreUserAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $totalDebit = Self::countDebitCashLedger($store1Accounts,$store2Accounts,$ledger);
        $totalCredit = Self::countCreditCashLedger($store1Accounts,$store2Accounts,$ledger);

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //Bank Balance
    public static function countDebitBankLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store1Accounts)
                       ->whereIn('to',$store2Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '9';
                        })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);  
    }

    public static function countCreditBankLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store2Accounts)
                       ->whereIn('to',$store1Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '9';
                         }) 
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);
    }

    public static function getBankLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId); 
        $store1Accounts = Self::getStoreBankAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $totalDebit = Self::countDebitBankLedger($store1Accounts,$store2Accounts,$ledger);
        $totalCredit = Self::countCreditBankLedger($store1Accounts,$store2Accounts,$ledger);

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }
    
    //Others Balance
    public static function countDebitOthersLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store1Accounts)
                       ->whereIn('to',$store2Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '9';
                        })
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);  
    }

    public static function countCreditOthersLedger($store1Accounts,$store2Accounts,$ledger)
    {
        $amounts = Ledger::whereIn('from',$store2Accounts)
                       ->whereIn('to',$store1Accounts)
                       ->where('updated_at','<=',$ledger->updated_at)
                       ->get()
                       ->reject(function($ledger){
                        return $ledger->voucher_type != '9';
                         }) 
                       ->pluck("total_amount")->all();
        return StoreHelper::countTotal($amounts);
    }

    public static function getOthersLedgerBalance($userId,$ledgerId)
    {   
        $ledger = Ledger::find($ledgerId); 
        $store1Accounts = Self::getStoreOthersAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $totalDebit = Self::countDebitOthersLedger($store1Accounts,$store2Accounts,$ledger);
        $totalCredit = Self::countCreditOthersLedger($store1Accounts,$store2Accounts,$ledger);

        if($totalDebit > $totalCredit){
            return ['amount' => $totalDebit - $totalCredit ,'type' => 'Dr.']; 
        }elseif($totalDebit < $totalCredit){
            return ['amount' => $totalCredit - $totalDebit,'type' => 'Cr.'];  
        }else{
            return ['amount' => $totalCredit - $totalDebit,'type' => ''];
        }
    }

    //Approval Total
    public static function getApprovalTotalDebitAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
                      ->whereIn('voucher_type',[2])
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

    public static function getApprovalTotalCreditAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
                      ->whereIn('voucher_type',[2])
                      ->whereIn('to',$store1Accounts)
                      ->whereIn('from',$store2Accounts)
                      ->get()
                      ->pluck('id');

        $countCarat = Ledger::query()
                       ->whereIn("id",$stockLedgers) 
                       ->pluck("total_amount")->all();

        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public static function getApprovalLedgerTotal($userId)
    {
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $credit = Self::getApprovalTotalDebitAmount($store1Accounts,$store2Accounts);
        $debit = Self::getApprovalTotalCreditAmount($store1Accounts,$store2Accounts); 
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //Final Total 
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

    //Invoice Total 
    public static function getInvoiceTotalDebitAmount($store1Accounts,$store2Accounts)
    {  
        
         $stockLedgers = Ledger::query()
         ->whereIn('voucher_type',[3,4])
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

    public static function getInvoiceTotalCreditAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
        ->whereIn('voucher_type',[3,4])
        ->whereIn('from',$store1Accounts)
        ->whereIn('to',$store2Accounts)
        ->get()
        ->pluck('id');

            $countCarat = Ledger::query()
                    ->whereIn("id",$stockLedgers) 
                    ->pluck("total_amount")->all();

            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat;
    }

    public static function getInvoiceLedgerTotal($userId)
    {
        $store1Accounts = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $credit = Self::getInvoiceTotalDebitAmount($store1Accounts,$store2Accounts);
        $debit = Self::getInvoiceTotalCreditAmount($store1Accounts,$store2Accounts); 
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //Cash Total 
    public static function getCashTotalDebitAmount($store1Accounts,$store2Accounts)
    {  
        
         $stockLedgers = Ledger::query()
         ->whereIn('voucher_type',[9])
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

    public static function getCashTotalCreditAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
        ->whereIn('voucher_type',[9])
        ->whereIn('from',$store1Accounts)
        ->whereIn('to',$store2Accounts)
        ->get()
        ->pluck('id');

            $countCarat = Ledger::query()
                    ->whereIn("id",$stockLedgers) 
                    ->pluck("total_amount")->all();

            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat;
    }

    public static function getCashLedgerTotal($userId)
    {
        $store1Accounts = Self::getStoreUserAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $credit = Self::getCashTotalDebitAmount($store1Accounts,$store2Accounts);
        $debit = Self::getCashTotalCreditAmount($store1Accounts,$store2Accounts); 
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //Bank Total 
    public static function getBankTotalDebitAmount($store1Accounts,$store2Accounts)
    {  
        
         $stockLedgers = Ledger::query()
         ->whereIn('voucher_type',[9])
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

    public static function getBankTotalCreditAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
        ->whereIn('voucher_type',[9])
        ->whereIn('from',$store1Accounts)
        ->whereIn('to',$store2Accounts)
        ->get()
        ->pluck('id');

            $countCarat = Ledger::query()
                    ->whereIn("id",$stockLedgers) 
                    ->pluck("total_amount")->all();

            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat;
    }

    public static function getBankLedgerTotal($userId)
    {
        $store1Accounts = Self::getStoreBankAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $credit = Self::getBankTotalDebitAmount($store1Accounts,$store2Accounts);
        $debit = Self::getBankTotalCreditAmount($store1Accounts,$store2Accounts); 
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

    //Others Total 
    public static function getOthersTotalDebitAmount($store1Accounts,$store2Accounts)
    {  
        
         $stockLedgers = Ledger::query()
         ->whereIn('voucher_type',[9])
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

    public static function getOthersTotalCreditAmount($store1Accounts,$store2Accounts)
    {  
        $stockLedgers = Ledger::query()
        ->whereIn('voucher_type',[9])
        ->whereIn('from',$store1Accounts)
        ->whereIn('to',$store2Accounts)
        ->get()
        ->pluck('id');

            $countCarat = Ledger::query()
                    ->whereIn("id",$stockLedgers) 
                    ->pluck("total_amount")->all();

            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat;
    }

    public static function getOthersLedgerTotal($userId)
    {
        $store1Accounts = Self::getStoreOthersAccountIds(StoreHelper::getStoreId());
        $store2Accounts = Self::getStoreAccountIds($userId);
        $credit = Self::getOthersTotalDebitAmount($store1Accounts,$store2Accounts);
        $debit = Self::getOthersTotalCreditAmount($store1Accounts,$store2Accounts); 
        if($debit > $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $debit - $credit ,'type' => 'Dr.']; 
        }elseif($debit < $credit){
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => 'Cr.'];  
        }else{
            return ['debit'=> $debit,'credit'=>$credit,'amount' => $credit - $debit,'type' => ''];
        }
    } 

}