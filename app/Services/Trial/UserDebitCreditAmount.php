<?php
namespace App\Services\Trial;

use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Model\Store\PaymentLedger\Final1\StoreToStoreFinalPaymentLedger;

class UserDebitCreditAmount
{ 
    
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others','customer'])->pluck('id')->toArray();
        return UserStore::whereIn('id',array_merge($ids,[$storeId]))->pluck('id')->toArray();
    }

    public static function getUserDebitAmountByVoucher($userId,$voucherTypeId)
    {      
        $amounts =  Ledger::query()
                    ->where('from',$userId) 
                    ->where('voucher_type',$voucherTypeId)
                    // ->orWhere('voucher_type_to',$voucherTypeId) 
                    
                    ->pluck('total_amount')->toArray();  
        return StoreHelper::countTotal($amounts);   
    }

    public static function getUserCreditAmountByVoucher($userId,$voucherTypeId)
    { 
        $amounts = Ledger::query()  
                     ->where('voucher_type',$voucherTypeId)
                    // ->orWhere('voucher_type_to',$voucherTypeId)
                    ->where('to',$userId) 
                    ->pluck('total_amount')->toArray();
        return StoreHelper::countTotal($amounts); 
    }

    public static function getUserDebitAmount($userId)
    {      
        $vouchers = [2,3,4,9];
        $amount = 0; 
        foreach($vouchers as $voucher){
             $amount += Self::getUserDebitAmountByVoucher($userId,$voucher);
        }
        return $amount;  
    }

    public static function getUserCreditAmount($userId)
    { 
        $vouchers = [2,3,4,9];
        $amount = 0; 
        foreach($vouchers as $voucher){
             $amount += Self::getUserCreditAmountByVoucher($userId,$voucher);
        }
        return $amount; 
    }

    public static function getUserDebitCreditAmount($userId)
    {
        $debit = Self::getUserDebitAmount($userId);
        $credit = Self::getUserCreditAmount($userId);
        if($debit > $credit){
            $bal = $debit - $credit;
            $type = 'debit';
        }else{
            $bal = $credit - $debit;
            $type = 'credit';
        }
        return [
            'debit' => $debit,
            'credit' => $credit,
            'bal' => number_format((float)$bal, 2, '.', ''),
            'type' => $type
        ];
    }

}