<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductGradeRateProfile;
use App\Model\Admin\Master\ProductRateProfileWeightRange;
use App\Model\Admin\Master\ProductRateProfileWeightRangeUnit;

class StoreHelper
{  


  public static function getProductGradeRattiRattiRateMrpAmount($productStock)
  {   
      $productRateProfileId = ProductGradeRateProfile::where([
                              'product_id'=>$productStock->product_id,
                              'grade_id'=>$productStock->grade_id,
                              'status'=>1
                            ])
                            ->first()->assignRateProfile->id;
      
      $result = ProductRateProfileWeightRange::where([
                              'rate_profile_id'=>$productRateProfileId,
                              'status'=>1
                              ])->where('from','<=',$productStock->weight)
                              ->where('to','>=',$productStock->weight)->first(); 

      if(empty($result))
      { 
           return true; 
      }else
      {
        $rattiRate = ProductRateProfileWeightRangeUnit::select('ratti_rate')
                                          ->where(['rate_profile_weight_range_id'=>$result->id,'status'=>1])
                                          ->first()->ratti_rate;
        $productStockRatti = $productStock->weight/120;
        $mrpAmount = round($rattiRate,2) * round($productStockRatti,2);
        // dd($productStockRatti);
        return collect(['productStockRatti'=>round($productStockRatti,2),'rattiRate'=>round($rattiRate,2),'mrpAmount'=>round($mrpAmount,2),'productStockId' =>$productStock->id ]);
 
      }
  } 

  public static function getProductGradeRattiRattiRateMrpAmount2($productStock)
  {   
     if(ProductGradeRateProfile::where([
      'product_id'=>$productStock->product_id,
      'grade_id'=>$productStock->grade_id,
      'status'=>1
    ])->exists()){

          $productRateProfileId = ProductGradeRateProfile::where([
            'product_id'=>$productStock->product_id,
            'grade_id'=>$productStock->grade_id,
            'status'=>1
          ])
          ->first()->assignRateProfile->id;
      
      if(ProductRateProfileWeightRange::where([
        'rate_profile_id'=>$productRateProfileId,
        'status'=>1
        ])->where('from','<=',$productStock->weight)
        ->where('to','>=',$productStock->weight)->exists()){

      $result = ProductRateProfileWeightRange::where([
        'rate_profile_id'=>$productRateProfileId,
        'status'=>1
        ])->where('from','<=',$productStock->weight)
      ->where('to','>=',$productStock->weight)->first(); 

      if(empty($result))
      { 
        return false; 
      }else
      {
        $rattiRate = ProductRateProfileWeightRangeUnit::select('ratti_rate')
                            ->where(['rate_profile_weight_range_id'=>$result->id,'status'=>1])
                            ->first()->ratti_rate;
        $productStockRatti = $productStock->weight/120;
        $mrpAmount = round($rattiRate,2) * round($productStockRatti,2);
        
        return collect(['productStockRatti'=>round($productStockRatti,2),'rattiRate'=>round($rattiRate,2),'mrpAmount'=>round($mrpAmount,2),'productStockId' =>$productStock->id ]);

      }
    }else{
       return false;
    }
    }else{
       return false;
    }
     
  } 

    public static function getFinalAmounts($account,$product,$result){
      
      if($result){
        $discountRate = 0;
      }else{
        $discountRate =   UserStore::find(Helper::getUserStoreId($account))->role->retailModel->discount->rate;  
      }

      $taxTypeId = InvoiceDetailGradeProduct::find($product['productStockId'])
                                      ->product->hsnCode->activeTax[0]->assign_tax_rate
                                      ->AssignTaxType->id;

      $taxRate = InvoiceDetailGradeProduct::find($product['productStockId'])
                                        ->product->hsnCode->activeTax[0]->assign_tax_rate->rate;
       
      //RattiRate Without Tax (Unit rate without tax)                                         
      $rattiRateWithoutTax = ($product['rattiRate'] * 100) / ($taxRate + 100); 

      //MRP Without Tax
      $mrpWithoutTax = $product['productStockRatti'] * round($rattiRateWithoutTax,2); 

      //Discount Amount
      $discountAmount =  $discountRate / 100 * round($mrpWithoutTax,2); 

      //Net Amount
      $netAmount = round($mrpWithoutTax,2) - round($discountAmount,2); 
  
      //Tax Amount
      $taxAmount = (round($netAmount,2) * $taxRate) / 100;
       
      //FinalAmount 
      $finalAmount = round($netAmount,2) + round($taxAmount,2);

      $results = [
        'discountRate' => round($discountRate,2),
        'taxTypeId' => $taxTypeId,
        'taxRate' => round($taxRate,2),
        'rattiRateWithoutTax' => round($rattiRateWithoutTax,2),
        'mrpWithoutTax' => round($mrpWithoutTax,2),
        'discountAmount' => round($discountAmount,2),
        'amountWithDiscount' => round($netAmount,2),
        'taxAmount' => round($taxAmount,2),
        'finalAmount' => round($finalAmount,2)
      ];  
      // dd($results);
      return $results;
    }

  //Generate Voucher Number

  public static function getVoucherNumberTo($userId,$voucherTypeId){
   
  //   $authUser = UserStore::find($userId);
  // // return dd($authUser->parentStore->id);
  //  return  dd(Helper::getUserStoreId($authUser->id));
  //   // if($authUser->type == 'org' || $authUser->type == 'lab'){ 
    $result = Ledger::where('account_id' ,Self::getUserStoreId($userId))->where('voucher_type',$voucherTypeId)->max('voucher_number') ?? 1000; 
    return $result+1;
  }
  
  public static function getVoucherNumber($userId,$voucherTypeId){

 
    // if($authUser->type == 'org' || $authUser->type == 'lab'){

    $result = Ledger::where('account_id' ,Self::getUserStoreId($userId))->where('voucher_type',$voucherTypeId)->max('voucher_number') ?? 1000; 
    return $result+1;
  }

  public static function countTotal($amount)
  {
      $collection = collect($amount);
      $total_amount = $collection->reduce(function ($carry, $item)
      {
          return $carry + $item;
      });
      return $total_amount;
  } 
  
  public static function getStoreId(){

    $authUser = UserStore::where('id',auth('store')->user()->id)->first();
    if($authUser->type =='user')
    {
      return $authUser->parentStore->id;
    }
      if($authUser->type == 'org' || $authUser->type == 'lab')
      {
            return $authUser->id;
      }
   } 

     
   public static function getUserStoreId($user){

    $authUser = UserStore::where('id',$user)->first();
    if($authUser->type =='user' || $authUser->type =='bank' )
    {  
      return $authUser->parentStore->id;
    }
      if($authUser->type == 'org' || $authUser->type == 'lab')
      {
            return $authUser->id;
      }
   } 

   public static function getStoreByZones()
   {
    $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
    $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
    $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
    return  UserStore::whereHas('addresses',function($q) use ($zoneCities){
      $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
      })->where('type','org')->orWhere('type','lab')
      ->with('headOfficeAddress.city:id,name')
      ->orderBy('company_name')
    ->get() 
    ;
   }
  
  public static function getLedgerAmount(){

    // $collection = LedgerDetail::where('ledger_id',$ledgerId)->pluck('amout')
    // $total_amount = $collection->reduce(function ($carry, $item)
    // {
    //     return $carry + $item;
    // });
    // return $total_amount;
   } 

   public static function getStoreSubDomainUrl($storeId){
    
      $store = UserStore::find($storeId);
      $subDomainName = $store->subDomain->name ?? "";
      return env('APP_HOST').$subDomainName.'.'.env('APP_DOMAIN');
   }

   public static function getUserStoreById($userId){
     return UserStore::find($userId);
   }

   public static function getUsersIdsByStoreId($storeId)
   {
       $ids1 = UserStore::where('org_id',$storeId)->whereIn('type',['user','bank','others'])->pluck('id')->toArray();
       $idsAll = array_merge($ids1,[$storeId]);
       return UserStore::whereIn('id',$idsAll)->pluck('id')->toArray();
   }

   public static function getManagerIdsByStoreId($storeId)
   {
       return UserStore::where('org_id',$storeId)->whereIn('type',['user'])->pluck('id')->toArray();
       
   }

   public static function getFormattedDate($date)
   {
       return Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('DD-MM-YYYY');
   }

   public static function getChequeOwner($chequeId)
   {
     return  Ledger::where('cheque_id',$chequeId)->latest()->first()->userReceipt ?? null;
   }

   public static function getTitle($url)
   { 
    // //  dd($url);
    // dd(\Illuminate\Support\Facades\Route::currentRouteName());
    // $module = Module::where('route')
    // $page = file_get_contents($url);
    // $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
    // return $title;
   }
 
    
}
 



?>