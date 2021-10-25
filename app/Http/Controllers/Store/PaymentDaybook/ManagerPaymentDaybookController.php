<?php

namespace App\Http\Controllers\Store\PaymentDaybook;

use App\Helpers\Helper;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request; 
use App\Model\Guard\UserStore; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator;  
use Illuminate\Database\Eloquent\Collection;
use App\Model\Store\PaymentDaybook\PaymentDaybook;
use App\Model\Store\PaymentDaybook\PaymentDaybookAll;

class ManagerPaymentDaybookController extends Controller
{
    public function index()
    { 
        return view('store.PaymentDaybook.Manager.index');
    }
    
    public static function getStoreUserAccountIds()
    {    
        $storeId = StoreHelper::getUserStoreId(StoreHelper::getStoreId());
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user'])->pluck('id')->toArray();
        return array_merge($ids,[$storeId]); 
    }

    public static function getStoreBankAccountIds()
    {    
        $storeId = StoreHelper::getUserStoreId(StoreHelper::getStoreId());
        return  UserStore::where('org_id',$storeId)->whereIn('type',['bank'])->pluck('id')->toArray(); 
    }

    public static function getStoreOthersAccountIds()
    {    
        $storeId = StoreHelper::getUserStoreId(StoreHelper::getStoreId());
       return   UserStore::where('org_id',$storeId)->whereIn('type',['others'])->pluck('id')->toArray();
        
    }

    public function getAccounts($type)
    {   
        if($type == 'cash'){
            $accounts = UserStore::findMany(Self::getStoreUserAccountIds()); 
            return view('store.PaymentDaybook.Manager.accountsList',compact('accounts'));
        }elseif($type == 'bank'){
            $accounts = UserStore::findMany(Self::getStoreBankAccountIds()); 
            return view('store.PaymentDaybook.Manager.accountsList',compact('accounts'));
        }elseif($type == 'others'){
            $accounts = UserStore::findMany(Self::getStoreOthersAccountIds()); 
            return view('store.PaymentDaybook.Manager.accountsList',compact('accounts'));
        }elseif($type == 'all'){
            $accounts = collect(['id'=> 0,'name'=>'all'])->all(); 
            // dd($accounts);
            $accounts = new Collection(); 
                $accounts->push((object)[
                    'id' => 'all',
                    'name' => 'All',
            ]); 
            return view('store.PaymentDaybook.Manager.accountsList',compact('accounts'));
        }
    }

    public function getTransactions(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'payment_mode' => 'required|not_in:0',
            'account' => 'required|not_in:0'
        ]);

    if($validator->passes()){
    $authUser = UserStore::find(auth('store')->user()->id);  
      
    if($request->account == 'all'){ 
                 
    if($authUser->type == 'lab' || $authUser->type == 'org'){

    $accountId1 = StoreHelper::getStoreId();
    
     
    $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
    // $store2Accounts = UserStore::whereIn('org_id',$accountId2)->where('type','user')->pluck('id')->toArray();
    $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
    // $store2Accounts = array_merge($store2Accounts,$accountId2);   
                    
    $ids1 = PaymentDaybookAll::whereIn('from',$store1Accounts)->pluck('id')->toArray();
    $ids2 = PaymentDaybookAll::whereIn('to',$store1Accounts)->pluck('id')->toArray(); 

    $ids = array_merge($ids1,$ids2); 
    $ledgers = PaymentDaybookAll::whereIn('id',$ids)->get()->reject(function($ledger){
        return   $ledger->voucher_type != '9';
    }); 

            }elseif($authUser->type == 'user'){
                    $managerIds = Helper::getSubRolesManagerIds();  
                    $managerIds = array_merge($managerIds,[$authUser->id]);
                    // dd($managerIds);
                    $ledgers = PaymentDaybookAll::whereIn('from',$managerIds)
                    ->orWhereIn('to',$managerIds)
                    ->get()
                    ->reject(function($ledger){
                        return $ledger->voucher_type != '9'; 
                    }) 
                    ; 
                }
                $voucherTypeIdFrom = 9;
                return view('store.PaymentDaybook.Manager.transactionsAll',compact('ledgers','authUser','voucherTypeIdFrom'));

            }else{
                $authUser = UserStore::find($request->account); 
        
                $ledgers = PaymentDaybook::where('from',$authUser->id)
                            ->orWhere('to',$authUser->id)
                            ->get()
                            ->reject(function($ledger){
                                return $ledger->voucher_type != '9'; 
                            }) 
                            ; 
                return view('store.PaymentDaybook.Manager.transactions',compact('ledgers','authUser'));
            }
        }else{
            $keys = $validator->errors()->keys();
            $vals = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    }
}
