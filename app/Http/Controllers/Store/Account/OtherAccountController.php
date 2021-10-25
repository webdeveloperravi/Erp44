<?php

namespace App\Http\Controllers\Store\Account;

use App\Helpers\Helper;  
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Store\ManagerZone; 
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller; 
use App\Model\Admin\Master\CountryCode;
use App\Model\Admin\Master\AccountGroup; 
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Organization\TaxType;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity; 
use App\Model\Admin\Organization\AddressType; 

class OtherAccountController extends Controller
{   

    //Store Account
    public function index(){
        return view('store.account.other.index');
    }

    public function all(){
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
        $accounts = UserStore::with('headOfficeAddress','createdBy')->whereIn('id',$accountIds2)->where('type','others')->latest()->get()
        ;
         
    }
      if($authUser->type == 'org' || $authUser->type == 'lab')
      {
        $accounts = UserStore::with('headOfficeAddress','createdBy')->where('org_id',auth('store')->user()->id)->where('type','others')->latest()->get();
      } 
        return view('store.account.other.all',compact('accounts'));
    }
 
    public function create()
    {
        $accountGroups = AccountGroup::all();
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
        return view('store.account.other.create',compact('store','accountGroups','addressTypes','countries','countryCodes','countryCode','taxTypes'));
    }

    public function save(Request $request)
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
            'account_group_id' => 17, //17 Default For Sundary Debitors AccountGroup
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
    
    public function view($accountId)
    {
        $store = UserStore::find($accountId);
        
        return view('store.account.other.view',compact('store'));
    }

    public function edit($accountId)
    { 
       $store = UserStore::where(['id'=>$accountId])->first();
       $countryCodes = CountryCode::all();
       return view('store.account.other.edit',compact('store','countryCodes'));
    }

    public function update(Request $request)
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

    public function updateStatus($storeId)
    {   
         
        $store = UserStore::where('id',$storeId)->first();
         
        if($store->status == '1'){
            $store->update(['status'=>0]);
        }else{
            $store->update(['status'=>1]);

        }
    }

        
    public function subIndex($storeId){

        $store=UserStore::find($storeId);   
         return view('store.account.other.subIndex',compact('store'));
    
    }
    
    public function subView($storeId){
            $store = UserStore::find($storeId);
        return view('store.account.other.subview',compact('store'));
    }
    
    
}
