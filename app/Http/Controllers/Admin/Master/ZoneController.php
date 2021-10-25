<?php

namespace App\Http\Controllers\Admin\Master;

use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request; 
use App\Model\Guard\UserStore;

use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Zone;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Master\CountryStateCity;

class ZoneController extends Controller
{
    
    public function index()
    {    
        $countries = Country::all();
        $zones = Zone::all();

        return view('admin.amaster.zone.index',compact('zones','countries'));
    }

    public function all(){
      $zones = Zone::all();
      return view('admin.amaster.zone.all',compact('zones'));
     }

    public function view($countryId=0,$stateId=0)
    {    
      if($stateId > 0){
        $zones = Zone::where('state_id',$stateId)->get();
        $msg = CountryState::find($stateId)->name." "."Zones";
      }elseif($countryId > 0){
        $zones = Zone::where('country_id',$countryId)->get();
        $msg = Country::find($countryId)->name. " "."Zones";
      }else{
        $zones = Zone::all();
        $msg = "ALL Zones";
      }


        // $zones = Zone::where('state_id',$stateId)->get();
        $state = CountryState::find($stateId);

        return view('admin.amaster.zone.all',compact('zones','state','msg'));
    }

    public function viewTwo($zoneId){
      $zone = Zone::find($zoneId);
      return view('admin.amaster.zone.view',compact('zone'));
    }
 
    public function create()
    {   
        $countries = Country::all();
        return view('admin.amaster.zone.create',compact('countries'));
    }

    
    public function store(Request $request)
    {       
          $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'alias' => 'required',
            'description' => 'required',
            'countryId' => 'required',
            'stateId' => 'required',
          ]);

          if($validator->passes()){
  
           $zone = Zone::create([
               'name' => $request->name,
               'alias' => $request->alias,
               'description' => $request->description,
               'country_id' => $request->countryId,
               'state_id' =>   $request->stateId
           ]);
           if($zone){
            $store = UserStore::first(); 
            $store->zones()->attach($zone->id);
           }

           $zone->masterIds()->create([
            'created_id' => Helper::getAdminId()
          ]);

          return response()->json(['success'=> true],200);
        }else{
         $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
     }
   } 

    public function edit($id)
    {    
        $zone = Zone::find($id);
        $countries = Country::all();
        return view('admin.amaster.zone.edit',compact('zone','countries'));
    }

    
    public function update(Request $request)
    {   

          $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'alias' => 'required',
            'description' => 'required'
          ]);

          if($validator->passes()){
  
           $zone = Zone::where('id',$request->zoneId)->first();
            $zone->update([
            'name' => $request->name,
           'alias' => $request->alias,
           'description' => $request->description,
        ]);

        $zone->masterIds()->create([
          'updated_id' => Helper::getAdminId()
        ]);


          return response()->json(['success'=> true],200);
        }else{
         $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
     }

   }

    public function destroy($id)
    {
       $zone = Zone::where('id',$request->id)->first();
       $zone->delete();
       return response()->json(['success'=> true],200);
    }

    public function states($countryId){
        
        $states = CountryState::where('country_id',$countryId)->get();
        return view('admin.amaster.zone.states',compact('states'));
    }


    public function statesIndex($countryId){
        
        $states = CountryState::where('country_id',$countryId)->get();
        return view('admin.amaster.zone.statesindex',compact('states'));
    }

    public function areasAttach(Request $request){
 
       
      $zone = Zone::find($request->zoneId);
      $zone->cities()->detach();
      $zone->cities()->attach($request->areas);
      
      return response()->json(['success'=> true],200);
      //  return view('admin.amaster.zone.closewindow');
      }
      
    
  

    public function areasAttachView($zoneId){
       
      // $zone = Zone::find($zoneId); 
      

      $zone = Zone::with('state')->where('id',$zoneId)->first(); 
      $zoneCities = ZoneCity::all()->pluck('city_id'); 
      $cities = CountryStateCity::where('state_id',$zone->state->id)->whereNotIn('id',$zoneCities)->get();
      $oldCities = $zone->cities()->pluck('city_id')->toArray();
      
      // $oldCities = CountryStateCity::where('zone_id',$zone->id)->pluck('id')->toArray();
     

      return view('admin.amaster.zone.attachareas',compact('zone','cities','oldCities'));
    }
}
