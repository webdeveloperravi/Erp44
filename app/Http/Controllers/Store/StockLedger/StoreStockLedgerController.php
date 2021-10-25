<?php

namespace App\Http\Controllers\Store\StockLedger;

use App\Helpers\Helper;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\LedgerDetail;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Store\StockLedger\StoreStockLedger;

class StoreStockLedgerController extends Controller
{
    public function index(){
 
        $stores = Helper::getStoresByZones();
        return view('store.StockLedger.StoreStockLedger.index',compact('stores')); 
    } 

    public function all($storeId)
    {   
        if($storeId != '0'){
            $authUser = UserStore::find(auth('store')->user()->id);
            if($authUser->type == 'org' || $authUser->type == 'lab'){

            $accountId1 = $authUser->id;
            $accountId2 = $storeId;
            $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
            $store2Accounts = UserStore::where(['org_id'=>$accountId2,'type'=>'user'])->pluck('id')->toArray();
            $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
            $store2Accounts = array_merge($store2Accounts,[$accountId2]);  
            $ids1 = StoreStockLedger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
            $ids2 = StoreStockLedger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
            $ids = array_merge($ids1,$ids2); 
            $stockLedgers = StoreStockLedger::with('userIssue','userReceipt')->whereIn('id',$ids)->get()->reject(function($ledger){
                return $ledger->voucher_type != '2'; 
            });
        
            }elseif($authUser->type == 'user'){
        
                $accountId1 = $authUser->parentStore->id;
                $accountId2 = $storeId;
                $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
                $store2Accounts = UserStore::where(['org_id'=>$accountId2,'type'=>'user'])->pluck('id')->toArray();
                $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
                $store2Accounts = array_merge($store2Accounts,[$accountId2]);  
                $ids1 = StoreStockLedger::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray();
                $ids2 = StoreStockLedger::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
                $ids = array_merge($ids1,$ids2); 
                $stockLedgers = StoreStockLedger::with('userIssue','userReceipt')
                ->whereIn('id',$ids)
                ->latest()
                ->get()->reject(function($ledger){
                    return $ledger->voucher_type != '2'; 
                });;
            }
            
        }else{
            return false;
        } 
        return view('store.StockLedger.StoreStockLedger.all',compact('stockLedgers','accountId2'));
    }

    public function details($id)
    {   
        $ledger = StoreStockLedger::with('ledgerDetails')->where('id',$id)->first();
        // $stockTransactionDetails = LedgerDetail::with('ledger')->where('ledger_id',$id)->get();
       
        return view('store.StockLedger.details',compact('ledger'));
    }
    
}
