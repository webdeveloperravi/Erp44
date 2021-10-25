<?php

namespace App\Http\Controllers\Guard;

use Auth;
use Hash;
use Session;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Mail\Login\LoginOtpMail;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StoreAuthController extends Controller
{
  public $template_id = '61533ad59c680200cb4fff63';

  public function index()
  {
    if (Auth::guard('store')->check()) {
      return redirect()->route('store.dashboard');
    }
    return view('store.auth.index');
  }

  public function loginForm()
  {
    return view('store.auth.login');
  }

  public function verifyAccount(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'email' => 'required',
      ],
      ['email.required' => 'Please Enter Valid Email or Phone']
    );

    if ($validator->passes()) {
      $user = UserStore::where('email', $request->email)->orWhere('phone', $request->email)->first() ?? false;

      if ($user) {
        if ($user->status) {
          $store = $user;
          if ($user->ip_blocking) {
            $whiteListIps = $user->managerIps->pluck('ip_address')->toArray();
            if (!in_array($request->ip(), $whiteListIps)) {
              return response()->json(['success' => false, 'msg' => 'Security Issue ! <br> You are not Authorized to Login']);
            }
          }
          $mobile = $user->getPhoneWithCode($user->id);
          if (request()->ip() == "::1") {
            return view('store.auth.otp', compact('store', 'mobile'));
          }
          $user->phone ? $this->sendSmsOtpCode($user) : true;
          return view('store.auth.otp', compact('store', 'mobile'));
        } else {
          return response()->json(['success' => false, 'msg' => 'User Disabled Or Not Verified']);
        }
      } else {
        if (str_contains($request->email, '@')) {
          return response()->json(['success' => false, 'msg' => 'Please Enter Valid Email']);
        } elseif (is_numeric($request->email)) {
          return response()->json(['success' => false, 'msg' => 'Please Enter Valid Phone']);
        } else {
          return response()->json(['success' => false, 'msg' => 'Please Enter Valid Email or Phone']);
        }
      }
    } else {
      $keys = $validator->errors()->keys();
      $vals  = $validator->errors()->all();
      $errors = array_combine($keys, $vals);
      return response()->json(['errors' => $errors]);
    }
  }

  public function sendSmsOtpCode($user)
  {
    try {
      $mobile = $user->getPhoneWithCode($user->id);
      $sms = Http::get("https://api.msg91.com/api/v5/otp?template_id=" . $this->template_id . "&mobile=" . $mobile . "&authkey=366219AVJcx9z5cdET61247ee8P1");
      if ($sms->ok()) {
        return true;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      return $e;
    }
  }

  public function verifyOTP(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'otp_code' => 'required',
      ],
      ['otp_code.required' => 'Invalid OTP']
    );

    if ($validator->passes()) {

      if (request()->ip() == "::1" || request()->ip() == "127.0.0.1") {
        Auth::guard('store')->loginUsingId($request->id);
        Session::put('reauthenticate.last_authentication', time());
        Session::put('reauthenticate.timeout', 200);

        $this->triggerLogin();

        return response()->json(['success' => true]);
      }

      $user = UserStore::find($request->id);

      $response = $this->verifySmsOTPAPI($user, $request);

      if ($response->type == "success") {
        if (Auth::guard('store')->loginUsingId($user->id)) {

          Session::put('reauthenticate.last_authentication', time());
          Session::put('reauthenticate.timeout', 200);

          $this->triggerLogin();

          return response()->json(['success' => true]);
        }
      } else {
        return response()->json(['success' => false, 'msg' => 'Invalid OTP']);
      }
    } else {
      $keys = $validator->errors()->keys();
      $vals  = $validator->errors()->all();
      $errors = array_combine($keys, $vals);
      return response()->json(['errors' => $errors]);
    }
  }

  public function verifySmsOtpAPI($user, $request)
  {
    $mobile = $user->getPhoneWithCode($user->id);
    $sms =  Http::get("https://api.msg91.com/api/v5/otp/verify?authkey=366219AVJcx9z5cdET61247ee8P1&mobile=" . $mobile . "&otp=" . $request->otp_code);
    $msg = json_decode($sms);
    return $msg;
  }

  public function resendOtp(Request $request)
  {
    $user = UserStore::find($request->id);
    $mobile = $user->getPhoneWithCode($user->id);
    $sms = Http::get("https://api.msg91.com/api/v5/otp/retry?authkey=366219AVJcx9z5cdET61247ee8P1&retrytype=text&mobile=" . $mobile);
    $msg = json_decode($sms);
    if ($msg->type == "success") {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false, 'msg' => 'Not Resend otp']);
    }
  }


  public function voiceOtp(Request $request)
  {
    $user = UserStore::find($request->id);
    $mobile = $user->getPhoneWithCode($user->id);
    $sms = Http::get("https://api.msg91.com/api/v5/otp/retry?authkey=366219AVJcx9z5cdET61247ee8P1&retrytype=voice&mobile=" . $mobile);
    $msg = json_decode($sms);
    if ($msg->type == "success") {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false, 'msg' => 'Not Resend otp']);
    }
  }

  public function logout(Request $request)
  {
    Auth::guard('store')->logout();
    Session::flush();
    return redirect()->route('store');
  }

  public function triggerLogin()
  {
    $authUser = auth('store')->user();
    // if($authUser->type == 'lab'){
    //   $myModules = Module::where('guard_id',5)->pluck('id')->toArray();
    //   $modules = Module::with('sub_module')->whereIn('id',$myModules)->get();
    // }else{
    if ($authUser->type == 'user') {
      $myModules = $authUser->managerRole->modules->pluck('id')->toArray();
    } elseif (in_array($authUser->type, ['org', 'lab'])) {
      $myModules = $authUser->role->modules->pluck('id')->toArray();
    }
    $modules = Module::with('sub_module')->whereIn('id', $myModules)->get();
    // }
    Session::put('myModulesStore', $myModules);
    Session::put('modulesStore', $modules);
  }

  public function dashboard()
  {
    return view('store.store.dashboard.home');
  }

  public function routeFallback()
  {
    $abort = 'Route does not exist';
    return view('store.store.fallback', compact('abort'));
  }

  public function sendWhatsAppOtp($otp_code, $store)
  {
    // try{
    //   return  Http::get('http://whatsapp2.webtecz.com/api/send.php',[
    //     'token' => 12819,
    //    'no' => $store->getWhatsAppWithCode($store->id),
    //    'text' => '9Gem Store Login OTP'." ".$otp_code
    //  ]);
    // }catch(\Exception $e){
    //   return true;

    // }
    // return true;

  }


  public function send_otp($otp, $email)
  {
    // Mail::to($email)->send(new LoginOtpMail("Store Login OTP",$otp));
    // return true;
  }
}
