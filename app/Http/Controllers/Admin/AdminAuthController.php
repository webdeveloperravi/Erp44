<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\Request; 
use App\Model\Guard\UserAdmin;
use App\Mail\Login\LoginOtpMail;
use App\Mail\TitleParagraphMail;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{

    public function index()
    { 
      if(Auth::guard('admin')->check()){
        return redirect()->route('admin.dashboard');
      } 
      return view('admin.auth.index');
    }

    public function loginForm()
    {
      return view('admin.auth.login');
    }

    public function verifyAccount(Request $request)
    {  
     $validator = Validator::make($request->all(),[
            'email' => 'required',
     ],
     ['email.required'=> 'Please Enter Email or Phone']
    );

     if($validator->passes())
     {
      $user = UserAdmin::where('email',$request->email)->orWhere('phone',$request->email)->first() ?? false;
      if($user){
        if($user->status)
        {
        
        $mobile = $user->getPhoneWithCode($user->id);   
        if(request()->ip() == "::1"){ 
           return view('admin.auth.otp',compact('user','mobile'));
        }else{         
           $user->phone ? $this->sendSmsOtp($user) : true; 
           return view('admin.auth.otp',compact('user','mobile'));
        }

      }else{
            return response()->json(['success'=>false,'msg'=>'User Disabled Or Not Verified']);
      }
      }
        else{
         if(str_contains($request->email,'@')){
            return response()->json(['success'=>false,'msg'=>'Please Enter Valid Email']);
         }elseif(is_numeric($request->email)){
            return response()->json(['success'=>false,'msg'=>'Please Enter Valid Phone']);
         }else{
            return response()->json(['success'=>false,'msg'=>'Please Enter Valid Email or Phone']);
        }
      }
     }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
      }
    }
    
    public function sendSmsOtp($user)
    {
      try{
          $mobile =$user->getPhoneWithCode($user->id);
          $sms=Http::get( "https://api.msg91.com/api/v5/otp?template_id=614426e566c0a424c3743085&mobile=".$mobile."&authkey=366219AVJcx9z5cdET61247ee8P1");  
          if($sms->ok())
          {
                return true;
          }
          else{
              return false;
          }
      }catch(\Exception $e){
           return $e;
      }
    }

    public function verifyOTP(Request $request)
    {
    
      $validator = Validator::make($request->all(),[
              'otp_code' => 'required',
      ],
      ['otp_code.required' => 'Invalid OTP']);
      if($validator->passes()){
          
          $admin = UserAdmin::find($request->id);
          if(request()->ip() == "::1"){
                Auth::guard('admin')->loginUsingId($admin->id);
                 $this->triggerLogin();
                return response()->json(['success'=>true]); 
          }   
          $response= $this->verifySmsOtp($admin,$request);
          
          if($response->type =="success"){
              if(Auth::guard('admin')->loginUsingId($admin->id)){  
                $this->triggerLogin();
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

    public function verifySmsOtp($user,$request)
    {
        $mobile =$user->getPhoneWithCode($user->id);
        $sms=Http::get( "https://api.msg91.com/api/v5/otp/verify?authkey=366219AVJcx9z5cdET61247ee8P1&mobile=".$mobile."&otp=".$request->otp_code);
        $msg= json_decode($sms);
        return $msg;
    }

   

    public function resendOtp(Request $request)
    {
        $user =UserAdmin::find($request->id);
        $mobile=$user->getPhoneWithCode($user->id);
        $sms=Http::get( "https://api.msg91.com/api/v5/otp/retry?authkey=366219AVJcx9z5cdET61247ee8P1&retrytype=text&mobile=".$mobile);
        $msg= json_decode($sms);
        if($msg->type=="success")
        {
          return response()->json(['success'=>true]); 
        }
        else
        {
          return response()->json(['success'=>false,'msg'=>'Not Resend otp']);
        }
    }

         
    public function voiceOtp(Request $request)
    {
      $user =UserAdmin::find($request->id);
      $mobile=$user->getPhoneWithCode($user->id);
      $sms=Http::get( "https://api.msg91.com/api/v5/otp/retry?authkey=366219AVJcx9z5cdET61247ee8P1&retrytype=voice&mobile=".$mobile);
      $msg= json_decode($sms);
      if($msg->type=="success")
      {
        return response()->json(['success'=>true]); 
      }
      else
      {
        return response()->json(['success'=>false,'msg'=>'Not Resend otp']);
      }
    }

    public function logout(Request $request)
    {
      Auth::guard('admin')->logout(); 
      return redirect()->route('admin');
    }

    public function triggerLogin()
    {
          $authUser = auth('admin')->user();
          if($authUser->id == 101){
            $myModules = Module::pluck('id')->toArray();  
            $modules = Module::with('sub_module')->whereIn('id',$myModules)->get();
          }else{
            $myModules = auth('admin')->user()->role->modules->pluck('id')->toArray(); 
            $modules = Module::with('sub_module')->whereIn('id',$myModules)->get();
          }
          Session::put('myModulesAdmin',$myModules); 
          Session::put('modulesAdmin',$modules);
    }
 
    public function profile()
    {
       $adminID=auth('admin')->user()->id;
       $user = UserAdmin::where(['id'=>$adminID])->first();
       return view('admin.admin.profile',compact('user'));
    } 

    public function dashboard()
    {
      return view('admin.dashboard.index');
    } 
     
}
