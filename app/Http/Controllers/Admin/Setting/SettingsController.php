<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Model\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index(){
        
        $settings = Setting::all();
        return view('admin.setting.settings.index',compact('settings'));
    }

    public function update(Request $request){
         
        Setting::where('slug','enable-sms-otp-for-login')->update(['status'=> $request->has('enable-sms-otp-for-login') ? 1 : 0]);
        Setting::where('slug','enable-email-otp-for-login')->update(['status'=> $request->has('enable-email-otp-for-login') ? 1 : 0]);
        Setting::where('slug','enable-whatsapp-otp-for-login')->update(['status'=> $request->has('enable-whatsapp-otp-for-login') ? 1 : 0]);
    }
}
