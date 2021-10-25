<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Mail\StoreWelcomeKitMail;
use App\Model\Admin\Master\Country;
use Illuminate\Support\Facades\Mail;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Validator;

class ManagerViewController extends Controller
{
    
     public function index($id){
   
        $managerAccount = UserStore::find($id);

        return view('store.account.manager.managerView.index',compact('managerAccount'));

     }

        public function view($id){
   
        $managerAccount = UserStore::find($id);

        return view('store.account.manager.managerView.view',compact('managerAccount'));

     }

     public function edit($id){
  
      $managerAccount = UserStore::where(['id'=>$id])->first();
        $countryCodes = CountryCode::all();
        $managerRoles = ManagerRole::where(['store_id' => auth('store')->user()->id, 'status' => 1])->get();
        return view('store.account.manager.managerView.edit',compact('managerAccount','countryCodes','managerRoles'));


     }

     public function update(Request $request){

      
        $validator = Validator::make($request->all(),[
        'name' => 'required', 
        'role_id' => 'required|not_in:0', 
        'phone' => 'required|unique:user_store,phone,'.$request->accountId,
        'email' => 'required|email|unique:user_store,email,'.$request->accountId
        ]);
            
        if($validator->passes()){
            $store = UserStore::where(['id'=>$request->accountId])->first();
            $store->update([
                'name'=>$request->name,
                'company_name'=>$request->company,
                'manager_role_id'=>$request->role_id,
                'email'=>$request->email,
                "phone" => $request->phone,
                "whats_app" => $request->whats_app,
                "phone_country_code_id" => $request->phone_country_code_id,
                "whats_app_country_code_id" => $request->whats_app_country_code_id,
            ]);
            return response()->json(['success'=>true,'message' => "Manager Account Updated Successfully"]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }


     }

       public function verificationComponentManager($accountId)
    {
        $managerAccountId  = UserStore::find($accountId);
        return view('store.account.manager.managerView.verificationComponent',compact('managerAccountId'));
    }




}
