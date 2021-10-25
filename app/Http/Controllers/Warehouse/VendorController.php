<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Country;
use App\Model\Admin\Master\CountryState as State;
use App\Model\Admin\Master\CountryStateCity as City;
use App\Model\Warehouse\Vendor;
use App\Helpers\Helper;
use Validator;

class VendorController extends Controller
{
    
    public function index()
    {
      return view('warehouse.vendor.index'); 
    }

    public function create(){
      $countries = Country::all();
       return view('warehouse.vendor.create',compact('countries'));
    }

    public function all(){
        $vendors = Vendor::get();
        return view('warehouse.vendor.all',compact('vendors'));

    }


    public function store(Request $request)
    {
        $vendor_validation =  Validator::make($request->all(), [
      'company' => 'required|unique:vendors,company_name',
      'name' => 'required',
      'email' => 'required|email|email',
      'phone' => 'required',
      'country' => 'required|not_in:0',
      'state' => 'required|not_in:0',
      'city' => 'required|not_in:0',
      'address' => 'required',
      'locality' => 'required',
      'landmark' => 'required',
      'pincode' => 'required',
      'gst' => 'required'
    ]);
      if($vendor_validation->passes()){          
           Vendor::create([
              "company_name" => $request->company,
              "name" => $request->name,
              "email" => $request->email,
              "phone" => $request->phone,
              "country_id" => $request->country,
              "state_id" => $request->state,
              "city_id" => $request->city,
              "address" => $request->address,
              "locality" => $request->locality,
              "landmark" => $request->landmark,
              "pincode" => $request->pincode,
              "gst_number" => $request->gst,
           ]);
         return response()->json(['success'=>Helper::message_format('Vendor Added','success')],200);

          }
      else
      {
         $keys = $vendor_validation->errors()->keys();
         $vals = $vendor_validation->errors()->all();
         $errors = array_combine($keys, $vals);
          return response()->json(['errors'=>$errors]);

      }
          
 return redirect()->route('vendor.create');
    }

    public function show($id)
    {
        $vendor = Vendor::find($id);
       return view('warehouse.vendor.single_view', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $vendor_edit_info = Vendor::find($id); 
        // dd($vendor_edit_info->state_id);  
         $country_list = Country::all();
         $state_list = State::where('country_id',$vendor_edit_info->country_id)->get();
         $city_list = City::where('state_id',$vendor_edit_info->state_id)->get();
         return view('warehouse.vendor.edit',compact('vendor_edit_info','country_list','state_list','city_list'));
    }
    public function update(Request $request)
    {
        
         $vendor_validation =  Validator::make($request->all(), [
      'company' => 'required|unique:vendors,company_name,'.$request->vendorId,
      'name' => 'required',
      'email' => 'required|email',
      'country' => 'required|not_in:0',
      'state' => 'required|not_in:0',
      'city' => 'required|not_in:0',
      'address' => 'required',
      'locality' => 'required',
      'landmark' => 'required',
      'pincode' => 'required',
      'gst' => 'required'
    ]);
      if($vendor_validation->passes()){          
           Vendor::where('id',$request->vendorId)->update([
              "company_name" => $request->company,
              "name" => $request->name,
              "email" => $request->email,
              "country_id" => $request->country,
              "state_id" => $request->state,
              "city_id" => $request->city,
              "address" => $request->address,
              "locality" => $request->locality,
              "landmark" => $request->landmark,
              "pincode" => $request->pincode,
              "gst_number" => $request->gst,
           ]);
      return response()->json(['success'=>Helper::message_format('Vendor Updated','success')],200);

          }
      else
      {
         $keys = $vendor_validation->errors()->keys();
         $vals = $vendor_validation->errors()->all();
         $errors = array_combine($keys, $vals);
       
          return response()->json(['errors'=>$errors]);

      }
          

 
 

   }

    
    

  protected function getState($id)
{

$state_list["state"]=State::where('country_id',$id)->pluck('name','id');


return response()->json($state_list);


}

protected function getCity($id)
{
  
$state_list["city"]=City::where('state_id',$id)->pluck('name','id');


return response()->json($state_list);


}

public function status($id)
    {
        $vendor = Vendor::find($id);
         if($vendor->status==1)
               {
                 $status=0;
               }
               else
               {
                 $status=1;
               }

            $vendor->update(['status'=>$status]);   
         
              return response()->json(['success'=>Helper::message_format('Status Changed','success')],200);
    }

}
