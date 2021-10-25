<?php

namespace App\Http\Controllers\Admin\Master;

use App\Helpers\Helper;
use Illuminate\Http\Request; 
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\CountryState;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\CountryStateCity;

class StateCityController extends Controller
{
     
    public function index()
    {   
        $countries = Country::all(); 

        return view('admin.amaster.city.index',compact('countries')); 
    }

     
    public function view($stateId)
    {    
        $cities = CountryStateCity::where('state_id',$stateId)->get();
        $state = CountryState::find($stateId);

        return view('admin.amaster.city.all',compact('cities','state'));
    }

    public function create($stateId)
    {   
        $state = CountryState::find($stateId);
        return view('admin.amaster.city.create',compact('state'));
    }

    
    protected function store(Request $request)
    {       
 
          $validator = Validator::make($request->all(), [
            'name' => 'required',  
          ]);

          if($validator->passes()){

        //    $this->checkCityExist($request->stateId,$request->name);
       
        if( $this->checkCityExist($request->stateId,$request->name)){
            $city = CountryStateCity::create([
                'name' => $request->name, 
                'state_id' =>   $request->stateId
            ]); 

            $city->masterIds()->create([
              'created_id' => Helper::getAdminId()
            ]);
 
           return response()->json(['success'=> true,'stateId'=>$request->stateId],200);
        }else{
          return response()->json(['message'=> 'City Already Exist'],200);
        }
           
        }else{
      $keys = $validator->errors()->keys();
      $vals  = $validator->errors()->all();
      $errors = array_combine($keys,$vals);
    
      return response()->json(['errors'=>$errors]);
     }

   }

   public function checkCityExist($stateId,$cityName){
      
      return  $city = CountryStateCity::where(['state_id'=>$stateId,'name'=>$cityName])->exists() ? false : true ;

   }

    
    public function show($id)
    {
        //
    }

     
    public function edit($cityId)
    {
        $city = CountryStateCity::find($cityId);
        return view('admin.amaster.city.edit',compact('city'));
    }

    
    protected function update(Request $request)
    {       
 
          $validator = Validator::make($request->all(), [
            'name' => 'required',  
          ]);

          if($validator->passes()){

           $city = CountryStateCity::where("id",$request->cityId)->first();
        
           $city->update([
             'name' => $request->name,  
           ]);

           $city->masterIds()->create([
            'updated_id' => Helper::getAdminId()
          ]);
  
            

          return response()->json(['success'=> true,'stateId'=> $city->state->id],200);
        }else{
         $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
     }

   }

    public function states($countryId){
        
        $states = CountryState::where('country_id',$countryId)->get();
        return view('admin.amaster.city.states',compact('states'));
    }
}
