<?php

namespace App\Model\Store\PaymentDaybook;

use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Organization\DiscountRate;
use App\Model\Store\PaymentDaybook\PaymentDaybook;
use App\Model\Store\PaymentDaybook\PaymentDaybookAll;

class PaymentDaybookAll extends Model
{
    protected $table = 'ledgers';
    protected $guarded = [''];

    public function ledgerDetails(){
        return $this->hasMany(LedgerDetail::class,'ledger_id','id');
    }

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'from','id'); 
    }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'to','id');
    } 

    public function storeReceipt(){
        return $this->belongsTo(UserStore::class,'account_id','id');
    }  

    public function voucher(){
        return $this->belongsTo(Voucher::class,'voucher_type','id');
    }

    public function voucherTo(){
        return $this->belongsTo(Voucher::class,'voucher_type_to','id');
    }

    public function discount(){
        $this->belongsTo(DiscountRate::class,'discount_rate_id','id');
    }
      
    // //Debit Credit
    // public function getDebitAmount($accountId,$ledgerId){
        
    //     $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
    //     $store1Accounts = array_merge($store1Accounts,[$accountId]);  

    //     $ledger = PaymentDaybookAll::find($ledgerId);
    //     if(in_array($ledger->from,$store1Accounts)){
    //         return $ledger->total_amount;
    //     }else{
    //         return false;
    //     }
    // }
    
    // public function getCreditAmount($accountId,$ledgerId)
    // {

    //     $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
    //     $store1Accounts = array_merge($store1Accounts,[$accountId]);  

    //     $ledger = PaymentDaybookAll::find($ledgerId);
    //     if(in_array($ledger->to,$store1Accounts)){
    //         return $ledger->total_amount;
    //     }else{
    //         return false;
    //     }
    // }
        //Debit Credit
        public function getDebitAmount($accountId,$ledgerId){
        
            $ledger = Self::find($ledgerId);
            if($ledger->from == $accountId){
                return $ledger->total_amount;
            }else{
                return false;
            }
        }
        
        public function getCreditAmount($accountId,$ledgerId){
            
            $ledger = Self::find($ledgerId);
            if($ledger->to == $accountId){
                return $ledger->total_amount;
            }else{
                return false;
            }
        }
        
     
    //Balance
    public function countDebit($accountId,$ledgerId)
    {
        $authUser = UserStore::find($accountId); 


        $ledger = PaymentDaybook::find($ledgerId);
        
        $accountId1 = StoreHelper::getStoreId();
        $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $accountId2 = UserStore::whereHas('addresses',function($q) use ($zoneCities){
        $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
        ->get()
        ->reject(function($q) use ($accountId1){
            return $q->id == $accountId1;
        })
        ->pluck('id')->toArray();
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = UserStore::whereIn('org_id',$accountId2)->where('type','user')->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
        $store2Accounts = array_merge($store2Accounts,$accountId2);   
                        
        $ids1 = PaymentDaybookAll::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray(); 
        $countCarat = PaymentDaybookAll::whereIn('id',$ids1)->get()
        ->where('updated_at','<=',$ledger->updated_at)
        ->reject(function($ledger){
            return $ledger->voucher_type != '5'; 
        })->pluck("total_amount")->all();    


        // $countCarat = PaymentDaybook::whereIn("id",$ledgers); 
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $authUser = UserStore::find($accountId); 

       

        $ledger = PaymentDaybook::find($ledgerId);
        $accountId1 = StoreHelper::getStoreId();
        $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $accountId2 = UserStore::whereHas('addresses',function($q) use ($zoneCities){
        $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
        ->get()
        ->reject(function($q) use ($accountId1){
            return $q->id == $accountId1;
        })
        ->pluck('id')->toArray();
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = UserStore::whereIn('org_id',$accountId2)->where('type','user')->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
        $store2Accounts = array_merge($store2Accounts,$accountId2);    
        $ids2 = PaymentDaybookAll::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
 
        $countCarat = PaymentDaybookAll::whereIn('id',$ids2)->get()
        ->where('updated_at','<=',$ledger->updated_at)
        ->reject(function($ledger){
            return $ledger->voucher_type != '5'; 
        })->pluck("total_amount")->all(); 
        
        
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getBalanace($accountId,$ledgerId){
        
        $totalDebit = $this->countDebit($accountId,$ledgerId);
        $totalCredit = $this->countCredit($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }


      //Total Debit Credit Balance
      public function getTotalDebit($accountId)
      {
        $accountId1 = StoreHelper::getStoreId();
        $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $accountId2 = UserStore::whereHas('addresses',function($q) use ($zoneCities){
        $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
        ->get()
        ->reject(function($q) use ($accountId1){
            return $q->id == $accountId1;
        })
        ->pluck('id')->toArray();
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = UserStore::whereIn('org_id',$accountId2)->where('type','user')->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
        $store2Accounts = array_merge($store2Accounts,$accountId2);   
                        
        $ids1 = PaymentDaybookAll::whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->pluck('id')->toArray(); 
        $countCarat = PaymentDaybookAll::whereIn('id',$ids1)->get()
        // ->where('updated_at','<=',$ledger->updated_at)
        ->reject(function($ledger){
            return $ledger->voucher_type != '5'; 
        })->pluck("total_amount")->all();  
  
        //   $countCarat = PaymentDaybookAll::where('voucher_type','5')->whereIn('from',$store1Accounts)->whereIn('to',$store2Accounts)->get()->pluck('total_amount');
          $countCarat = collect($countCarat);
          $countCarat = $countCarat->reduce(function ($carry, $item) {
              return $carry + $item;
           }); 
           return $countCarat;
      }
  
      public function getTotalCredit($accountId){

        $authUser = UserStore::find($accountId);

        $accountId1 = StoreHelper::getStoreId();
        $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $accountId2 = UserStore::whereHas('addresses',function($q) use ($zoneCities){
        $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
        ->get()
        ->reject(function($q) use ($accountId1){
            return $q->id == $accountId1;
        })
        ->pluck('id')->toArray();
        
        $store1Accounts = UserStore::where(['org_id'=>$accountId1,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = UserStore::whereIn('org_id',$accountId2)->where('type','user')->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId1]); 
        $store2Accounts = array_merge($store2Accounts,$accountId2);    
        $ids2 = PaymentDaybookAll::whereIn('to',$store1Accounts)->whereIn('from',$store2Accounts)->pluck('id')->toArray(); 
 
        $countCarat = PaymentDaybookAll::whereIn('id',$ids2)->get()
        // ->where('updated_at','<=',$ledger->updated_at)
        ->reject(function($ledger){
            return $ledger->voucher_type != '5'; 
        })->pluck("total_amount")->all(); 
          $countCarat = collect($countCarat);
          $countCarat = $countCarat->reduce(function ($carry, $item) {
              return $carry + $item;
           }); 
           return $countCarat;
      }
  
      public function getTotalBalance($accountId){
          
         $totalDebit = $this->getTotalDebit($accountId);
         $totalCredit = $this->getTotalCredit($accountId);
         if($totalDebit > $totalCredit){
             return $totalDebit - $totalCredit." Dr.";
         }else{
          return $totalCredit - $totalDebit." Cr.";
         }
      }

    

}
