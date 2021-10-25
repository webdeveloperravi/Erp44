<?php

namespace App\Http\Controllers\Store\PaymentLedger\Final1;

use App\Helpers\Helper;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;    
use App\Model\Store\PaymentLedger\Final1\StoreToStoreFinalPaymentLedger;

class StoreToStoreFinalPaymentLedgerController extends Controller
{
    public function index(){

        
        $stores = Helper::getStoresByZones();
         
        return view('store.PaymentLedger.Final.StoreToStoreLedger.index',compact('stores')); 
    } 

    public function allTransactions($storeId)
    {   
        // if($storeId != '0'){
        //     $authUser = UserStore::find(StoreHelper::getStoreId());
        //     $accountId1 = $authUser->id;
        //     $accountId2 = $storeId;
        //     $store1Accounts = UserStore::where(['org_id'=>$accountId1])->whereIn('type',['user','bank'])->pluck('id')->toArray();
        //     $store2Accounts = UserStore::where(['org_id'=>$accountId2])->whereIn('type',['user','bank'])->pluck('id')->toArray();
        //     $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
        //     $store2Accounts = array_merge($store2Accounts,[$accountId2]);  
        //     $ids1 = StoreToStoreFinalPaymentLedger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
        //     $ids2 = StoreToStoreFinalPaymentLedger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
        //     $ids = array_merge($ids1,$ids2); 
        //     $paymentLedgers = StoreToStoreFinalPaymentLedger::whereIn('id',$ids)->get()->reject(function($ledger){
        //         return 
        //         $ledger->voucher_type != '5' &&
        //         $ledger->voucher_type != '6' &&
        //         $ledger->voucher_type != '7' &&
        //         $ledger->voucher_type != '3' &&
        //         $ledger->voucher_type != '4'
        //         ; 
        //     });
        // }else{
        //     return false;
        // } 
        // return view('store.PaymentLedger.Final.StoreToStoreLedger.allTransactions',compact('paymentLedgers','accountId2'));
 
        $account = UserStore::find($storeId);
        return view('store.PaymentLedger.Final.StoreToStoreLedger.allTransactions',compact('account'));
    }

   
    
}
