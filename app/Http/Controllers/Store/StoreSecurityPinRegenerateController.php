<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerZone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\SecurityPinRegenerateRequest;

class StoreSecurityPinRegenerateController extends Controller
{
    public function index()
    {
        return view('store.SecurityPinRegenerateRequest.index');
    }

    public function sendRequest(Request $request)
    {  
        $authUser = auth('store')->user(); 
        if(SecurityPinRegenerateRequest::where(['requestable_id'=>$authUser->id,'resolved_by' => null])->exists()){
            return response()->json(['success'=>true,'msg'=> 'Request Already Submitted']);
        }else{
            UserStore::find($authUser->id)->securityPinRegenerateRequests()->create([
                'message' => $request->message, 
            ]);
            return response()->json(['success'=>true,'msg'=> 'Request Send Successfully']);
        }
        
    }

    public function allRequests(){
        
        $authUser = auth('store')->user();
        $accounts = UserStore::where('org_id',StoreHelper::getUserStoreId($authUser->id))
        ->where('type','user')
        ->pluck('id')->toArray();
        $requests = SecurityPinRegenerateRequest::with('securityPinRegenerateRequestable')->whereIn('requestable_id',$accounts)->latest()->get(); 

    //     if($authUser->type =='user')
    //     {    
    //         $managerIds = Helper::getSubRoleManagerIds(); 
            
    //         $accountIds1 = UserStore::whereIn('created_by',$managerIds)->where('type','org')->pluck('id')->toArray();
            
    //         $zoneIds = ManagerZone::where('manager_id',$authUser->id)->pluck('zone_id')->toArray(); 
    //         $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
    //         $accountIds2 = UserStore::whereHas('addresses',function($q) use ($zoneCities){
    //             $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
    //         })->where('type','org')->orWhere('type','lab')
    //         ->pluck('id')->toArray();  
    //         $accounts = UserStore::with('headOfficeAddress','createdBy')->whereIn('id',$accountIds2)->where('type','org')->pluck('id')->toArray()
    //         ;
            
    //     }
    //     if($authUser->type == 'org' || $authUser->type == 'lab')
    //     {
         
    //     $accounts = UserStore::with('headOfficeAddress','createdBy')->where('org_id',auth('store')->user()->id)->where('type','org')->pluck('id')->toArray();
    //     $accounts=array_merge($accounts,[StoreHelper::getStoreId()]);
       
    // } 
    //     $authUser = UserStore::where('id',auth('store')->user()->id)->first();
    //     if($authUser->type =='user')
    //     {  
    //        $managerIds = Helper::getSubRoleManagerIds();
    //        $accounts2 = UserStore::whereIn('created_by',$managerIds)->where('type','user')->pluck('id')->toArray();
    //     }
    //       if($authUser->type == 'org' || $authUser->type == 'lab')
    //       {
    //         $accounts2 = UserStore::where('org_id',auth('store')->user()->id)->where('type','user')->pluck('id')->toArray();
    //       } 


    //     $requests = UserStore::whereIn('id',array_merge($accounts,$accounts2))->pluck('id')->toArray();
    //     $requests = SecurityPinRegenerateRequest::with('securityPinRegenerateRequestable')->whereIn('requestable_id',$requests)->latest()->get(); 
        // dd($requests);
        return view('store.SecurityPinRegenerateRequest.all',compact('requests'));
    }

    public function resolve(Request $request)
    { 
        $securityPin = Helper::generateNumericOTP(4);
        $requestData =  SecurityPinRegenerateRequest::find($request->requestId);
        
        $requestData->update([
            'resolved_by' => auth('store')->user()->id,
        ]);

        $user =  UserStore::find($requestData->requestable_id);
        $user->update([
            'security_pin' => bcrypt($securityPin),
        ]); 

        $mobile =$user->getPhoneWithCode($user->id);  
        $response = Http::withHeaders([
            'authkey' => '366219AHCQOCsL6142f86aP1',
            'content-type' => 'application/JSON'
        ])->post('https://api.msg91.com/api/v5/flow/', [ 
            'flow_id' => '61545ff0b82ac0701c50add8',
            'sender' => 'Gemlab',
            'mobiles' => $mobile,
            'pin' => $securityPin,
        ]); 
        // dd($mobile);
        // $sms= Http::get( "https://api.msg91.com/api/v5/otp/verify?authkey=366219AVJcx9z5cdET61247ee8P1&mobile=".$mobile."&otp=".$securityPin);
        

        // $msg= json_decode($sms);
        // return $msg;

        // Http::withHeaders([
        //     'Authorization' => 'qSrGgsZCQYOIf9WTP6He_w==',
        //     'Content-Type' => 'application/json'
        // ])->post('https://platform.clickatell.com/v1/message', [
        //     "messages"=> [ 
        //         [
        //             "channel"=> "sms",
        //             "to"=> $user->getPhoneWithCode($user->id),
        //             "content"=>"Login Pin Updated".' '.$securityPin,
        //         ]
        //     ]
        // ]);
        // $this->sendSms($securityPin,$user);
        return response()->json(['success'=>true,'msg'=> $mobile]);
    }

    public function resetDirect(Request $request)
    { 
        $securityPin = Helper::generateNumericOTP(4);
        // $requestData =  SecurityPinRegenerateRequest::find($request->requestId);
        
        // $requestData->update([
        //     'resolved_by' => auth('store')->user()->id,
        // ]);

        $user =  UserStore::find($request->authId);
        $user->update([
            'security_pin' => bcrypt($securityPin),
        ]); 

        $mobile =$user->getPhoneWithCode($user->id);  
        $response = Http::withHeaders([
            'authkey' => '366219AHCQOCsL6142f86aP1',
            'content-type' => 'application/JSON'
        ])->post('https://api.msg91.com/api/v5/flow/', [ 
            'flow_id' => '61545ff0b82ac0701c50add8',
            'sender' => 'Gemlab',
            'mobiles' => $mobile,
            'pin' => $securityPin,
        ]); 
        
        return true;
    }

    public function sendSms($pin,$user)
    {
    //      try{
    //     Http::withHeaders([
    //       'Authorization' => 'qSrGgsZCQYOIf9WTP6He_w==',
    //       'Content-Type' => 'application/json'
    //   ])->post('https://platform.clickatell.com/v1/message', [
    //       "messages"=> [ 
    //           [
    //               "channel"=> "sms",
    //               "to"=> $user->getPhoneWithCode($user->id),
    //               "content"=>"ERP44 Security Pin Updated ". $pin,
    //           ]
    //       ]
    //   ]);
    //   }catch(Exception $exception){
    //      dd($exception);
    //   }
    }
}
