<?php

namespace App\Http\Controllers\Store;

use Stevebauman\Location\Facades\Location;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\AccountGroup;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\AddressType;


class SubStoreAccountController extends Controller
{
    
    public function index($storeId){

    $store=UserStore::find($storeId);   
     return view('store.subStore.account.index',compact('store'));

    }
    
    public function view($storeId){
         $store = UserStore::find($storeId);
        return view('store.subStore.account.view',compact('store'));
    }

    // ManagerAccount 
    public function managerAccountIndex($storeId){
        
        $store = UserStore::find($storeId);

        return view('store.subStore.account.manager.index',compact('store'));
    }
    
    public function getManagerAccounts($id){

        $accounts = UserStore::where('org_id',$id)->where('type','user')->get();
        return view('store.subStore.account.manager.all',compact('accounts'));
    }

    public function createManagerAccount($storeId){
        
        $accountGroups = AccountGroup::all();
        $addressTypes = AddressType::all();
        $countries = Country::all();
        $managerRoles = ManagerRole::where(['store_id' => auth('store')->user()->id, 'status' => 1])->get();
        $countryCodes = CountryCode::all();
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        }
        $countryCode = CountryCode::where('nicename',$currentCountryName)->first(); 
        $stores = UserStore::where('type','org')->orWhere('type','lab')->get();
        $store = UserStore::find($storeId);


        return view('store.subStore.account.manager.create',compact('stores','store','accountGroups','addressTypes','countries','managerRoles','countryCodes','countryCode'));
    }

    public function saveManagerAccount(Request $request){
      
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required|unique:user_store,phone|unique:leads,phone|unique:lead_contacts,phone|digits:10',
            'email' => 'required|email|unique:user_store,email|unique:leads,email|unique:lead_contacts,email',
            'whats_app' => 'required|unique:user_store,whats_app|unique:leads,whats_app|unique:lead_contacts,whats_app|digits:10',
            // 'role_id' => 'required|not_in:0',
           /* 'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
            'town_id' => 'required|not_in:0',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
            'pincode' => 'required'*/
        ]);
         
        if($validator->passes()){

        $store = UserStore::create([

            'org_id' => $request->store_id,
            'account_group_id' => $request->account_group_id,
            'manager_role_id' => 0,
            'name' => $request->name,
            'email' => $request->email,
            "phone" => $request->phone,
            "whats_app" => $request->whats_app,
            "phone_country_code_id" => $request->phone_country_code_id,
            "whats_app_country_code_id" => $request->whats_app_country_code_id,
            'type' => 'user',
            'security_pin' => Helper::generateNumericOTP(6),
          ]);
          if($store){ 
              
            $store->addresses()->create([
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
                 return response()->json(['success'=>true,'message' => "Manager Account Created Successfully"]);
          } 
     }else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all();
         $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
     }
    }

    public function viewManagerAccount($accountId){

      $managerAccount = UserStore::with('addresses')->where(['id' => $accountId, 'type'=>'user'])->first();
      return view('store.subStore.account.manager.view',compact('managerAccount'));

    }
 
    public function editManagerAccount($accountId){
  
        $store = UserStore::where(['id'=>$accountId])->first();
        $countryCodes = CountryCode::all();
        $managerRoles = ManagerRole::where(['store_id' => auth('store')->user()->id, 'status' => 1])->get();
        return view('store.subStore.account.manager.edit',compact('store','countryCodes','managerRoles'));
    }


    public function updateManagerAccount(Request $request)
    {
      
        $validator = Validator::make($request->all(),[
        'name' => 'required', 
        'phone' => 'required|unique:leads,phone|unique:lead_contacts,phone,|unique:user_store,phone'.$request->accountId,
        'email' => 'required|unique:leads,email|unique:lead_contacts,email|unique:user_store,email,'.$request->accountId,
        'whats_app' => 'required|unique:leads,whats_app|unique:lead_contacts,whats_app|unique:user_store,whats_app,'.$request->accountId,
        ]);
            
        if($validator->passes()){
            $store = UserStore::where(['id'=>$request->accountId])->first();
            $store->update([
                'name'=>$request->name,
                'company_name'=>$request->company,
                'manager_role_id'=>$request->role_id,
                'email'=>$request->email,
                "phone" => $request->phone,
                "whats_app" => $request->whats_app,
                "phone_country_code_id" => $request->phone_country_code_id,
                "whats_app_country_code_id" => $request->whats_app_country_code_id,
            ]);
            return response()->json(['success'=>true,'message' => "Manager Account Updated Successfully"]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    }


    public function verificationComponentView($accountId)
    {
        $store  = UserStore::find($accountId);
        return view('store.subStore.account.subStore.verificationComponent',compact('store'));
    }

    public function verificationComponentManager($accountId)
    {
        $subStoreManager  = UserStore::find($accountId);
        return view('store.subStore.account.manager.verificationComponent',compact('subStoreManager'));
    }

    public function getVerificationComponent($accountId){
    $store  = UserStore::find($accountId);
    return view('store.account.storeVerificationComponent',compact('store'));
}

    public function verificationComponentCustomer($accountId)
    {
        $store  = UserStore::find($accountId);
        return view('store.subStore.account.customer.verificationComponent',compact('store'));
    }




}
