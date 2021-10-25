<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ReauthenticateController extends Controller
{
   public function reauthenticate(){
         return view('Reauthenticate.index');
   }

   public function processReauthenticate(Request $request){ 
    if(auth('store')->check()){
        $request->validate([
            'pin' => [ 
                function($attribute,$value,$fail){
                    if(!Hash::check($value,auth('store')->user()->security_pin)){
                       return $fail('Invalid Pin');
                    }
                },
            ],
        ]);
        
        if(Hash::check($request->pin,auth('store')->user()->security_pin)){
            Session::put('reauthenticate.last_authentication',time());  
            if(Session::has('reauthenticate.requested_url')){
                return redirect(Session::get('reauthenticate.requested_url'));
            }else{
               return redirect()->route('store.dashboard');
            } 
        }
    }elseif(auth('warehouse')->check()){
        $request->validate([
            'pin' => [ 
                function($attribute,$value,$fail){
                    if(!Hash::check($value,auth('warehouse')->user()->security_pin)){
                      return  $fail('Invalid Pin');
                    }
                },
            ],
        ]);
        
        if(Hash::check($request->pin,auth('warehouse')->user()->security_pin)){
            Session::put('reauthenticate.last_authentication',time());
            return redirect(Session::get('reauthenticate.requested_url'));
        }
    }elseif(auth('admin')->check()){
        $request->validate([
            'pin' => [ 
                function($attribute,$value,$fail){
                    if(!Hash::check($value,auth('admin')->user()->security_pin)){
                        $fail('Invalid Pin');
                    }
                },
            ],
        ]);
        
        if(Hash::check($request->pin,auth('admin')->user()->security_pin)){
            Session::put('reauthenticate.last_authentication',time());
            return redirect(Session::get('reauthenticate.requested_url'));
        }
    }else{
        abort(404);
    }
   }
}
