<?php

namespace App\Http\Controllers\Store;
 
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\WhiteListIpAddress;
use App\Model\Store\UserStoreIpAddress;
use Illuminate\Support\Facades\Validator;

class WhitelistIpAddressController extends Controller
{
    public function index(){
        return view('store.whitelistIpAddress.index');
    }

    public function all(){
        $ips = WhiteListIpAddress::where('store_id',StoreHelper::getStoreId())->latest()->get();
        return view('store.whitelistIpAddress.all',compact('ips'));
    }

    public function save(Request $request)
    {    
        $validator = Validator::make($request->all(),[
            // 'ip_address' => '|unique:whitelist_ip_addresses,ip_address',
            'ip_address' => [ 
                function($attribute,$value,$fail){
                   if(strlen($value) > 0){
                      if(UserStoreIpAddress::where(['store_id'=>StoreHelper::getStoreId(),'ip_address'=>$vale])){
                         $fail('Already Exists');
                      }
                   }
                },'required'
                ], 
        ]);
            
        if($validator->passes()){
            $record = WhiteListIpAddress::create([
                'ip_address' => $request->ip_address,
                'store_id' => StoreHelper::getStoreId(),
                'created_by'=> auth('store')->user()->id
            ]);
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    } 

    public function view($ipAddressId){

        $ip = WhitelistIpAddress::with('managers')->where('id',$ipAddressId)->first();
        return view('store.whitelistIpAddress.view',compact('ip')); 
    }

    public function delete($ipAddressId){
        $record = WhitelistIpAddress::where('id',$ipAddressId)->first();
        $record->managers()->detach();
        $record->delete();
        return redirect()->route('whitelistIpAddress.index');
    }

    public function detachUsers(Request $request){
 
        $ip = WhitelistIpAddress::find($request->ip_id);
        $ip->managers()->detach($request->managers);
        return redirect()->back();
    }
}