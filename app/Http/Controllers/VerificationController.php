<?php

namespace App\Http\Controllers;

use App\Model\Store\Lead;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verifyLeadPhone($token){
        
        $lead  = Lead::where('sms_token',$token)->first();
        if($lead){
            $lead->update(['phone_verify'=> 1]);
            return view('email_templates.messages.success');
        }else{
           return view('email_templates.messages.failed');
        }
    }

    public function verifyLeadEmail($token){
        
        $lead  = Lead::where('email_token',$token)->first();
        if($lead){
            $lead->update(['email_verify'=> 1]);
            return view('email_templates.messages.success');
        }else{
            return view('email_templates.messages.failed');
        }
    }
    public function verifyStorePhone($token){
        
        $store  = UserStore::where('sms_token',$token)->first();
        if($store){
            $store->update(['phone_verify'=> 1]);
            return view('email_templates.messages.success');
        }else{
           return view('email_templates.messages.failed');
        }
    }

    public function verifyStoreEmail($token){
        
        $store  = UserStore::where('email_token',$token)->first();
        if($store){
            $store->update(['email_verify'=> 1]);
           return view('email_templates.messages.success');
        }else{
          return view('email_templates.messages.failed');
        }
    }

}
