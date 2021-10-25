<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Cash;
use App\Model\Store\Lead;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Store\ManagerZone;
use App\Mail\StoreWelcomeKitMail;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Model\Admin\Master\CountryCode;
use App\Model\Admin\Master\AccountGroup;
use App\Model\Admin\Master\CountryState;
use Illuminate\Support\Facades\Session; 
use App\Mail\StoreAccountEmailVerifyMail;
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Organization\TaxType;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use Stevebauman\Location\Facades\Location;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
use App\Model\Admin\Organization\StoreAddress;

class StoreAccountController extends Controller
{   
    protected $storeAccountGroupId = 17;
    protected $customerAccountGroupId = 22;

    //Store Account
    public function storeAccountIndex(){
        return view('store.account.store.index');
    }

    public function getStoreAccounts(){
    $authUser = auth('store')->user();
    if($authUser->type =='user')
    {    
        $managerIds = Helper::getSubRoleManagerIds(); 
        
        $accountIds1 = UserStore::whereIn('created_by',$managerIds)->where('type','org')->pluck('id')->toArray();
          
        $zoneIds = ManagerZone::where('manager_id',$authUser->id)->pluck('zone_id')->toArray(); 
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $accountIds2 = UserStore::whereHas('addresses',function($q) use ($zoneCities){
            $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
        ->pluck('id')->toArray();  
        $accounts = UserStore::with('headOfficeAddress','createdBy')->whereIn('id',$accountIds2)->where('type','org')->latest()->get()
        ;
         
    }
      if($authUser->type == 'org' || $authUser->type == 'lab')
      {
        $accounts = UserStore::with('headOfficeAddress','createdBy')->where('org_id',auth('store')->user()->id)->where('type','org')->latest()->get();
      } 
        return view('store.account.store.all',compact('accounts'));
    }

    public function searchStore(Request $request)
    {
        // dd($request->all());
        $columns = Schema::getColumnListing('user_store');

        $query = UserStore::query(); 
                
        foreach($columns as $column){
            $query->orWhere($column, 'LIKE', '%' . $request->find . '%');
        }
        // $query->whereHas('primaryAddress',function($query) use ($request){
        //     $query = $query;
        //     $columns = Schema::getColumnListing('store_address');
        //     foreach($columns as $column){
        //     $query->orWhere($column, 'LIKE', '%' . $request->find . '%');
        // }
        // });  
        $accounts = $query->get();
        return view('store.account.store.all',compact('accounts'));
        
    }

    public function createStoreAccount()
    {
        $accountGroup = AccountGroup::find($this->storeAccountGroupId); 
        $addressTypes = AddressType::all();
        $countries = Country::all();
        $countryCodes = CountryCode::all();
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        }
        $countryCode = CountryCode::where('nicename',$currentCountryName)->first();
        $store =  UserStore::find(StoreHelper::getStoreId());
        $taxTypes = TaxType::all();
        return view('store.account.store.create',compact('store','accountGroup','addressTypes','countries','countryCodes','countryCode','taxTypes'));
    }

    public function saveStoreAccount(Request $request)
    {   
        $rules = [
            'name' => 'required',
            'company' => 'required',
            'phone' => 'required|unique:user_store,phone|unique:leads,phone|unique:lead_contacts,phone|digits:10',
            'email' => 'required|email|unique:user_store,email|unique:leads,email|unique:lead_contacts,email',
            'whats_app' => 'required|unique:user_store,whats_app|unique:leads,whats_app|unique:lead_contacts,whats_app|digits:10', 
            'gst_number' => 'nullable|max:15'
        ];
        if(strlen($request->gst_number) > 0){
             $rules['tax_type'] = 'required|not_in:0';
        }  

        $validator = Validator::make($request->all(),$rules);

        if($validator->passes()){

        // $term = 'Mini Store Role-Standard Ratti';
        // $orgRole = OrgRole::where('name','LIKE','%'.$term.'%')->first();   
        // dd($orgRole);
        $store = UserStore::create([
            'store_role_id' => 1, //1 For Mini Store Role-Standard Ratti
            'org_id' => StoreHelper::getStoreId(),
            'name' => $request->name,
            'company_name' => $request->company,
            'email' => $request->email,
            "phone" => $request->phone,
            "whats_app" => $request->whats_app,
            "phone_country_code_id" => $request->phone_country_code_id,
            "whats_app_country_code_id" => $request->whats_app_country_code_id,
            'account_group_id' => $this->storeAccountGroupId,  
            'type' => 'org', //All Stores Type Org 
            'security_pin' => bcrypt(Helper::generateNumericOTP(4)),  
            'created_by' => auth('store')->user()->id
          ]);  
            if($store){ 
            // $this->welcomeKit($store->role->name,$store->security_pin,$store->email); 
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
                //  'tax_type_id' => $request->tax_type,
                 'gst_number' => $request->gst_number,
            ]); 
            $store->domains()->create(['name' => str_replace(' ', '',substr($request->company,0,8)) ?? "",'domain_type_id'=> 2]);

            $managerRole = ManagerRole::create([
                'name' => 'Manager',
                'alias' => 'Manager',
                'description' => 'Manager',
                'parent_id' =>  0,
                'store_id' => $store->id,
            ]);  
 

        return response()->json(['success'=>true,'message' => "Store Account Created Successfully"]); 
          } 
     }else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all(); 
         $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
     }
    }
    
    public function viewStoreAccount($accountId)
    {
        $store = UserStore::find($accountId);
        
        return view('store.account.store.view',compact('store'));
    }

    public function editStoreAccount($accountId)
    { 
       $store = UserStore::where(['id'=>$accountId])->first();
       $countryCodes = CountryCode::all();
       return view('store.account.store.edit',compact('store','countryCodes'));
    }

    public function updateStoreAccount(Request $request)
    {  
       
      $validator = Validator::make($request->all(),[
            'name' => 'required',
            'company' => 'required', 
            'phone' => 'required|unique:leads,phone|unique:lead_contacts,phone|unique:user_store,phone,'.$request->accountId,
            'email' => 'required|unique:leads,email|unique:lead_contacts,email|unique:user_store,email,'.$request->accountId,
            'whats_app' => 'required|unique:leads,whats_app|unique:lead_contacts,whats_app|unique:user_store,whats_app,'.$request->accountId, 

            
        ]);
         
          
        if($validator->passes()){
            $store = UserStore::where(['id'=>$request->accountId])->first();
            $store->update(['name'=>$request->name,'company_name'=>$request->company,'email'=>$request->email,'phone'=>$request->phone, 'whats_app' => $request->whats_app,'phone_country_code_id' => $request->phone_country_code_id,'whats_app_country_code_id'=>$request->whats_app_country_code_id]);
            return response()->json(['success'=>true,'message' => "Store Account Updated Successfully"]);
          } 
        else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all();
         $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
     }
    }

    public function changeStoreAccountStatus($storeId)
    {   
         
        $store = UserStore::where('id',$storeId)->first();
         
        if($store->status == '1'){
            $store->update(['status'=>0]);
        }else{
            $store->update(['status'=>1]);

        }
    }
    

    // ManagerAccount 
    public function managerAccountIndex(){
        return view('store.account.manager.index');
    }
    
    public function getManagerAccounts(){

        $authUser = UserStore::where('id',auth('store')->user()->id)->first();
        if($authUser->type =='user')
        {  
           $managerIds = Helper::getSubRoleManagerIds();
           $accounts = UserStore::whereIn('created_by',$managerIds)->where('type','user')->latest()->get();
        }
          if($authUser->type == 'org' || $authUser->type == 'lab')
          {
            $accounts = UserStore::where('org_id',auth('store')->user()->id)->where('type','user')->latest()->get();
            // dd($accounts);
          } 
 
        return view('store.account.manager.all',compact('accounts'));
    }

    public function createManagerAccount(){
        $accountGroups = AccountGroup::all();
        $addressTypes = AddressType::all();
        $countries = Country::all();
        $managerRoles = ManagerRole::where(['store_id' => StoreHelper::getStoreId(), 'status' => 1])->get();
        $countryCodes = CountryCode::all();
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        }
        $countryCode = CountryCode::where('nicename',$currentCountryName)->first(); 
        $store =  UserStore::find(StoreHelper::getStoreId()); 
        return view('store.account.manager.create',compact('store','accountGroups','addressTypes','countries','managerRoles','countryCodes','countryCode'));
    }

    public function saveManagerAccount(Request $request){
      
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required|unique:user_store,phone|unique:leads,phone|unique:lead_contacts,phone|digits:10',
            'email' => 'required|email|unique:user_store,email|unique:leads,email|unique:lead_contacts,email',
            'whats_app' => 'required|unique:user_store,whats_app|unique:leads,whats_app|unique:lead_contacts,whats_app|digits:10',
            'role_id' => 'required|not_in:0',
            // 'country_id' => 'required|not_in:0',
            // 'state_id' => 'required|not_in:0',
            // 'city_id' => 'required|not_in:0',
            // 'address' => 'required',
            // 'locality' => 'required',
            // 'landmark' => 'required',
            // 'pincode' => 'required'
        ]);
         
        if($validator->passes()){

        $store = UserStore::create([
            
            'org_id' => StoreHelper::getStoreId(),
            'account_group_id' => $request->account_group_id,
            'manager_role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            "phone" => $request->phone,
            "whats_app" => $request->whats_app,
            "phone_country_code_id" => $request->phone_country_code_id,
            "whats_app_country_code_id" => $request->whats_app_country_code_id,
            'type' => 'user',
            'security_pin' => Helper::generateNumericOTP(6), 
            'created_by' => auth('store')->user()->id,
            'status' =>  0
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
        
        return view('store.account.manager.view',compact('managerAccount'));
    }
 
    public function editManagerAccount($accountId){
  
        $store = UserStore::where(['id'=>$accountId])->first();
        $countryCodes = CountryCode::all();
        $managerRoles = ManagerRole::where(['store_id' => auth('store')->user()->id, 'status' => 1])->get();
        return view('store.account.manager.edit',compact('store','countryCodes','managerRoles'));
    }


    public function updateManagerAccount(Request $request)
    {

        $validator = Validator::make($request->all(),[
        'name' => 'required', 
        'role_id' => 'required|not_in:0',  
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

    public function changeManagerAccountStatus($managerId)
    {   
         
        $manager = UserStore::where('id',$managerId)->first();
         
        if($manager->status == '1'){
            $manager->update(['status'=>0]);
        }else{
            $manager->update(['status'=>1]);

        }
    }


    public function verificationComponentView($accountId)
    {
        $store  = UserStore::find($accountId);
        return view('store.account.store.verificationComponent',compact('store'));
    }

    // public function verificationComponentManager($accountId)
    // {
    //     $managerAccountId  = UserStore::find($accountId);
    //     return view('store.account.manager.verificationComponent',compact('managerAccountId'));
    // }

    // public function verificationComponentCustomer($accountId)
    // {
    //     $customerAccountId  = UserStore::find($accountId);
    //     return view('store.account.customer.verificationComponent',compact('customerAccountId'));
    // }





//     public function saveStoreAccountAddress(Request $request){
       
//         $store  = UserStore::find($request->store_id);
//          StoreAddress::create([
//             'store_id' => $request->store_id,
//              'address_type_id' => $request->address_type_id,
//              'country_id' => $request->country_id,
//              'state_id' => $request->state_id,
//              'city_id' => $request->city_id,
//              'address' => $request->address,
//              'locality' => $request->locality,
//              'landmark' => $request->landmark,
//              'pincode' => $request->pincode,
//            ]); 
//          return response()->json(['success'=>true]);
//         // return $this->storeVerificationComponent($store->id);
//   }
  
//  public function storeVerificationComponent($storeId){
    
//     $store  = UserStore::find($storeId);
//     return view('store.account.storeVerificationComponent',compact('store'));
// }


public function sendEmailOtp(Request $request)
{ 
   $account = UserStore::where('id',$request->accountId)->first();
    if(!$account->email_verify){
        $emailToken = $this->generateToken(20);
        $account->update(['email_token'=>$emailToken]);
        $this->sendEmail($account->email,$emailToken);
    }
    return response()->json(['success'=>true]);
}

public function sendEmail($email,$emailToken){
    
    Mail::to($email)->send(new StoreAccountEmailVerifyMail($emailToken));
}

public function generateToken($length =20){
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

public function getSmsToken($accountId){

    $account = UserStore::where('id',$accountId)->first();
if(!$account->phone_verify){
    $smsToken = $this->generateToken(20);
    $account->update(['sms_token'=>$smsToken]);
    return response()->json(['token'=>$smsToken]);
}else{
    return response()->json(['success'=> false]);
}
}

public function getVerificationComponent($accountId){
    $store  = UserStore::find($accountId);
    return view('store.account.storeVerificationComponent',compact('store'));
}
     
      public function checkVerificationStatus($leadId)
    {
        $lead = Lead::find($leadId);
        $term = 'Mini Store Role-Standard Ratti';
        $orgRole = OrgRole::where('name','LIKE','%'.$term.'%')->first();  
        Session::put('orgRoleId',$orgRole->id);
        return view('store.lead_to_store.verification_component',compact('lead','orgRole'));
    }

    //Customer Account
    public function customerAccountIndex(){
        return view('store.account.customer.index');
    }
    
    public function getCustomerAccounts(){
        $accounts = UserStore::where('org_id',auth('store')->user()->id)->whereIn('type',['customer','others'])->get();
        return view('store.account.customer.all',compact('accounts'));
    }

    public function createCustomerAccount(){

        $accountGroup = AccountGroup::find($this->customerAccountGroupId);
        $addressTypes = AddressType::all();
        $countries = Country::all();
        $countryCodes = CountryCode::all();
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        }
        $countryCode = CountryCode::where('nicename',$currentCountryName)->first(); 
        $stores = UserStore::where('type','org')->orWhere('type','lab')->get();
        return view('store.account.customer.create',compact('accountGroup','addressTypes','countries','countryCodes','countryCode'));
    }

    public function saveCustomerAccount(Request $request){
         
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required|unique:user_store,phone',
            // 'email' => 'required|email|unique:user_store,email',
            // 'country_id' => 'required|not_in:0',
            // 'state_id' => 'required|not_in:0',
            // 'town_id' => 'required|not_in:0',
            // 'city_id' => 'required|not_in:0',
            // 'address' => 'required',
            // // 'locality' => 'required',
            // // 'landmark' => 'required',
            // 'pincode' => 'required'
        ]);
         
        if($validator->passes()){ 

        $store = UserStore::create([ 
            'org_id' => StoreHelper::getStoreId(),
            'name' => $request->name,
            'email' => $request->email,
            "phone" => $request->phone,
            "whats_app" => $request->whats_app,
            "phone_country_code_id" => $request->phone_country_code_id,
            "whats_app_country_code_id" => $request->whats_app_country_code_id,
            'account_group_id' => $this->customerAccountGroupId,
            'type'=> 'others',
            'security_pin' => Helper::generateNumericOTP(6), 
          ]);  
          if($store){ 
            // $this->welcomeKit($store->role->name,$store->security_pin,$store->email); 
            $store->addresses()->create([
                 // 'address_type_id' => $request->address_type_id,
                 'country_id' => $request->country_id,
                 'state_id' => $request->state_id,
                 'town_id' => $request->town_id,
                 'city_id' => $request->city_id,
                 'address' => $request->address,
                 'locality' => $request->locality,
                 'landmark' => $request->landmark,
                 'pincode' => $request->pincode,
                 ] ); 
                 return response()->json(['success'=>true,'message' => "Customer Account Created Successfully"]); 
          } 
     }else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all();
         $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
     }
    }

    public function viewCustomerAccount($accountId)
    {
        $store = UserStore::with('addresses')->where(['id' => $accountId, 'type'=>'customer'])->first();
        return view('store.account.customer.view',compact('store'));
    }

    public function editCustomerAccount($accountId){
       
        $store = UserStore::where(['id'=>$accountId])->first();
        $countryCodes = CountryCode::all();
        
      
        return view('store.account.customer.edit',compact('store','countryCodes'));
    }

    public function updateCustomerAccount(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'name' => 'required',
        'phone' => 'required|unique:user_store,phone,'.$request->accountId,
        // 'email' => 'required|email|unique:user_store,email,'.$request->accountId
        ]);
            
        if($validator->passes()){

        $store = UserStore::where(['id'=>$request->accountId])->first();
        $store->update([
            'name'=>$request->name,
            'company_name'=>$request->company,
            'email'=>$request->email,
            'phone'=>$request->phone, 
            ]);
        return response()->json(['success'=>true,'message' => "Customer Account Updated Successfully"]);
        } 
        else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
         }
    }









    
}
