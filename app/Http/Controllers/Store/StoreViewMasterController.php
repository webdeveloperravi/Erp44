<?php

namespace App\Http\Controllers\Store;
 
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Store\StoreViewMaster; 
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class StoreViewMasterController extends Controller
{
    public function index()
    {
        return view('store.StoreViewMaster.index');
    }

    public function create()
    {    
        $countryCodes = CountryCode::all();
         
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        } 
        $countryCode = CountryCode::where('nicename',$currentCountryName)->first();
        return view('store.StoreViewMaster.create',compact('countryCodes','countryCode'));
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'domain' => 'required',  
        ]);
        if($validator->passes()){
           $master= StoreViewMaster::create([
                'domain' => $request->domain,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_country_code_id' => $request->phone_country_code_id,
                "store_id" => StoreHelper::getStoreId(), 
                "address" => $request->address, 
            ]);  
            return response()->json(['success'=>true]);
        }
        else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
    
            return response()->json(['errors'=>$errors]);
        }
    }
    
    public function all()
    {
       $masters = StoreViewMaster::latest()->get();
        return view('store.StoreViewMaster.all',compact('masters'));
    }

    
    public function edit($id)
    {    
        $countryCodes = CountryCode::all();
        $master = StoreViewMaster::find($id);
        return view('store.StoreViewMaster.edit',compact('master','countryCodes'));
    }

    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'domain' => 'required|unique:store_view_masters,domain,'.$request->masterId,
            ]);
        $master = StoreViewMaster::where(['id'=>$request->masterId])->first();
            
        if($validator->passes()){
            $master->update([
                'domain' => $request->domain,
                'email' => $request->email,
                'phone' => $request->phone, 
                "address" => $request->address,   
            ]); 
            
           return response()->json(['success' => true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
        }
    } 

    public function updateUserStatus($userId)
    {
        // $user = StoreViewMaster::where('id',$userId)->first();
         
        // if($user->status == '1'){
        //     $user->update(['status'=>0]);
        // }else{
        //     $user->update(['status'=>1]);

        // }
    }
}
