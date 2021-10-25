<?php

namespace App\Http\Controllers\Admin\Master;
 
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserWarehouse;
use App\Http\Controllers\Controller; 
use App\Model\Admin\Master\CountryCode;
use App\Model\Admin\Setting\WarehouseRole;
use Stevebauman\Location\Facades\Location;

class WarehouseUserController extends Controller
{
    
    public function index()
    {
        return view('admin.amaster.warehouseUser.index');
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
        $roles = WarehouseRole::all();
        return view('admin.amaster.warehouseUser.create',compact('countryCodes','countryCode','roles'));
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'role' => 'required|not_in:0',
            'phone' => 'required|unique:user_warehouse,phone',
            'email' => 'required|unique:user_warehouse,email',
            'whats_app' => 'required|unique:user_warehouse,whats_app', 
        ]);
        if($validator->passes()){
            $userWarehouse = UserWarehouse::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                "whats_app" => $request->whats_app, 
                "phone_country_code_id" => $request->phone_country_code_id,
                "whats_app_country_code_id" => $request->whats_app_country_code_id,
                'role_id' => $request->role,
                'created_by' => auth('admin')->user()->id,
                'guard_id' => 2,
                'security_pin' => rand(111111,999999)
            ]); 
            
            $userWarehouse->masterIds()->create([
                'created_id' => Helper::getAdminId()
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
       $users = UserWarehouse::latest()->get();
        return view('admin.amaster.warehouseUser.all',compact('users'));
    }
    
    public function edit($id)
    {   
        $countryCodes = CountryCode::all();
        
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        }  
        $roles = WarehouseRole::all();
        $user = UserWarehouse::find($id);
        return view('admin.amaster.warehouseUser.edit',compact('user','roles','countryCodes'));
    }
    
    public function update(Request $request)
    {
      
        
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'role' => 'required|not_in:0',
            'phone' => 'required|unique:user_warehouse,phone,'.$request->userId,
            'email' => 'required|unique:user_warehouse,email,'.$request->userId,
            'whats_app' => 'required|unique:user_warehouse,whats_app,'.$request->userId,
            ]);
        $user = UserWarehouse::where(['id'=>$request->userId])->first();
            
        if($validator->passes()){
 
           
            $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            "whats_app" => $request->whats_app, 
            "phone_country_code_id" => $request->phone_country_code_id,
            "whats_app_country_code_id" => $request->whats_app_country_code_id,
            'role_id' => $request->role,   
            ]);
           $user->masterIds()->create([
                'updated_id' => Helper::getAdminId()
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
        $user = UserWarehouse::where('id',$userId)->first();
         
        if($user->status == '1'){
            $user->update(['status'=>0]);
        }else{
            $user->update(['status'=>1]);

        }
    }
}
