<?php

namespace App\Http\Controllers\Warehouse\Profile;

use Illuminate\Http\Request; 
use App\Model\Guard\UserWarehouse;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Validator; 

 

class WarehouseProfileController extends Controller
{
    public function index()
    { 
      $accountId = auth('warehouse')->user()->id;
      $authUser = UserWarehouse::find(auth('warehouse')->user()->id);
      return view('warehouse.Profile.index',compact('accountId','authUser'));
    }

    public function editBasicInformation(){
      
      $accountId = auth('warehouse')->user()->id;
      $authUser = UserWarehouse::find(auth('warehouse')->user()->id);
      return view('warehouse.Profile.editBasicInformation',compact('accountId','authUser'));

    }
    
    public function updateBasicInformation(Request $request)
    { 
        $validator = Validator::make($request->all(),[
          'name' => 'required', 
        ]);
        if($validator->passes()){
          UserWarehouse::whereId($request->authUserId)->update(['name' => $request->name]);
        }else{
          $keys = $validator->errors()->keys();
          $vals  = $validator->errors()->all();
          $errors = array_combine($keys,$vals);
        }  

    } 

     
     
}
