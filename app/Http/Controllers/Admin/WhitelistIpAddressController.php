<?php

namespace App\Http\Controllers\Admin;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\WhiteListIpAddress;
use Illuminate\Support\Facades\Validator;

class WhitelistIpAddressController extends Controller
{
    public function index(){
        return view('admin.amaster.whitelistIpAddress.index');
    }

    public function all(){
        $ips = WhiteListIpAddress::latest()->get();
        return view('admin.amaster.whitelistIpAddress.all',compact('ips'));
    }

    public function save(Request $request)
    {   
        // dd(auth('admin')->user());
        // dd($request->ip());
        $validator = Validator::make($request->all(),[
            'ip_address' => 'required|unique:whitelist_ip_addresses,ip_address',
        ]);
            
        if($validator->passes()){
            $record = WhiteListIpAddress::create(['ip_address' => $request->ip_address,'created_by'=> auth('admin')->user()->id]);
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    } 

    public function delete($ipAddressId){
        $record = WhitelistIpAddress::where('id',$ipAddressId)->delete();
    }
}