<?php 

namespace App\Http\Controllers\Store\Lead;
 

use Stevebauman\Location\Facades\Location;
use App\Model\Image;
use App\Model\Comment;
use App\Helpers\Helper;
use App\Model\Store\Lead;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Store\LeadType;
use App\Model\Guard\UserStore;
use App\Model\Store\LeadSource;
use App\Model\Store\LeadStatus; 
use App\Model\Admin\Master\Country; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Gate; 
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Storage;
use App\Model\Admin\Master\CountryState;
use Illuminate\Support\Facades\Validator;  
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType; 

class LeadController extends Controller
{
    public function index()
    {  
        return view('store.lead.index');
    }

    public function all()
    {   
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == "lab" || $authUser->type == "org"){

            $leads = Lead::where('store_id',$authUser->id)->latest()->get();

        }elseif($authUser->type == "user"){
            
            $managerIds = Helper::getSubRoleManagerIds();
            
            $leads = Lead::whereIn('store_user_id',$managerIds)->latest()->get();
        }
        return view('store.lead.all',compact('leads'));
    } 

    public function create()
    {   
        
        if( Gate::allows('store-create','lead.index')){

            $countries = Country::all();
            $leadSources = LeadSource::all();
            $leadStatuses = LeadStatus::all();
            $leadTypes = LeadType::all();
            $addressTypes = AddressType::all();
            $countryCodes = CountryCode::all();
           
            if(request()->ip() == "::1"){
                $currentCountryName = 'India';
            }else{
                $currentCountryName = location::get(request()->ip())->countryName;
            } 
            $countryCode = CountryCode::where('nicename',$currentCountryName)->first();
    
            return view('store.lead.create',compact('countries','leadSources','leadStatuses','addressTypes','countryCodes','countryCode','leadTypes'));
        }
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            // 'company' => 'required',
            'phone' => 'required|unique:user_store,phone|unique:leads,phone|unique:lead_contacts,phone',
            // 'email' => 'required|email|unique:user_store,email|unique:leads,email|unique:lead_contacts,email',
            'whats_app' => 'required|unique:user_store,whats_app|unique:leads,whats_app|unique:lead_contacts,whats_app', 
            
        ]);
            
        if($validator->passes()){
   
            $lead = Lead::create([
                'name' => $request->name,
                'company' => $request->company,
                "phone" => $request->phone,
                "phone_country_code_id" => $request->phone_country_code_id,
                "whats_app_country_code_id" => $request->whats_app_country_code_id,
                "whats_app" => $request->whats_app,
                'email' => $request->email,
                'lead_type_id' => $request->lead_type_id,
                'lead_status_id' => $request->lead_status_id,
                'store_user_id' => auth('store')->user()->id,
                'created_by' => auth('store')->user()->id,
                'store_id' => StoreHelper::getStoreId(),
                'lead_source_id' => $request->lead_source_id,
                'address_type_id' => $request->address_type_id,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'town_id' => $request->town_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'locality' => $request->locality,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
            ]);
            return response()->json(['success'=>true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
    }

    
    public function edit($leadId){
        $lead = Lead::find($leadId);
        $leadStatuses = LeadStatus::all();
        $leadTypes = LeadType::all();
        $countries = Country::all();
        $leadSources = LeadSource::all(); 
        $addressTypes = AddressType::all();
        $states = CountryState::where('country_id',$lead->country_id)->get();
        $cities = CountryStateCity::where('state_id',$lead->state_id)->get();
        $countryCodes = CountryCode::all();
        return view('store.lead.edit',compact('lead','leadStatuses','countries','leadSources','addressTypes','states','cities','countryCodes','leadTypes'));
    }

    public function update(Request $request)
    {
         
         
        $lead = Lead::find($request->leadId);
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                // 'company' => 'required', 
                'phone' => 'required|unique:lead_contacts,phone|unique:user_store,phone|unique:leads,phone,'.$request->leadId,
            // 'email' => 'required|unique:lead_contacts,email|unique:user_store,email|unique:leads,email,'.$request->leadId,
            'whats_app' => 'required|unique:lead_contacts,whats_app|unique:user_store,whats_app|unique:leads,whats_app,'.$request->leadId, 

               
        ]);

        if($validator->passes()){

   
            $lead->update([
            'name' =>$request->name,
            'email' =>$request->email,
            'company' =>$request->company,
            "phone" => $request->phone,
            "phone_country_code_id" => $request->phone_country_code_id,
            "whats_app_country_code_id" => $request->whats_app_country_code_id,
            "whats_app" => $request->whats_app,
            'lead_type_id' => $request->lead_type_id, 
            'lead_status_id' => $request->lead_status_id, 
            'store_user_id' => auth('store')->user()->id,
            'lead_status_id' => $request->lead_status_id,
            'lead_source_id' => $request->lead_source_id,
            'address_type_id' => $request->address_type_id,
            'country_id' => $request->country_id ?? null,
            'state_id' => $request->state_id ?? null,
            'town_id' => $request->town_id ?? null,
            'city_id' => $request->city_id ?? null,
            'address' => $request->address,
            'locality' => $request->locality,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            ]);
           return response()->json(['success' => true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
        
        return response()->json(['errors'=>$errors]);
        }

    }

    public function view($id){
       
        $lead = Lead::find($id);
         
       if(auth('store')->user()->type =='lab' && auth('store')->user()->id == $lead->store_id){
            return view('store.lead.view',compact('lead'));
       }

        if(auth('store')->user()->type =='org' && auth('store')->user()->id == $lead->store_id){
            return view('store.lead.view',compact('lead'));
        }
        if(auth('store')->user()->type == 'user'){
            
            $managerIds = Helper::getSubRoleManagerIds();
            $leads = Lead::whereIn('store_user_id',$managerIds)->where('id',$id)->first();
             
                return view('store.lead.view',compact('lead'));
           
        } 
    }

    public function getState($countryId){
       
       $states = CountryState::where('country_id',$countryId)->get();
       return view('store.lead.state',compact('states'));
    }

    public function getTown($stateId){
       
       $cities = CountryStateCity::where('state_id',$stateId)->get();
       return view('store.lead.town',compact('cities'));
    }

    public function getCity($stateId){
       
       $cities = CountryStateCity::where('state_id',$stateId)->get();
       return view('store.lead.city',compact('cities'));
    }

    public function storeComment(Request $request){
        
       
            $validator = Validator::make($request->all(),[
                'body' => 'required',
        ]);

        if($validator->passes()){

        $lead  = Lead::find($request->lead_id);
        $lead->comments()->create(['body'=> $request->body,'store_user_id'=> auth('store')->user()->id]);
        return response()->json(['success',true]);
      }
      else
      {
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);  
      }
    }

    public function getComments($id){
        
        $lead = Lead::with('comments')->where('id',$id)->first();
        return view('store.lead.comment',compact('lead'));
    }

    public function editComment($id){
         
         $comment = Comment::find($id);
        
         return view('store.lead.editComment',compact('comment')); 
    }

    public function viewImage($id)
    {
     $image = Image::find($id);

     return view('store.lead.viewImage',compact('image'));

    }

    public function updateComment(Request $request){
        
        $comment = Comment::where('id',$request->commentId)->first();
        $comment->update(['body'=>$request->body]);
        return response()->json(['success',true]);
    }

    public function getImages($id){
        
        $lead = Lead::with('images')->where('id',$id)->first();
        return view('store.lead.image',compact('lead'));
        
    }

    public function storeImage(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'image' => 'required',
        ]);

        if($validator->passes()){
        $lead = Lead::with('images')->where('id',$request->leadId)->first();

        $file = $request->file('image');

        $extension = $file->getClientOriginalExtension();
        
        $storeId = StoreHelper::getStoreId();
        $directory = "images/lead-images/".$storeId.'/'.$lead->id.'/';
        $imageCountNumber = $lead->images->count() > 0 ? $lead->images->count() + 1 : 1;
        $fileName =  $lead->id.'-'.$imageCountNumber.".".$extension; 
        // dd(Storage::disk('google')->allFiles());
        // Storage::disk('google')->put($fileName,$directory);
        $file->storeAs($directory,$fileName,'images');
        $imageStatus = $lead->images()->create(['url'=> $directory,'name'=>$fileName,'store_user_id'=>auth('store')->user()->id]);
        if($imageStatus){
            return response()->json(['success',true]);
        }
      } else {
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

    public function assign($leadId)
    {   
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type == "lab" || $authUser->type == "org"){
            $managers = UserStore::where(['org_id'=>$authUser->id,'type'=>'user'])
                            ->orWhere('id',$authUser->id)
                            ->get();
        }
        if($authUser->type == 'user'){
            $managerIds = Helper::getSubRoleManagerIds();
            
            $managers = UserStore::whereIn('id',$managerIds)->get();
            // dd($managers);
        }
    
        $lead = Lead::find($leadId);
        return view('store.lead.assign',compact('managers','lead'));
    }

    public function assignSave(Request $request)
    {
         $lead = LEad::where('id',$request->leadId)->update(['store_user_id'=>$request->manager_id]);
         return response()->json(['success'=> true]);
    }
}
