<?php

namespace App\Http\Controllers\Store\Profile;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\CountryState;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
use App\Model\Admin\Organization\StoreAddress;

 

class StoreProfileController extends Controller
{
   
    
    public function index()
    { 
      $accountId = auth('store')->user()->id;
      $authUser = UserStore::find(auth('store')->user()->id);
      return view('store.Profile.index',compact('accountId','authUser'));
    }

    public function editBasicInformation(){
      
      $accountId = auth('store')->user()->id;
      $authUser = UserStore::find(auth('store')->user()->id);
      return view('store.Profile.editBasicInformation',compact('accountId','authUser'));

    }
    
    public function updateBasicInformation(Request $request)
    {
      if($request->authUserType == 'lab' || $request->authUserType == 'org'){
        $validator = Validator::make($request->all(),[
          'name' => 'required',
          'company_name' => 'required'
        ]);
        if($validator->passes()){
          UserStore::whereId($request->authUserId)->update(['name' => $request->name,'company_name'=> $request->company_name]);
        }else{
          $keys = $validator->errors()->keys();
          $vals  = $validator->errors()->all();
          $errors = array_combine($keys,$vals);
        }
      }

      if($request->authUserType == 'user'){
        $validator = Validator::make($request->all(),[
          'name' => 'required', 
        ]);
        if($validator->passes()){
          UserStore::whereId($request->authUserId)->update(['name' => $request->name]);
        }else{
          $keys = $validator->errors()->keys();
          $vals  = $validator->errors()->all();
          $errors = array_combine($keys,$vals);
        }
      }

    } 

     
     
}
