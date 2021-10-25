<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\CountryState;
use Illuminate\Support\Facades\Session; 
use App\Model\Admin\Organization\TaxType;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
use App\Model\Admin\Organization\StoreAddress;

class AccountAddressesController extends Controller
{
   
    //Store
    public function storeAddressIndex($accountId)
    { 
      return view('store.account.store.addresses.index',compact('accountId'));
    }

     public function getStoreAddresses($accountId)
     {
       $addresses = StoreAddress::where('store_id',$accountId)->get();
      
       return view('store.account.store.addresses.all',compact('addresses'));
     }

     public function createStoreAddress($accountId){
      $countries = Country::all(); 
      $states = CountryState::all();
      $cities = CountryStateCity::all();
      $addressTypes = AddressType::all();
      $taxTypes = TaxType::all();
   
     return view('store.account.store.addresses.create',compact('countries','states','cities','addressTypes','accountId','taxTypes'));

     }

     public function saveStoreAddress(Request $request)
     {
        $rules = [
          "address_type_id" => 'required|not_in:0',
          'country_id' => 'required|not_in:0',
          'state_id' => 'required|not_in:0',
          'city_id' => 'required|not_in:0',
          'town_id' => 'required|not_in:0',
          'address' => 'required',
          'locality' => 'required',
          'landmark' => 'required',
          'pincode' => 'required',
          'gst_number' => 'nullable|max:15'
        ]; 

        $validator = Validator::make($request->all(),$rules); 
         
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
            // 'tax_type_id' => $request->tax_type,
            'gst_number' => $request->gst_number,
          ]);
           
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    }

    public function  editStoreAddress($id)
    { 

      $address = StoreAddress::find($id);
      $countries = Country::all(); 
      $states = CountryState::where('country_id',$address->country_id)->get();
      $cities = CountryStateCity::where('state_id',$address->state_id)->get(); 
      $addressTypes = AddressType::all();
      $taxTypes = TaxType::all();

      return view('store.account.store.addresses.edit',compact('address','addressTypes','countries','states','cities','taxTypes'));
    }
    
    function updateStoreAddress(Request $request){
          
      $rules = [
        "address_type_id" => 'required|not_in:0',
        'country_id' => 'required|not_in:0',
        'state_id' => 'required|not_in:0',
        'city_id' => 'required|not_in:0',
        'town_id' => 'required|not_in:0',
        'address' => 'required',
        'locality' => 'required',
        'landmark' => 'required',
        'pincode' => 'required',
        'gst_number' => 'nullable|max:15'
      ]; 
      $validator = Validator::make($request->all(),$rules); 
         
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
                //  'tax_type_id' => $request->tax_type,
                 'gst_number' => $request->gst_number,
                 ] ); 
            return response()->json(['success'=>true,'message' => "Store Addresss Updated Successfully"]); 
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            
            return response()->json(['errors'=>$errors]);
        }
} 

    function deleteStoreAddress($id)
    {
        $StoreAddress = StoreAddress::find($id);
        $StoreAddress->delete();
        return response()->json(['success'=>true,'message' => "Customer Addresss Deleted Successfully"]); 
    }


    //Manager 
    public function managerAddressIndex($accountId)
    { 
      return view('store.account.manager.managerView.addresses.index',compact('accountId'));
    }

     public function getManagerAddresses($accountId)
     {
       $addresses = StoreAddress::where('store_id',$accountId)->get();
      
       return view('store.account.manager.managerView.addresses.all',compact('addresses'));
     }

     public function createManagerAddress($accountId){
      $countries = Country::all(); 
      $states = CountryState::all();
      $cities = CountryStateCity::all();
      $addressTypes = AddressType::all();
   
     return view('store.account.manager.managerView.addresses.create',compact('countries','states','cities','addressTypes','accountId'));

     }

     public function saveManagerAddress(Request $request)
     {
        $validator = Validator::make($request->all(),[
            "address_type_id" => 'required|not_in:0',
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
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

    public function  editManagerAddress($id)
    { 

      $address = StoreAddress::find($id);
      $countries = Country::all(); 
      $states = CountryState::where('country_id',$address->country_id)->get();
      $cities = CountryStateCity::where('state_id',$address->state_id)->get(); 
      $addressTypes = AddressType::all();

      return view('store.account.manager.managerView.addresses.edit',compact('address','addressTypes','countries','states','cities'));
    }
    
    function updateManagerAddress(Request $request){
         
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

      function deleteManagerAddress($id)
      {
          $StoreAddress = StoreAddress::find($id);
          $StoreAddress->delete();
          return response()->json(['success'=>true,'message' => "Customer Addresss Deleted Successfully"]); 
      }

    //Customer 
    public function customerAddressIndex($accountId)
    { 
      return view('store.account.customer.addresses.index',compact('accountId'));
    }

     public function getCustomerAddresses($accountId)
     {
       $addresses = StoreAddress::where('store_id',$accountId)->get();
      
       return view('store.account.customer.addresses.all',compact('addresses'));
     }

     public function createCustomerAddress($accountId){
      $countries = Country::all(); 
      $states = CountryState::all();
      $cities = CountryStateCity::all();
      $addressTypes = AddressType::all();
   
     return view('store.account.customer.addresses.create',compact('countries','states','cities','addressTypes','accountId'));

     }

     public function saveCustomerAddress(Request $request)
     {
        $validator = Validator::make($request->all(),[
            "address_type_id" => 'required|not_in:0',
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
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

    public function  editCustomerAddress($id)
    { 

      $address = StoreAddress::find($id);
      $countries = Country::all(); 
      $states = CountryState::where('country_id',$address->country_id)->get();
      $cities = CountryStateCity::where('state_id',$address->state_id)->get(); 
      $addressTypes = AddressType::all();

      return view('store.account.customer.addresses.edit',compact('address','addressTypes','countries','states','cities'));
    }
    
    function updateCustomerAddress(Request $request){
         
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

      function deleteCustomerAddress($id)
      {
          $StoreAddress = StoreAddress::find($id);
          $StoreAddress->delete();
          return response()->json(['success'=>true,'message' => "Customer Addresss Deleted Successfully"]); 
      }
}
