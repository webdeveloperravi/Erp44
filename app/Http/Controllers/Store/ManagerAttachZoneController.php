<?php

namespace App\Http\Controllers\Store;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerZone;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Zone;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Master\CountryStateCity;

class ManagerAttachZoneController extends Controller
{
    
    public function index($managerId)
    { 
        $manager = UserStore::find($managerId); 
         $countries = Country::all();
       return view('store.account.manager.managerView.AttachZones.zoneViewIndex',compact('manager','countries'));
    }

    public function zoneAttachView(Request $request){
    
        $storeZoneIds = UserStore::find(StoreHelper::getStoreId())->zones->pluck('id')->toArray();
        $managerZones = ManagerZone::where('manager_id',$request->managerId)->pluck('zone_id')->toArray(); 
        $manager =  UserStore::with('zones')->where('id',$request->managerId)->first();
        $zones = Zone::whereNotIn('id',$managerZones)
        ->when($request->country != 0 , function($query) use ($request) {
          $query->where('country_id',$request->country);
        })
        ->when($request->state != 0 , function($query) use ($request) {
                $query->where('state_id',$request->state);
        })
        ->when($request->city != 0 , function($query) use ($request) {
                $query->where('city_id',$request->city);
        })
        ->whereIn('id',$storeZoneIds)
        ->get();
       
        return view('store.account.manager.managerView.AttachZones.zoneAttachView',compact('manager','zones','managerZones'));
      } 

      
    public function zoneAttach(Request $request)
    { 
        $manager = UserStore::find($request->managerId);
        $manager->managerZones()->detach(); 
        $manager->managerZones()->attach($request->zones);
         
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
