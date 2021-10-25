<?php

namespace App\Helpers;

use Role;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Model\Guard\UserStore;
use App\Model\Guard\UserAdmin;
use App\Model\Store\StoreZone;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Setting\Module;
use App\Model\DataMigration\TblItem;
use Illuminate\Support\Facades\Auth;
use App\Model\DataMigration\TblIfvalue;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductGradeRateProfile;
use App\Model\Admin\Master\ProductRateProfileWeightRange;
use App\Model\Admin\Master\ProductRateProfileWeightRangeUnit;

class Helper
{

public  static function side_menu(){

    $side_menu = Module::all();

    return $side_menu;

}

public static function caratToWeight($value){
   
      return $value * 200;
}

public static function weightToCarat($value){
   
   return $value * 0.005;
}

public static function getGuardRoutes($guard_id)
{
    $side_menu_guard=Module::where(['guard_id'=>$guard_id])->get();
    return $side_menu_guard; 
}


public static function guardName($id)
{
     $guard_name=Guard::where(['id'=>$id])->pluck('name')->first();
     return $guard_name;
}


public static function getGuardUser()
{
    $user_id=null;

    if(Auth::guard('admin')->check())
    {
      $user_id=Auth::guard('admin')->id();
    }
    else if(Auth::guard('warehouse')->check())
    {
         $user_id=Auth::guard('warehouse')->id();
    }
  return $user_id;
}


public static function guard_helper($id)
{
   $prefix='Dashboard';

 switch ($id) 
  {
              case 1:
                  $prefix="Admin_";
                break;
              case 2:
                $prefix="Warehouse_";
                break;
              case 3:
                $prefix="Operation_";
                break;   
              case 4:
                $prefix="Sale_";
               break;   
                case 5:
                $prefix="Store_";
                break;
                 case 6:
                $prefix="Customer_";
                break;    
              
                default:
                $prefix=$prefix;
                break;
            }
     return $prefix;


}

public static function user_table($id)
{
 
    $table='App\Model\Guard\Customer';

 switch ($id) {
              case 1:
                  $table='App\Model\Guard\UserAdmin';
                break;
              case 2:
                 $table='App\Model\Guard\UserWarehouse';
                break;
              case 3:
                 $table='App\Model\Guard\UserOperation';
                break;   
              case 4:
                 $table='App\Model\Guard\UserSale';
               break;   
                case 5:
                 $table='App\Model\Guard\UserStore';
                break;   
                default:
                $table=$table;
                break;
            }
     return $table;

}

public  static function message_format($message,$type)
{

  return '<p class="alert alert-'.$type.' alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    '.$message.'
   </p>';
}

public  static function message_format_text($message,$type)
{
  return '<span class="text-'.$type. '">'.$message.'
  </span>';
}



public static function generateNumericOTP($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468"; 
  
   

    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))),1); 
    
    } 
  
    // Return result 
    return $result; 
} 
  


// check getDepartment Name from Guard Id
public static function getDepartment($guard_id)
{

    //  $role_id=Role::where(['guard_id' => $guard_id])->pluck('id')->first();
  
    // $permission_data=AdminPermission::where(['config_role_id'=>$role_id]);
     
    // if($permission_data)
    // {

    //      return  $permission_data->first();
    // }
    // return false;
}




public static function sampleHelper(){

	echo "new Helper function";
}



public static function guard(){

       $data=Guard::with('subGuardName')->get();
       
       
       return $data;

}



public static function metaTitle()
{
      $name = Route::currentRouteName();
      $meta_title=Module::where(['route'=>$name])->first();
      return $meta_title;
}

//Images Videos Functions

public static function generateDirectory($productCategory,$product){
     
    $product = Product::find($product);
    $productCategory = ProductCategory::find($productCategory);
    
    return strtolower($productCategory)."/".strtolower($product)."/";
}

public static function sendSms($phone,$otp,$type){
  
  if($type == 'manager-create'){
     $content = "New Account Verification OTP is". $otp;
     $number = "+91".$phone;
  }


  Http::withHeaders([
    'authorization' => 'qSrGgsZCQYOIf9WTP6He_w==',
    'Content-Type' => 'application/json'
  ])->post(' https://platform.clickatell.com/v1/message', [
        'channel' => 'sms',
        'to' => $number,
        'content' => $content,
  ]);

}

//Generate Store Specific Voucher Number
public static function generateVoucherNumber($userStoreId){
        
  $user = UserStore::where('id',$userStoreId)->first();
  if($user->voucher_number){ 
      $oldNumber = preg_replace('/[^0-9]/', '', $user->voucher_number); 
      $alphabet = substr(UserStore::where('id',auth('store')->user()->id)->first()->name,0,3);
      $newNumber = $oldNumber+1;
      $newVoucherNumber = $alphabet.$newNumber;
      $user->update(['voucher_number' => $newVoucherNumber]);
      return $user->voucher_number;
  }else{ 
     $voucherNumber =strtoupper(substr(UserStore::where('id',auth('store')->user()->id)->first()->name,0,3)) .'1';  
     $user->update(['voucher_number' => $voucherNumber]);
     return $user->voucher_number;
  }
}

//Make and Update Po So Numbers
public static function getPoNumber($userStoreId){
  
  $user = UserStore::find($userStoreId); 
  if($user->po_number == null || $user->po_number == '0'){
     $poNumber = '1001';
     UserStore::where('id',$user->id)->update(['po_number' => $poNumber]);
     return $poNumber;
  }else{  
    $poNumber = $user->po_number+1;
    UserStore::where('id',$user->id)->update(['po_number' => $poNumber]);
    return $poNumber;
  } 
}

//Make and Update Po So Numbers
public static function getSoNumber($userStoreId){
  
  $user = UserStore::find($userStoreId); 
  if($user->so_number == null || $user->so_number == '0'){
     $soNumber = '1001';
     UserStore::where('id',$user->id)->update(['so_number' => $soNumber]);
     return $soNumber;
  }else{  
    $soNumber = $user->so_number+1;
    UserStore::where('id',$user->id)->update(['so_number' => $soNumber]);
    return $soNumber;
  } 
}

public static function getChNumber($userStoreId){

        $user = UserStore::find($userStoreId);
  if($user->ch_number == '0' || $user->ch_number == null){
    $chNumber = 'CH'.'-'.$user->id.'-'.'1001';
    $updateUser =  UserStore::where('id',$user->id)->first()->update(['ch_number' => $chNumber]);
    return $chNumber;
  }else{
    $oldNumber = explode('-',$user->ch_number);
    $newNumber = $oldNumber[2]+1;  
    $chNumber = 'CH'.'-'.$user->id.'-'.$newNumber;
    $updateUser =  UserStore::where('id',$user->id)->first()->update(['ch_number' => $chNumber]);
    return $chNumber;
  }
}

public static function getInvNumber($userStoreId){

  $user = UserStore::find($userStoreId);
  if($user->inv_numbers == '0' || $user->inv_number == null){
    $invNumber = 'INV'.'-'.$user->id.'-'.'1001';
    $updateUser =  UserStore::where('id',$user->id)->first()->update(['inv_number' => $invNumber]);
    return $invNumber;
  }else{
    $oldNumber = explode('-',$user->inv_number);
    $newNumber = $oldNumber[2]+1;  
    $invNumber = 'INV'.'-'.$user->id.'-'.$newNumber;
    $updateUser =  UserStore::where('id',$user->id)->first()->update(['inv_number' => $invNumber]);
    return $invNumber;
  }
}


public static function getRateProfile($product,$grade_id) 
{
    return ProductGradeRateProfile::where(['product_id'=>$product,'grade_id'=>$grade_id,'status'=>1])->first()->assignRateProfile->id;
}

 // calculate Weight

   public static function getCalculateWeight($weight,$rateProfile_id)
   { 
    //  dd($weight,$rateProfile_id);
    $res= ProductRateProfileWeightRange::where(['rate_profile_id'=>$rateProfile_id,'status'=>1])->where('from','<=',$weight)->where('to','>=',$weight)->first();
    // dd($res);
 

        if(empty($res))
        {    
             return true;
             return response()->json(['notexist'=>'Rate Profile is not assigned Range']);
        }
        else
        {
         $unit_price= ProductRateProfileWeightRangeUnit::select('ratti_rate')->where(['rate_profile_weight_range_id'=>$res->id,'status'=>1])->first();
            
             $stan_rati=(float)$weight/120 ?? " ";
             $exactRatti=round($stan_rati,2);
             $exactRattiRate=(float)$unit_price->ratti_rate;
             $mrp=(float)($exactRatti*$exactRattiRate);
             $exactAmount=round($mrp,2);
             $exactRattiRate=round($exactRattiRate,2);
             
           

             $decimal_point=substr($stan_rati, -2);
        
             // dd('stand_Rati'+$stan_rati+"Rati Rate"+$rati_rate+"Mrp"+$mrp,$decimal_point);
                 
               
             
               if($decimal_point>=0 && $decimal_point<=67)
               {
                  $stan_rati=$stan_rati;
               }
               else
               {
                 $stan_rati=$stan_rati;
               }
 
                   return(['excactRatti'=>$exactRatti,'exactRattiRate'=>$exactRattiRate,'amount'=>$exactAmount]);
                      // dd($stan_rati,$rati_rate,$mrp,$decimal_point);
         
        }
   }

public static function getProductPrice($weight,$rateProfile_id)
{ 
  // dd($weight);
$res= ProductRateProfileWeightRange::select('id','from','to')->where(['rate_profile_id'=>$rateProfile_id,'status'=>1])->where('from','<=',$weight)->where('to','>=',$weight)->first();
if(empty($res))
{
     return null;
}
else
{
     
     $unit_price= ProductRateProfileWeightRangeUnit::select('ratti_rate')->where(['rate_profile_weight_range_id'=>$res->id,'status'=>1])->first();
        
         $stan_rati=number_format($weight/120,2);
         $rati_rate=$unit_price->ratti_rate;
         $mrp=(float)$stan_rati*$unit_price->ratti_rate;
      
         
         $decimal_point=substr($stan_rati, -2);

         // dd('stand_Rati'+$stan_rati+"Rati Rate"+$rati_rate+"Mrp"+$mrp,$decimal_point);
             
           
         
           if($decimal_point>=0 && $decimal_point<=67)
           {
              $stan_rati=$stan_rati;
           }
           else
           {
             $stan_rati=$stan_rati;
           }

              return $mrp;
                  // dd($stan_rati,$rati_rate,$mrp,$decimal_point);
     
}
}
public static function getProductRattiRate($weight,$rateProfile_id)
{ 
  // dd($weight);
$res= ProductRateProfileWeightRange::select('id','from','to')->where(['rate_profile_id'=>$rateProfile_id,'status'=>1])->where('from','<=',$weight)->where('to','>=',$weight)->first();
if(empty($res))
{
     return null;
}
else
{
     
     $unit_price= ProductRateProfileWeightRangeUnit::select('ratti_rate')->where(['rate_profile_weight_range_id'=>$res->id,'status'=>1])->first();
        
         $stan_rati=number_format($weight/120,2);
         $rati_rate=$unit_price->ratti_rate;
         $mrp=(float)$stan_rati*$unit_price->ratti_rate;
      
         
         $decimal_point=substr($stan_rati, -2);

         // dd('stand_Rati'+$stan_rati+"Rati Rate"+$rati_rate+"Mrp"+$mrp,$decimal_point);
             
           
         
           if($decimal_point>=0 && $decimal_point<=67)
           {
              $stan_rati=$stan_rati;
           }
           else
           {
             $stan_rati=$stan_rati;
           }

              return $rati_rate; 
     
}
}
   

//  get debitor VoucherNumber

   public static function getDebitVoucherNumber($accountId,$voucherTypeId)
   {
     return  Ledger::where(['account_id'=>$accountId,'voucher_type_id'=>$voucherTypeId])
     ->latest()
     ->first() ? 
     Ledger::where(['account_id'=>$accountId,'voucher_type_id'=>$voucherTypeId])
     ->latest()
     ->first()
     ->voucher_number+1 : "1001"; 
  
    
   
  // if($debitLedgerNumber == null || $debitLedgerNumber == '0'){
  //   $chNumber = 1001;
  //   return $chNumber;

  // }else{
  //   $oldNumber = $debitLedgerNumber->voucher_number;
  //   $newNumber = $oldNumber+1; 
  //   $chNumber = $newNumber;
  //   return $chNumber;
  // }

   }





//   // get creditorVoucherNumber

// public static function getCreditVoucherNumber($accountId,$voucherTypeId)
//    {
//         $creditorVoucherNumber = Ledger::where(['account_id_to'=>$accountId,'to_voucher_type_id'=>$voucherTypeId])->latest()->first();

    
   
//   if($creditorVoucherNumber == null || $creditorVoucherNumber == '0'){
//     $osNumber = 'OS'.'-'.$accountId.'-'.'1001';
//     return $osNumber;

//   }else{
//     $oldNumber = explode('-',$creditorVoucherNumber->to_voucher_number);
//     $newNumber = $oldNumber[2]+1; 
//     $osNumber = 'OS'.'-'.$accountId.'-'.$newNumber;
//     return $osNumber;
//   }

//    }

  // get creditorVoucherNumber

public static function getCreditVoucherNumber($accountId,$voucherTypeId)
   {
       
   $creditorVoucherNumber = Ledger::where(['account_id'=>$accountId,'voucher_type_id'=>$voucherTypeId])->latest()->first() ?? null;

   if($creditorVoucherNumber == null){
    $osNumber = 1001;
    return $osNumber;

  }else{
    $oldNumber =$creditorVoucherNumber->voucher_number;
    $newNumber = $oldNumber+1; 
    $osNumber = $newNumber;
    return $osNumber;
  }

  

   }





   public static function challanSaved($orderId)
   {

      $saved = LedgerDetail::where(['temp_number'=>$orderId,'ledger_status'=>1])->exists();  
       if($saved)
       {
        return true;
       }
       else
       {
        return false;
       }

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

      
   public static function getAdminId(){
    $authUser = UserAdmin::where('id',auth('admin')->user()->id)->first();
    return $authUser->id;
   }
  
   public static function getUserStoreId($user){

    $authUser = UserStore::where('id',$user)->first();
    if($authUser->type =='user')
    {
      return $authUser->parentStore->id;
    }
      if($authUser->type == 'org' || $authUser->type == 'lab')
      {
            return $authUser->id;
      }
   } 
  
   public static function getStoreName(){

    $authUser = UserStore::where('id',auth('store')->user()->id)->first();
    if($authUser->type =='user')
    {
      return $authUser->parentStore->company_name;
    }
    if($authUser->type == 'org' || $authUser->type == 'lab')
    {
          return $authUser->company_name;
    }
   } 

   public static function getUserRoleName()
   {
    $authUser = UserStore::where('id',auth('store')->user()->id)->first();
    if($authUser->type =='user')
    {
      return $authUser->managerRole->name ?? "";
    }
    if($authUser->type == 'org' || $authUser->type == 'lab')
    {    
       return $authUser->role->name ?? "";
    }
   }

   public static function getStoreRoleUnitId()
   {
    $authUser = UserStore::find(StoreHelper::getStoreId());
    return $authUser->role->unit->id;
    
   }

   public static function  getTitle($url) {
      $page = file_get_contents($url);
      $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
      return $title;
   }

   public static function getSubRoleManagerIds()
   {
    $managerRoleIds = auth('store')->user()->managerRole->getAllChildren();
            
    $managerIds = UserStore::where('org_id',\App\Helpers\StoreHelper::getStoreId())
                        ->where('type','user')
                        ->whereIn('manager_role_id',$managerRoleIds)->pluck('id')->toArray();
    return array_merge($managerIds,[auth('store')->user()->id]);
   }

   public static function getSubRolesManagerIds()
   {
    $managerRoleIds = auth('store')->user()->managerRole->getAllChildren();
            
    $managerIds = UserStore::where('org_id',\App\Helpers\StoreHelper::getStoreId())
                        ->where('type','user')
                        ->whereIn('manager_role_id',$managerRoleIds)->pluck('id')->toArray();
    return array_merge($managerIds,[auth('store')->user()->id]);
   }

   public static function getSubRolaynentesManagerIds()
   {
    $authUser = UserStore::find(auth('store')->user()->id);
    $managerChildRoleIds =  $authUser->managerRole->getAllChildren();
    $storeId = StoreHelper::getStoreId();
    
    return $managerIds = UserStore::where(['org_id'=>$storeId,'type'=>'user'])
                           ->whereIn('manager_role_id',$managerChildRoleIds)
                           ->pluck('id')->toArray();
   }

   public static function getStoresByZones()
   {
    $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
    $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
    $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
    return UserStore::whereHas('addresses',function($q) use ($zoneCities){
      $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
      })->where('type','org')->orWhere('type','lab')
      ->with('headOfficeAddress.city:id,name')
      ->orderBy('company_name')
    ->get() 
      ; 
   }

   public static function getManagersByTree()
   {
    $authUser = UserStore::find(auth('store')->user()->id);
    if($authUser->type == 'org' || $authUser->type == 'lab'){

        return UserStore::where(['org_id'=> $authUser->id,'type'=>'user'])->get();

    }elseif($authUser->type == 'user'){

       return UserStore::where(['org_id'=> $authUser->parentStore->id,'type'=>'user'])
                              ->whereIn('id',Helper::getSubRolesManagerIds())
                               ->get();
    }
   }

   //Sale Invoice Helpers
   public static function getNetRattiRate($rattiRate,$taxRate)
   {      
        return  $rattiRate / (100+$taxRate)  * 100;
        
   }

   public static function getNetDiscount($netRattiRate,$discountRate)
   {
    return    $netRattiRate * ($discountRate / 100) ;
   }

   public static function getDiscountAmount($netRattiRate,$netDiscount)
   {
     return $netRattiRate - $netDiscount;
   }

   public static function getTaxAmount($discountAmount,$taxRate)
   {
     return  $taxAmount = ($discountAmount * $taxRate) / 100;
  } 

  public static function getTotalAmount($discountAmount,$taxAmount)
  {
    return $discountAmount + $taxAmount;
  }

  public static function crossCheck($rattiRate,$discountRate)
  {
    return $rattiRate -  ($rattiRate * $discountRate) / 100;
  }


  //Ledger Reports
  public static function productGradeRattiCount($productIds,$productId,$gradeId,$rattiId)
  {
       return InvoiceDetailGradeProduct::whereIn('id',$productIds)
                                        // ->whereHas('product',function($q) use ($productId){
                                        //    $q->where('id',$productId);
                                        // })
                                        // ->whereHas('productGrade',function($q) use ($gradeId){
                                        //   $q->where('id',$gradeId);
                                        // })
                                        ->whereHas('ratti',function($q) use ($rattiId){
                                          $q->where('id',$rattiId);
                                        })
                                        ->count() ?? '--';
  }

  public static function getRattisByProduct($productId,$productStockIds)
  {
    return ProductMWeightRange::whereHas('invoiceDetailGradeProduct',function($q) use ($productStockIds,$productId){
        $q->whereIn('id',$productStockIds)->where('product_id',$productId);
    })->get();
  }

  public static function getGradesByProduct($productId,$productStockIds)
  { 
      return  ProductMGrade::whereHas('productStocks',function($q) use ($productStockIds,$productId){
          $q->whereIn('id',$productStockIds)->where('grade_id',$productId);
     })->get();
  }

  
  public static function dataImportStep2Status()
  {      
    if(TblItem::count() > 0 && TblIfvalue::count() > 0){
      $product = TblItem::where('erp_product_id',null)->count() ?? 0;
      $color = TblIfvalue::where('color','REGEXP','[A-Za-z-]+')->count() ?? 0; 
      $shape = TblIfvalue::where('shape','REGEXP','[A-Za-z-]+')->count() ?? 0; 
      $clarity = TblIfvalue::where('clarity','REGEXP','[A-Za-z-]+')->count() ?? 0; 
      $treatment = TblIfvalue::where('treatment',null)->count() ?? 0;
      $origin = TblIfvalue::where('origin',null)->where('item_id','!=','117345')->count() ?? 0; 
      $specie = TblIfvalue::where('specie',null)->where('item_id','!=','117345')->count() ?? 0; 
      $grade = TblIfvalue::where('grade','REGEXP','[A-Za-z.]+')->count() ?? 0; 
      $ratti = TblIfvalue::where('ratti_id',null)->count() ?? 0; 
      $rateProfile = TblIfvalue::where('rate_profile_id',null)->where('item_id','!=','117345')->count() ?? 0; 
          if($product == 0 && $color == 0 && $shape == 0 && $clarity == 0 && $treatment == 0 && $origin == 0 && $specie == 0 && $grade == 0 && $ratti == 0 && $rateProfile == 0){
              return true;
          }else{
              return false;
          }
        }else{
           return false;
        }
        
  }


  public static function unitConversion($carat,$unit_id)
  {
      if($unit_id == '1'){
        return $carat;
      }else{
        $unit = Unit::find($unit_id);
        return $carat * $unit->unitConversion->conversion;
      }
  }

 
}




?>