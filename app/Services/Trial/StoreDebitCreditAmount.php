<?php
namespace App\Services\Trial;

use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore; 

class StoreDebitCreditAmount
{
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others','customer'])->pluck('id')->toArray();
        return UserStore::whereIn('id',array_merge($ids,[$storeId]))->pluck('id')->toArray();
    }

    public static function getStoreDebitAmountByVoucher($fromStoreIds,$toStoreIds,$voucherTypeId)
    { 
        $amounts = Ledger::query()
                    ->whereIn('from',$fromStoreIds)
                    ->whereIn('to',$toStoreIds)   
                    ->where('voucher_type',$voucherTypeId)
                    ->pluck('total_amount')->toArray(); 
        return StoreHelper::countTotal($amounts);    
    }

    public static function getStoreCreditAmountByVoucher($fromStoreIds,$toStoreIds,$voucherTypeId)
    {
        $amounts =  Ledger::query()
                    ->whereIn('from',$fromStoreIds)   
                    ->whereIn('to',$toStoreIds)   
                    ->where('voucher_type',$voucherTypeId)
                    ->pluck('total_amount')->toArray();
        return StoreHelper::countTotal($amounts);                    
    }

    public static function getStoreDebitAmount($userId)
    { 
        $storeFromIds = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $storeToIds = Self::getStoreAccountIds($userId); 
        $vouchers = [2,3,4,9];
        $amount = 0; 
        foreach($vouchers as $voucher){
             $amount += Self::getStoreDebitAmountByVoucher($storeFromIds,$storeToIds,$voucher);
        }
        return $amount;
    }

    public static function getStoreCreditAmount($userId)
    { 
        
        $storeFromIds = Self::getStoreAccountIds($userId); 
        $storeToIds = Self::getStoreAccountIds(StoreHelper::getStoreId());
        $vouchers = [2,3,4,9];
        $amount = 0; 
        foreach($vouchers as $voucher){
             $amount += Self::getStoreCreditAmountByVoucher($storeFromIds,$storeToIds,$voucher);
        }
        return $amount;
    }

    public static function getStoreDebitCreditAmount($userId)
    {
        $debit = Self::getStoreDebitAmount($userId);
        $credit = Self::getStoreCreditAmount($userId);
        if($debit > $credit){
            $bal = $debit - $credit;
            $type = 'debit';
        }else{
            $bal = $credit - $debit;
            $type = 'credit';
        }
        return [
            // 'debit' => $debit,
            // 'credit' => $credit,
            'bal' => number_format((float)$bal, 2, '.', ''),
            'type' => $type
        ];
    }

}