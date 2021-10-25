<?php
namespace App\Http\Controllers\Store;  

use Illuminate\Http\Request;
use App\Model\Store\SocialMedia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\SocialMediaType;
 
 

class LeadSocialController extends Controller
{
    public function index($leadId)
      {
        return view('store.LeadSocial.index',compact('leadId'));
      }
      
      public function create($leadId)
      {
        $existTypes = SocialMedia::where('lead_id',$leadId)->pluck('social_media_type_id')->toArray();
        $types = SocialMediaType::get()
          ->reject(function($q) use ($existTypes){
                 return in_array($q->id,$existTypes);
          });
        ;
        return view('store.LeadSocial.create',compact('leadId','types'));
      }
        
      public function store(Request $request)
      {  
        // dd($request->all());
          $validator = Validator::make($request->all() , [
            'type' => 'required|not_in:0',  
            'link' => 'required',  
          ]);

        if ($validator->passes())
        {
            SocialMedia::create([
              'lead_id' => $request->lead_id,
              'link' => $request->link,
              'social_media_type_id' => $request->type,
            ]);
            return response()->json(['success' => true]);

        }else{
            $keys = $validator->errors()->keys();
            $vals = $validator->errors()->all();
            $errors = array_combine($keys, $vals);

            return response()->json(['errors' => $errors]);
        }
      }

      public function all($leadId)
      {
          $socials = SocialMedia::where('lead_id',$leadId)->get();
          return view('store.LeadSocial.all',compact('socials'));
      }
        
      public function edit($id)
      {
        $type = SocialMedia::find($id);
        return view('store.LeadSocial.edit',compact('type'));
      }

      public function update(Request $request)
      { 
        $validator = Validator::make($request->all() , [
          'typeId' => 'required', 
          'link' => 'required',  
        ]);

      if ($validator->passes())
      {
        SocialMedia::where('id',$request->typeId)->update([
          'link' => $request->link,
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
