<?php

namespace App\Http\Controllers\Admin\Master;

use Auth;
use Route;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request; 
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\SocialMediaType;
use App\Model\Admin\Organization\AddressType;

class SocialMediaTypeController extends Controller
{
         

      public function index()
      {
        return view('admin.amaster.SocialMediaType.index');
      }
      
      public function create()
      {
        
        return view('admin.amaster.SocialMediaType.create');
      }
        
      public function store(Request $request)
      { 
          $validator = Validator::make($request->all() , [
            'name' => 'required', 
            'alias' => 'required', 
            'description' => 'required', 
          ]);

        if ($validator->passes())
        {
          $socialMediaType =  SocialMediaType::create([
              'name' => $request->name,
              'alias' => $request->alias,
              'description' => $request->description,
            ]);
             $socialMediaType->masterIds()->create([
             'created_id' => Helper::getAdminId()
             ]);

            return response()->json(['success' => true]);

        }else{
            $keys = $validator->errors()->keys();
            $vals = $validator->errors()->all();
            $errors = array_combine($keys, $vals);

            return response()->json(['errors' => $errors]);
        }
      }

      public function all()
      {
          $types = SocialMediaType::all();
          return view('admin.amaster.SocialMediaType.all',compact('types'));
      }
        
        
        
      public function edit($typeId)
      {
        $type = SocialMediaType::find($typeId);
        return view('admin.amaster.SocialMediaType.edit',compact('type'));
      }

      public function update(Request $request)
      { 
        $validator = Validator::make($request->all() , [
          'name' => 'required', 
          'alias' => 'required', 
          'description' => 'required', 
        ]);

      if ($validator->passes())
      {
        $socialMediaType =  SocialMediaType::where('id',$request->typeId)->first();
        $socialMediaType->update([
            'name' => $request->name,
            'alias' => $request->alias,
            'description' => $request->description,
          ]);

          $socialMediaType->masterIds()->create([
            'updated_id' => Helper::getAdminId()
            ]);

          return response()->json(['success' => true]);

      }else{
          $keys = $validator->errors()->keys();
          $vals = $validator->errors()->all();
          $errors = array_combine($keys, $vals);

          return response()->json(['errors' => $errors]);
      }
 
      }

      public function updateStatus($typeId)
      {
        
      }

}
