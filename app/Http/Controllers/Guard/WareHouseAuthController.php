<?php

namespace App\Http\Controllers\Guard;
use Auth;
use Session;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Mail\Login\LoginOtpMail;
use App\Mail\TitleParagraphMail;
use App\Model\Guard\UserWarehouse;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Admin\Setting\DepartmentUserRole as AdminRole;

class WareHouseAuthController extends Controller
{

  public function index()
  { 
    if(Auth::guard('warehouse')->check()){
      return redirect()->route('warehouse.dashboard');
  } 
    return view('warehouse.auth.login.index');
  }

  public function loginForm()
  {
    return view('warehouse.auth.login.login');
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
    $user = UserWarehouse::where('email',$request->email)->orWhere('phone',$request->email)->first() ?? false;
    if($user){ 
        if($user->status)
          {
            $store = $user;
            $mobile =$user->getPhoneWithCode($user->id);
                if(request()->ip() == "::1"){
                
                  return view('warehouse.auth.login.otp',compact('store','mobile'));
                } 
                else
                {
                  $user->phone ? $this->sendSmsOtpCode($user) : true;
                  return view('warehouse.auth.login.otp',compact('store','mobile'));
                }       
          } 
          else{
            return response()->json(['success'=>false,'msg'=>'User Disabled Or Not Verified']);
          }

    }else{
      if(str_contains($request->email,'@')){
          return response()->json(['success'=>false,'msg'=>'Please Enter Valid Email']);

      }elseif(is_numeric($request->email))
      {
        return response()->json(['success'=>false,'msg'=>'Please Enter Valid Phone']);

      }else
      {
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
  
  public function sendSmsOtpCode($user)
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
    }
          catch(\Exception $e){
         return $e;
    }
  }

  public function sendWhatsAppOtp($otp_code,$warehouse){ 
    //  return  Http::get('http://whatsapp2.webtecz.com/api/send.php',[
    //       'token' => 12819,
    //      'no' => $warehouse->getWhatsAppWithCode($warehouse->id),
    //      'text' => '9Gem Store Login OTP'." ".$otp_code
    //    ]);
        return true;
  } 
  
  public function send_otp($otp,$email)
  {
      Mail::to($email)->send(new LoginOtpMail('Warehouse Login OTP',$otp));
      return true;
  }

  public function sendSmsOtp($otp_code,$admin)
  { 
    
    try{
      Http::withHeaders([
        'Authorization' => 'qSrGgsZCQYOIf9WTP6He_w==',
        'Content-Type' => 'application/json'
    ])->post('https://platform.clickatell.com/v1/message', [
        "messages"=> [ 
            [
                "channel"=> "sms",
                "to"=> $admin->getPhoneWithCode($admin->id),
                "content"=>"ERP44 Warehouse Login OTP ". $otp_code,
            ]
        ]
    ]);
    }catch(Exception $exception){
        return true;
    }
      
    
  } 

  public function verifyOTP(Request $request)
  {

   $validator = Validator::make($request->all(),[
      'otp_code' => 'required',
   ],
    ['otp_code.required' => 'Invalid OTP']);
    if($validator->passes()){


    if(request()->ip() == "::1"){
    Auth::guard('warehouse')->loginUsingId($request->id);
    // Session::put('reauthenticate.last_authentication',time()); 
    // Session::put('reauthenticate.timeout',600); 

    Session::put('reauthenticate.last_authentication',time()); 
      Session::put('reauthenticate.timeout',600);  
      $this->triggerLogin();

    return response()->json(['success'=>true]); 
    } 
    else{
    $user = UserWarehouse::find($request->id);
    $response= $this->verifySmsOTPAPI($user,$request);

    if($response->type =="success"){
    if(Auth::guard('warehouse')->loginUsingId($user->id)){   
    // $this->setSecurityPinStatus(1); 
      Session::put('reauthenticate.last_authentication',time()); 
      Session::put('reauthenticate.timeout',600);  
      $this->triggerLogin();
    return response()->json(['success'=>true]); 
    }
    }
    else
    {
    return response()->json(['success'=>false,'msg'=>'Invalid OTP']);
    }

    }
    }
    else{
    $keys = $validator->errors()->keys();
    $vals  = $validator->errors()->all();
    $errors = array_combine($keys,$vals);
    return response()->json(['errors'=>$errors]);
    }
}






public function verifySmsOtpAPI($user,$request){
  $mobile =$user->getPhoneWithCode($user->id);
  $sms=Http::get( "https://api.msg91.com/api/v5/otp/verify?authkey=366219AVJcx9z5cdET61247ee8P1&mobile=".$mobile."&otp=".$request->otp_code);
  $msg= json_decode($sms);
  return $msg;
}





public function resendOtp(Request $request){
  
  $user =UserWarehouse::find($request->id);
  // $mobile=$user->getPhoneWithCode($user->id);
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

 
public function voiceOtp(Request $request){

    $user =UserWarehouse::find($request->id);

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
    Auth::guard('warehouse')->logout(); 
    Session::flush();
    return redirect()->route('warehouse');
  }

  public function triggerLogin()
  {
      $authUser = auth('warehouse')->user();
      $myModules = $authUser->role->modules->pluck('id')->toArray();  
      $modules = Module::with('sub_module')->whereIn('id',$myModules)->get();
      Session::put('myModulesWarehouse',$myModules); 
      Session::put('modulesWarehouse',$modules); 
  }
 


   public function dashboard()
   { 
       return view('warehouse.dashboard');
   } 
  
  

}

