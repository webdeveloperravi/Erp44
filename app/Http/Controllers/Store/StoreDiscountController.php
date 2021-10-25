<?php

namespace App\Http\Controllers\Store;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\ManagerZone;
use App\Model\Admin\Master\Country;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Zone;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StoreDiscountController extends Controller
{
    public function index(){
         
        $countries = Country::all();
        $addressTypes = AddressType::all();
        return view('store.storeDiscount.index',compact('countries','addressTypes'));
    }
    
    public function getStates($countryId)
    {
        $states = CountryState::where('country_id',$countryId)->get();
        return view('store.storeDiscount.states',compact('states'));

    }
    
    public function getCities($stateId)
    {
        $cities = CountryStateCity::where('state_id',$stateId)->get();
        return view('store.storeDiscount.cities',compact('cities'));
        
    }
    
    public function getStores(request $request)
    {  
        // $myStoreId = \App\Helpers\StoreHelper::getStoreId();  
        // $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        // $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        // $storeIds = UserStore::with('primaryAddress')->whereHas('primaryAddress',function($q) use ($zoneCities){
        //   $q->whereIn('city_id',$zoneCities);
        //   })
        // //   ->where('type','org')
        // //   ->orWhere('type','lab')
        // //   ->with('headOfficeAddress.city:id,name')
        // //   ->orderBy('company_name')
        // //   ->get() 
        // ->pluck('id')->toArray()
        //   ;  
        //   dd($storeIds);
        //   $stores  = UserStore::has('addresses')->whereHas('addresses',function($query) use ($request){
            
        //     $query
        //     ->when($request->country != 0 , function($query) use ($request) {
        //         $query->where('country_id',$request->country);
        //     })
        //     ->when($request->state != 0 , function($query) use ($request) {
        //             $query->where('state_id',$request->state);
        //         })
        //     ->when($request->city != 0 , function($query) use ($request) {
        //         $query->where('city_id',$request->city);
        //     })
        //     ->when($request->addressType != 0 , function($query) use ($request) {
        //         $query->where('address_type_id',$request->addressType);
        //     });
        // })
        // ->whereIn('type',['org','lab'])
        // // ->where('org_id',StoreHelper::getStoreId())
        // // ->whereIn('id',$storeIds)
        //     ->get()->reject(function($query){
        //         $query->whereDoesntHave('addresses');
        // });
        $msg = "ALL Stores";

        $authUser =  auth('store')->user();
        if(in_array($authUser->type,['org','lab'])){
           
           $childRetailModels = $authUser->role->retailModel->getAllChildren();
           $storeZoneIds = $authUser->zones->pluck('id')->toArray();
           $zoneCities = ZoneCity::whereIn('zone_id',$storeZoneIds)->get()->pluck('city_id')->toArray(); 
           $stores = UserStore::query()
                       ->whereHas('primaryAddress',function($q) use ($zoneCities){
                           $q->whereIn('city_id',$zoneCities);
                       })
                       ->whereHas('role',function($q) use ($childRetailModels){
                           $q->whereHas('retailModel',function($q) use ($childRetailModels){
                                      $q->whereIn('id',$childRetailModels);
                           });
                       })
                       ->get()
                    //    ->pluck('id')
                    //    ->toArray()
                       ;
        //    $saleOrders = StorePurchaseOrder::whereIn('buyer_store_id',$storeIds)->latest()->get(); 

        }else{
            $stores = [];
        }
        // elseif($authUser->type == 'user'){
        //    $storeZoneIds = $authUser->managerZones->pluck('id')->toArray();
        //    $zoneCities = ZoneCity::whereIn('zone_id',$storeZoneIds)->get()->pluck('city_id')->toArray(); 
        //    $stores = UserStore::query()
        //                ->whereHas('primaryAddress',function($q) use ($zoneCities){
        //                    $q->whereIn('city_id',$zoneCities);
        //                }) 
        //                ->get()
        //             //    ->pluck('id')
        //             //    ->toArray()
        //                ;
        // //    $saleOrders = StorePurchaseOrder::whereIn('buyer_store_id',$storeIds)->latest()->get(); 
        // }
        return view('store.storeDiscount.allStores',compact('stores','msg'));
    }


    public function editStoreRole($storeId)
    {     
          $store = UserStore::find($storeId);
          $storeRoles  = OrgRole::with('retailModel','retailModel.retailType')->get(); 
          return view('store.storeDiscount.editStoreRole',compact('store','storeRoles'));
    }
    

    public function updateStoreRole(Request $request)
    {
        $store = UserStore::where('id',$request->storeId)->update(['store_role_id'=>$request->storeRole]);
        $storeRole = OrgRole::find($request->storeRole);
        if($storeRole){
            if($storeRole->retailModel->retailType->id != 1){
                UserStore::find($request->storeId)->zones()->detach();
                ManagerZone::query() 
                ->whereIn('manager_id',StoreHelper::getManagerIdsByStoreId($request->storeId))
                ->when($request->has('zones'), function($query) use ($request){
                         return $query->whereNotIn('zone_id',$request->zones);
                 })
                ->delete();
            }
        }
        return response()->json(['success'=> true],200); 
    }

    public function zoneAttachIndex($storeId)
    { 
        $store = UserStore::find($storeId); 
         $countries = Country::all();
     
      return view('store.storeDiscount.AttachZones.zoneViewIndex',compact('store','countries'));
    }

    public function zoneAttachView(Request $request){
    
        $storeZones = StoreZone::where('store_id',$request->storeId)->pluck('zone_id')->toArray(); 
        $store =  UserStore::with('zones')->where('id',$request->storeId)->first();
        $zones = Zone::whereNotIn('id',$storeZones)
        ->when($request->country != 0 , function($query) use ($request) {
          $query->where('country_id',$request->country);
        })
        ->when($request->state != 0 , function($query) use ($request) {
                $query->where('state_id',$request->state);
        })
        ->when($request->city != 0 , function($query) use ($request) {
                $query->where('city_id',$request->city);
        })->get();
       
        return view('store.storeDiscount.AttachZones.zoneAttachView',compact('store','zones','storeZones'));
      } 

      
    public function zoneAttach(Request $request)
    {
        $store = UserStore::find($request->storeId);

        $store->zones()->detach();
        //Also Detach Store Manager Zones
        ManagerZone::query() 
               ->whereIn('manager_id',StoreHelper::getManagerIdsByStoreId($store->id))
               ->when($request->has('zones'), function($query) use ($request){
                        return $query->whereNotIn('zone_id',$request->zones);
                })
               ->delete();

        $store->zones()->attach($request->zones);

        return response()->json(['success'=> true],200); 
    }
        
    public function attachZonesGetStates($countryId)
    {
        $states = CountryState::where('country_id',$countryId)->get();
        return view('store.storeDiscount.AttachZones.states',compact('states'));

    }
    
    public function attachZonesGetCities($stateId)
    {
        $cities = CountryStateCity::where('state_id',$stateId)->get();
        return view('store.storeDiscount.AttachZones.cities',compact('cities'));
        
    }
    
    
  
}
