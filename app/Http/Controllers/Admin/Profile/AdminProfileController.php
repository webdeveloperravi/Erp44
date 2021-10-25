<?php

namespace App\Http\Controllers\Admin\Profile;

use Illuminate\Http\Request; 
use App\Model\Guard\UserAdmin;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator; 

 

class AdminProfileController extends Controller
{
   
    
    public function index()
    { 
      $accountId = auth('admin')->user()->id;
      $authUser = UserAdmin::find(auth('admin')->user()->id);
      return view('admin.Profile.index',compact('accountId','authUser'));
    }

    public function editBasicInformation(){
      
      $accountId = auth('admin')->user()->id;
      $authUser = UserAdmin::find(auth('admin')->user()->id);
      return view('admin.Profile.editBasicInformation',compact('accountId','authUser'));

    }
    
    public function updateBasicInformation(Request $request)
    { 
        $validator = Validator::make($request->all(),[
          'name' => 'required', 
        ]);
        if($validator->passes()){
          UserAdmin::whereId($request->authUserId)->update(['name' => $request->name]);
        }else{
          $keys = $validator->errors()->keys();
          $vals  = $validator->errors()->all();
          $errors = array_combine($keys,$vals);
        }  

    } 

     
     
}
