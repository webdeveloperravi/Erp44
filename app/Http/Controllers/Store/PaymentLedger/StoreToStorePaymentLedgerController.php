<?php

namespace App\Http\Controllers\Store\PaymentLedger;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Http\Controllers\Controller;   
use App\Services\PaymentLedger\StoreToStorePaymentLedger;

class StoreToStorePaymentLedgerController extends Controller
{
    public function index(){
       
        $stores = Helper::getStoresByZones();
        return view('store.PaymentLedger.StoreToStore.index',compact('stores')); 
    } 

    public function all($storeId)
    {   
        $paymentLedgers = StoreToStorePaymentLedger::getLedgers($storeId);
        $account = UserStore::find($storeId);
        return view('store.PaymentLedger.StoreToStore.allTransactions',compact('paymentLedgers','account'));
    }

   
    
}
