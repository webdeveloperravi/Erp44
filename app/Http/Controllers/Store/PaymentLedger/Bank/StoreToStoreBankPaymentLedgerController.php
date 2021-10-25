<?php

namespace App\Http\Controllers\Store\PaymentLedger\Bank;

use App\Helpers\Helper;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use App\Model\Store\PaymentLedger\Bank\StoreToStoreBankPaymentLedger;

class StoreToStoreBankPaymentLedgerController extends Controller
{
    public function index()
    {
        $stores = Helper::getStoresByZones();
        return view('store.PaymentLedger.Bank.StoreToStoreLedger.index',compact('stores')); 
    } 

    public function allTransactions($storeId)
    {   
        if($storeId != '0'){
            $authUser = UserStore::find(auth('store')->user()->id);
            $accountId1 = $authUser->id;
            $accountId2 = $storeId;
            $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
            $store2Accounts = UserStore::where(['org_id'=>$accountId2,'type'=>'user'])->pluck('id')->toArray();
            $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
            $store2Accounts = array_merge($store2Accounts,[$accountId2]);  
            $ids1 = StoreToStoreBankPaymentLedger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
            $ids2 = StoreToStoreBankPaymentLedger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
            $ids = array_merge($ids1,$ids2); 
            $paymentLedgers = StoreToStoreBankPaymentLedger::whereIn('id',$ids)->get()->reject(function($ledger){
                return $ledger->voucher_type != '6'; 
            });
        }else{
            return false;
        }

        // $paymentLedgers = StoreToStoreBankPaymentLedger::where('from',$managerId)->orWhere('to',$managerId)->get();

        return view('store.PaymentLedger.Bank.StoreToStoreLedger.allTransactions',compact('paymentLedgers','accountId2'));
    }

   
    
}
