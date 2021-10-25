<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\Request; 
use App\Model\Guard\UserAdmin;
use App\Mail\TitleParagraphMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\Login\LoginOtpMail;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{

    public function index()
    { 
      if(Auth::guard('admin')->check()){
        return redirect()->route('admin.dashboard');
      } 
      return view('admin.auth.login.index');
    }

    public function loginForm(){

      
      return view('admin.auth.login.login');
    }

    public function verifyAccount(Request $request)
    {  
      
     $validator = Validator::make($request->all(),[
            'email' => 'required',
     ],
     ['email.required'=> 'Please Enter Valid Email or Phone']
    );
     if($validator->passes())
     {
      if(str_contains($request->email,'@')){
        
        if(UserAdmin::where(['email'=>$request->email])->exists()){
             $admin =UserAdmin::where(['email'=>$request->email])->first();
             $otp_code = Helper::generateNumericOTP(6);
             $updated_otp = $admin->update([
                             'otp_code' => $otp_code,
                             ]);  
             $this->send_otp($otp_code,$admin->email);
             return view('admin.auth.login.otp',compact('otp_code','admin'));   
        }else{
          return response()->json(['success'=>false,'msg'=>'Please Enter Valid Email']);
        }    

      }elseif(is_numeric($request->email)){

         if(UserAdmin::where(['phone'=>$request->email])->exists()){
            $admin =UserAdmin::where(['phone'=>$request->email])->first();
            $otp_code = Helper::generateNumericOTP(6);
            $updated_otp = $admin->update([
                            'otp_code' => $otp_code,
                            ]);  
            $this->sendWhatsAppOtp($otp_code,$admin);                
            $this->send_otp($otp_code,$admin->email);
            return view('admin.auth.login.otp',compact('otp_code','admin'));
         }else{
           return response()->json(['success'=>false,'msg'=>'Please Enter Valid Phone']);
          } 
     }else{
        return response()->json(['success'=>false,'msg'=>'Please Enter Valid Email']);
     }
     }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
      }
    }

    public function sendWhatsAppOtp($otp_code,$admin){
      // ?token=12819&no="+number+"&text="+message
      // return Http::get('http://whatsapp2.webtecz.com/api/send.php?token=12819&no=919914263105&text=msg');
     return  Http::get('http://whatsapp2.webtecz.com/api/send.php',[
          'token' => 12819,
         'no' => $admin->getWhatsAppWithCode($admin->id),
         'text' => '9Gem Admin Login OTP'." ".$otp_code
       ]);
    } 
    
    public function send_otp($otp,$email)
    {
      Mail::to($email)->send(new LoginOtpMail('Admin Login OTP',$otp));
          return true;
    }
 
     public function verifyOTP(Request $request)
    {
    
     $validator = Validator::make($request->all(),[
            'otp_code' => 'required',
     ],
    ['otp_code.required' => 'Invalid OTP']);
     if($validator->passes()){
         
         $admin = UserAdmin::find($request->id);
         if($admin->otp_code == $request->otp_code)
         {
           if(Auth::guard('admin')->loginUsingId($admin->id)){   
              $this->setSecurityPinStatus(1); 
              return response()->json(['success'=>true]); 
           }
         }else{
           return response()->json(['success'=>false,'msg'=>'Invalid OTP']);
         }
     }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
       }
    }

   public function profile(){
     
      $adminID=auth('admin')->user()->id;
      $user = UserAdmin::where(['id'=>$adminID])->first();
      return view('admin.admin.profile',compact('user'));
   }

    public function logout(Request $request)
    {
      Auth::guard('admin')->logout(); 
      return redirect()->route('admin');
    }
  
    public function securityPinVerify(Request $request){
      
      if(UserAdmin::where(['id'=> auth('admin')->user()->id,'security_pin'=>$request->security_pin])->exists())
      {    
        $this->setSecurityPinStatus(0);
        return true;  
      }
      else
      {
        return false;
      }
    }

    public function setSecurityPinStatus($status){
     
      $user = UserAdmin::where('id',auth('admin')->user()->id)->first();
      $user->update(['logged'=>$status]);
      return true;
       
    }
  
    public function getSecurityPinStatus(){

       return  UserAdmin::where('id',auth('admin')->user()->id)->first()->logged;
    }

    public function dashboard(){


      return view('admin.dashboard.index');
    }
}
