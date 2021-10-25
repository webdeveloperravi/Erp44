<?php

namespace App\Http\Controllers\Store;

use App\Model\Store\Lead;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\AccountImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ImageController extends Controller
{
     

     public function index($managerId){
     $managerId = UserStore::find($managerId);
     return view('store.account.manager.managerView.images.index',compact('managerId'));
     }
   
  public function store(Request $request){
           $validator = Validator::make($request->all(),[
                'image' => 'required',
        ]);


        // $lead = Lead::with('images')->where('id',$request->leadId)->first();

        // $file = $request->file('image');

        // $extension = $file->getClientOriginalExtension();
        
        // $storeId = StoreHelper::getStoreId();
        // $directory = "images/lead-images/".$storeId.'/'.$lead->id.'/';
        // $imageCountNumber = $lead->images->count() > 0 ? $lead->images->count() + 1 : 1;
        // $fileName =  $lead->id.'-'.$imageCountNumber.".".$extension; 
        // // dd(Storage::disk('google')->allFiles());
        // // Storage::disk('google')->put($fileName,$directory);
        // $file->storeAs($directory,$fileName,'images');
        // $imageStatus = $lead->images()->create(['url'=> $directory,'name'=>$fileName,'store_user_id'=>auth('store')->user()->id]);
        // if($imageStatus){
        //     return response()->json(['success',true]);
        // }
 

        if($validator->passes()){
        $managerAccount = UserStore::where('id',$request->leadId)->first();
        if($managerAccount->type == 'user'){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $storeId = $managerAccount->parentStore->id;
            $directory = "images/manager-images/".$storeId.'/'.$managerAccount->id.'/';
            $imageCountNumber = $managerAccount->images->count() > 0 ? $managerAccount->images->count() + 1 : 1;
            $fileName =  $managerAccount->id.'-'.$imageCountNumber.".".$extension; 
            $file->storeAs($directory,$fileName,'images');
            $imageStatus = $managerAccount->images()->create(['url'=> $directory,'name'=>$fileName,'store_user_id'=>auth('store')->user()->id]);
            if($imageStatus){
                return response()->json(['success',true]);
            }
        }
        if($managerAccount->type == 'org'){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $storeId = $managerAccount->id;
            $directory = "images/store-images/".$storeId.'/';
            $imageCountNumber = $managerAccount->images->count() > 0 ? $managerAccount->images->count() + 1 : 1;
            $fileName =  $managerAccount->id.'-'.$imageCountNumber.".".$extension; 
            $file->storeAs($directory,$fileName,'images');
            $imageStatus = $managerAccount->images()->create(['url'=> $directory,'name'=>$fileName,'store_user_id'=>auth('store')->user()->id]);
            if($imageStatus){
                return response()->json(['success',true]);
            }
        }
        $fileName = "Manager".$this->randomString().".".$extension;
        $directory = "images/manager-images/";
        
      }
      else
      {
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);  
      }
    }

       public function randomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function all($managerId){
        
        $managerId = UserStore::with('images')->where('id',$managerId)->first();
        return view('store.account.manager.managerView.images.all',compact('managerId'));
    }







}
