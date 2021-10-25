<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Lead;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Mail\OrgLeadEmailCode2;
use App\Mail\StoreWelcomeKitMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\leadToStoreVerifyEmailMail;
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Organization\StoreAddress;

class LeadToStoreController extends Controller
{
    public function index($leadId){
        
        $authUser = UserStore::find(auth('store')->user()->id);
        $lead = Lead::find($leadId);

        if($authUser->type == 'org' || $authUser->type == 'lab'){
            if($authUser->id == $lead->store_id){
                return view('store.lead_to_store.index',compact('lead'));
            } 
            
        } 
        if($authUser->type == 'user'){
            
            $managerIds = Helper::getSubRoleManagerIds();
            $lead = Lead::whereIn('store_user_id',$managerIds)->where('id',$leadId)->first();
             
            return view('store.lead_to_store.index',compact('lead'));
        }
      
      
    }

    public function checkVerificationStatus($leadId)
    {
        $lead = Lead::find($leadId);
        $term = 'Mini Store Role-Standard Ratti';
        $orgRole = OrgRole::where('name','LIKE','%'.$term.'%')->first();  
        Session::put('orgRoleId',$orgRole->id);
        return view('store.lead_to_store.verification_component',compact('lead','orgRole'));
    }


    public function sendEmailOtp(Request $request)
    { 
        $lead = Lead::where('id',$request->leadId)->first();
        if(!$lead->email_verify){

            $emailToken = $this->generateToken(20);
            $lead->update(['email_token'=>$emailToken]);
            $this->sendEmail($lead->email,$emailToken);
        }
        return response()->json(['success'=>true]);
    }

    public function sendEmail($email,$emailToken){
        
        Mail::to($email)->send(new LeadToStoreVerifyEmailMail($emailToken));

    }

    public function getSmsToken($leadId){
        
        $lead = Lead::where('id',$leadId)->first(); 
        if(!$lead->phone_verify){
            $smsToken = $this->generateToken(20);
            $lead->update(['sms_token'=>$smsToken]);

            return response()->json(['token'=>$smsToken]);
        }else{
            return response()->json(['success'=> false]);
        }
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

public function convert(Request $request){
        
        
        if(Session::get('orgRoleId') == $request->orgRoleId){

            $securityPin = Helper::generateNumericOTP(4);
            
           $lead = Lead::where('id',$request->leadId)->with('leadContacts')->first();
           if($lead->email != null || $lead->email != ''){

               if(UserStore::where('email', $lead->email)->doesntExist()){
    
                   $store = UserStore::create([
                      'store_role_id' => $request->orgRoleId,
                      'org_id' => $lead->store->id,
                      'name' => $lead->name,
                      'company_name' => $lead->company,
                      'email' => $lead->email,
                      'phone' => $lead->phone,
                      'whats_app' => $lead->whats_app,
                      'phone_country_code_id' => $lead->phone_country_code_id,
                      'whats_app_country_code_id' => $lead->whats_app_country_code_id,
                       'account_group_id' => 17,
                       'type' => 'org',
                      'security_pin' => $securityPin,
                      'sub_domain' => $request->subdomain,
                      'email_verify' => 1,
                      'phone_verify' => 1,
                      'created_by' => auth('store')->user()->id
                    ]); 
                        $StoreAddress =StoreAddress::create([
                          'address_type_id' => $lead->address_type_id ?? 1, 
                          'store_id' => $store->id ?? '', 
                          'country_id' => $lead->country_id ?? '',
                          'state_id' => $lead->state_id ?? '',
                          'town_id' => $lead->town_id ?? '',
                          'city_id' => $lead->city_id ?? '',
                          'address' => $lead->address ?? '',
                          'locality' => $lead->locality ?? '',
                          'landmark' => $lead->landmark ?? '',
                          'pincode' => $lead->pincode ?? '',
                         ]); 
                    
                    
                  // Lead Contacts Convert to Manager Account 
        
                  foreach ($lead->leadContacts as $contact) {
                      
                      UserStore::create([
                      'phone_country_code_id' => $contact->phone_country_code_id,
                      'whats_app_country_code_id' => $contact->whats_app_country_code_id,
                       'account_group_id' =>1,
                       'org_id' => $store->id,
                       'type' => 'user',
                       'name' => $contact->name ?? '',
                      'company_name' => $lead->company ?? '',
                      'email' => $contact->email ?? '',
                      'phone' => $contact->phone ?? '',
                      'whats_app' => $contact->whats_app ?? '', 
                      'status' => 0,
                      'created_by' => auth('store')->user()->id
                    ]);
        
                    }  
        
        
                    if($store){
                        $lead->update(['converted_to_store'=> 1]);
                        $this->welcomeKit($store->role->name,$securityPin,$store->email);
                        return response()->json(['success'=> true]);
                    }
               }else{
                    $msg =  'Organization Already Exists for Email : '.$lead->email;
                    return response()->json(['success'=> false,'exist'=>true,'msg'=> $msg]);
               }
           }else{
               $msg = 'Email Not Found';
            return response()->json(['success'=> false,'exist'=>true,'msg'=> $msg]);
           }
        }
}

public function welcomeKit($roleName,$securityPin,$email){
   Mail::to($email)->send(new StoreWelcomeKitMail($roleName,$securityPin)); 
}

}
