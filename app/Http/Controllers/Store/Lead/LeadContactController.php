<?php

namespace App\Http\Controllers\Store\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Model\Store\Lead;
use App\Model\Store\LeadContact;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Validator;

class LeadContactController extends Controller
{
    
    public function index($leadId)
    {
      return view('store.leadContacts.index',compact('leadId'));
    }

    public function all($leadId)
    {
      $lead = Lead::find($leadId);
      return view('store.leadContacts.all',compact('lead'));
    }

    public function create($leadId){
      $countryCodes = CountryCode::all();
        if(request()->ip() == "::1"){
            $currentCountryName = 'India';
        }else{
            $currentCountryName = location::get(request()->ip())->countryName;
        }
        $countryCode = CountryCode::where('nicename',$currentCountryName)->first();
       
        return view('store.leadContacts.create',compact('countryCodes','countryCode','leadId'));
    }


  public function save(Request $request)
  {
      $validator = Validator::make($request->all(),[
        'name' => 'required',
        'phone' => 'required|unique:user_store,phone|unique:leads,phone|unique:lead_contacts,phone|digits:10',
        'email' => 'nullable|unique:user_store,email|unique:leads,email|unique:lead_contacts,email',
        'whats_app' => 'required|unique:user_store,whats_app|unique:leads,whats_app|unique:lead_contacts,whats_app|digits:10', 
      ]);
  
        if($validator->passes()){
        $lead = Lead::find($request->leadId);
         $lead->leadContacts()->create([
          'name' => $request->name,
          'email' => $request->email ?? '',
          'phone' => $request->phone ?? '',
          'whats_app' => $request->whats_app ?? '',
          'phone_country_code_id' => $request->phone_country_code_id,
          'whats_app_country_code_id' => $request->whats_app_country_code_id ?? '',
                 ] ); 
       return response()->json(['success'=>true,'message' => "Lead Contact Saved Successfully"]); 
             
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }

    }

    public function edit($id){
    
     $contact =  LeadContact::find($id);  
     $countryCodes = CountryCode::all();
    return view('store.leadContacts.edit',compact('contact','countryCodes'));



    }

    public function update(Request $request){
         
      $validator = Validator::make($request->all(),[
        'name' => 'required',
        'phone' => 'required|unique:user_store,phone|unique:leads,phone|unique:lead_contacts,phone,'.$request->contactId,
        'email' => 'nullable|unique:user_store,email|unique:leads,email|unique:lead_contacts,email,'.$request->contactId,
        'whats_app' => 'required|unique:user_store,whats_app|unique:leads,whats_app|unique:lead_contacts,whats_app,'.$request->contactId, 
      ]);

    if($validator->passes()){
      $contact = LeadContact::find($request->contactId)->update([
        'name'=>$request->name,
        'email' => $request->email ?? '',
        'phone' => $request->phone ?? '',
        'whats_app' => $request->whats_app ?? '',
        'phone_country_code_id' => $request->phone_country_code_id,
        'whats_app_country_code_id' => $request->whats_app_country_code_id ?? ''
      ]);
   return response()->json(['success'=>true,'message' => "Lead Contact Saved Successfully"]); 
         
    }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
        return response()->json(['errors'=>$errors]);
    }
  return response()->json(['success'=>true,'message' => "Lead Contact Updated Successfully"]); 

    }

    public function delete($id){

    }

  









}
