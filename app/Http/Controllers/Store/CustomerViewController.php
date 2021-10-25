<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Mail\StoreWelcomeKitMail;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Model\Admin\Master\CountryCode;
use App\Model\Admin\Master\AccountGroup;
use Illuminate\Support\Facades\Validator;

class CustomerViewController extends Controller
{
   
     public function index($id){
   
        $customerAccount = UserStore::find($id);

        return view('store.account.customer.customerView.index',compact('customerAccount'));

     }

        public function view($id){
   
        $customerAccount = UserStore::find($id);

        return view('store.account.customer.customerView.view',compact('customerAccount'));

     }

     public function edit($id){
        $store = UserStore::where(['id'=>$id])->first();
        $managerAccount = UserStore::where(['id'=>$id])->first();
        $countryCodes = CountryCode::all();
        $accountGroups = AccountGroup::all();
        $managerRoles = ManagerRole::where(['store_id' => auth('store')->user()->id, 'status' => 1])->get();
        return view('store.account.customer.customerView.edit',compact('managerAccount','countryCodes','managerRoles','store','accountGroups'));


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

   public function verificationComponentCustomer($accountId)
    {
        $customerAccountId  = UserStore::find($accountId);
        return view('store.account.customer.customerView.verificationComponent',compact('customerAccountId'));
    }


}
