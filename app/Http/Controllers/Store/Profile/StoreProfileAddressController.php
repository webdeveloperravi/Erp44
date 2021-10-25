<?php

namespace App\Http\Controllers\Store\Profile;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\CountryState;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
use App\Model\Admin\Organization\StoreAddress;

 

class StoreProfileAddressController extends Controller
{
    public function all()
    {
      $addresses = StoreAddress::where('store_id',auth('store')->user()->id)->get();
      return view('store.Profile.Address.all',compact('addresses'));
    }

     public function create(){

      $countries = Country::all(); 
      $states = CountryState::all();
      $cities = CountryStateCity::all();
      
      $accountId = auth('store')->user()->id;
       if(StoreAddress::where(['store_id'=>auth('store')->user()->id,'address_type_id'=>1])->exists()){
        $addressTypes = AddressType::whereNotIn('id',[1])->get();
       }else{
        $addressTypes = AddressType::all();
       }

     return view('store.Profile.Address.create',compact('countries','states','cities','addressTypes','accountId'));

     }

     public function store(Request $request)
     {
        $validator = Validator::make($request->all(),[
            "address_type_id" => 'required|not_in:0',
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
            'town_id' => 'required|not_in:0',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
            'pincode' => 'required'
        ]);
         
        if($validator->passes()){
          $address = StoreAddress::create([
            'store_id' => $request->account_id,
            'address_type_id' => $request->address_type_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'town_id' => $request->town_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'locality' => $request->locality,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
          ]);
           
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    }

    public function  edit($id)
    { 

      $address = StoreAddress::find($id);
      $countries = Country::all(); 
      $states = CountryState::where('country_id',$address->country_id)->get();
      $cities = CountryStateCity::where('state_id',$address->state_id)->get(); 
      $addressTypes = AddressType::all();

      return view('store.Profile.Address.edit',compact('address','addressTypes','countries','states','cities'));
    }
    
    public function update(Request $request){
         
        $validator = Validator::make($request->all(),[
            "address_type_id" => 'required|not_in:0',
            'country_id' => 'required|not_in:0', 
            'state_id' => 'required|not_in:0', 
            'town_id' => 'required|not_in:0', 
            'city_id' => 'required|not_in:0', 
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
            'pincode' => 'required'
        ]);
         
        if($validator->passes()){

          $storeAddress = storeAddress::where('id',$request->addressId)->update([
                'address_type_id' => $request->address_type_id,
                 'country_id' => $request->country_id,
                 'state_id' => $request->state_id,
                 'town_id' => $request->town_id,
                 'city_id' => $request->city_id,
                 'address' => $request->address,
                 'locality' => $request->locality,
                 'landmark' => $request->landmark,
                 'pincode' => $request->pincode,
                 ] ); 
            return response()->json(['success'=>true,'message' => "Store Addresss Updated Successfully"]); 
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            
            return response()->json(['errors'=>$errors]);
        }
} 
    // function deleteStoreAddress($id)
    // {
    //     $StoreAddress = StoreAddress::find($id);
    //     $StoreAddress->delete();
    //     return response()->json(['success'=>true,'message' => "Customer Addresss Deleted Successfully"]); 
    // }
     
}
