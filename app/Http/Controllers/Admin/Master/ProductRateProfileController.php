<?php

namespace App\Http\Controllers\Admin\Master;

use Session;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RateProfile as req;
use App\Model\Admin\Master\ProductRateProfile as Model;
use App\Model\Admin\Master\ProductMWeightRange as WeightRange;
use App\Http\Requests\Master\Rate_Profile_Weight_Range_Unit as prof_weight_req;
use App\Model\Admin\Master\ProductRateProfileWeightRange as ProfileWeightRelation;
use App\Model\Admin\Master\ProductRateProfileWeightRangeUnit as ProfileWeightPrice;

class ProductRateProfileController extends Controller
{
       
  public function index(){
    $data = Model::all();
    return view('admin.amaster.rate_profile.index', compact('data'));
   }

        public function assignWeightRange($id){
        
         $weight_range = WeightRange::all();

         $profile = Model::find($id);
         $name=$profile->name;
         $pwr = ProfileWeightRelation::where(['rate_profile_id'=>$id, 'status'=>1])->get();
        return view('admin.amaster.rate_profile_weight_range.index',['id'=>$id,'name'=>$name ,'weight_range'=>$weight_range, 'pw_range'=>$pwr]);
        }

        public function store(Request $request){
         $validatedData = $request->validate([
        'name' => "required|unique:product_rate_profiles",
        'description' => "required|unique:product_rate_profiles",
         ]);
            // to fetch parent_sort Max Value
           $parentsort_value=Model::latest()->value('id');
           if($parentsort_value=='')
           {
             $flag=1;
           } 
           else
           {
            $flag=$parentsort_value+1;
           }

           
          $obj  = new Model;
        	$obj->name = $request->name;
        	$obj->description = $request->description;
          $obj->parent_sort=$flag;
        	$obj->save();

          $obj->masterIds()->create([
            'created_id' => Helper::getAdminId()
          ]);
           Session::flash("success"," Record Saved.");
        	return back();
        }

        public function parentSort(Request $request)
           {
     
        $psort=$request->parent_id;
        $parentsort=1;
       
           foreach ($psort as $ps_key => $ps_val) {
      
          Model::where(['id'=>$ps_val])->update(['parent_sort'=>$parentsort]);
          $parentsort++;
          }
            return response()->json(["success"=>"Parent Sort Updated"]);
       }

       protected function from_to_value($start_range_id , $end_range_id) {

           $start = WeightRange::select('from')->where('id',$start_range_id)->first();
           $end = WeightRange::select('to')->where('id',$end_range_id)->first();

           return [$start->from, $end->to ];
        }

        protected function get_rati_standard($start_range_id , $end_range_id ){
          
          $standard = WeightRange::whereBetween('id',[$start_range_id,$end_range_id])->pluck('rati_standard');

          $standard_value =  $standard->map(function($item){
           return Str::afterLast($item,')');
          });

          return $standard_value->implode(', ');
        }

         
          public function rateWeightStore(Request $request){
            $new = [  
                      'rate_profile_id' => $request->rate_profile_id, 
                      'start_range' => $request->start_range,
                      'end_range' => $request->end_range,
                      'status'=>1 
                    ];

             if(ProfileWeightRelation::where($new)->exists()){
                  Session::flash('error','This Range Already exists');
                  return back();
                }

          

            $start_end_value = $this->from_to_value($request->start_range, $request->end_range);
            $rati_standard = $this->get_rati_standard($request->start_range, $request->end_range);
              
              $pw  = new ProfileWeightRelation();
              $pw->fill($new); 
              $pw->from = $start_end_value[0];
              $pw->to = $start_end_value[1];
              $pw->rati_standard=$rati_standard;
              $pw->save();

               // to save price in rate_weight_ranges_unit_price

               $pw_rate = new ProfileWeightPrice();
               $pw_rate->rate_profile_id=$request->rate_profile_id;
               $pw_rate->rate_profile_weight_range_id= $pw->id;
               $pw_rate->ratti_rate = $request->ratti_rate;
               $pw_rate->save();

               $pw->masterIds()->create([
               
                'created_id' => Helper::getAdminId()

               ]);

               $pw_rate->masterIds()->create([
               
                'created_id' => Helper::getAdminId()

               ]);
                Session::flash("success"," Record Saved.");
                return back();
              
           
        
}
          protected function update_price(Request $request)
            {
               
               
             ProfileWeightPrice::where(['rate_profile_weight_range_id'=>$request->rate_profile_weight_range_id])->update(['status'=>0]);

             $profile_weight_price = new ProfileWeightPrice();
             $profile_weight_price->rate_profile_weight_range_id = $request->rate_profile_weight_range_id;
             $profile_weight_price->ratti_rate = $request->price_update;
             $profile_weight_price->rate_profile_id=$request->rate_profile_id;
             $profile_weight_price->save();

             
             $profile_weight_price->masterIds()->create([
               
              'updated_id' => Helper::getAdminId()

             ]);


              Session::flash("success"," Record Updated.");
                  return back();
            }


          protected function new_range($id)
              {

               $rate_profile_weight_range = ProfileWeightRelation::where(['rate_profile_id'=>$id,'status'=>'1'])->get()->   pluck('id');
              
              foreach ($rate_profile_weight_range as $pw_key => $pw_val) {
                            
               ProfileWeightPrice::where(['rate_profile_weight_range_id'=>$pw_val])->update(['status'=>0]);
                ProfileWeightRelation::where(['id'=>$pw_val])->update(['status'=>0]);
                  }
                 
               return back();

          }
             
          public function update(Request $request){

           $rate_profile_id =$request->id;  // get color  id

         // validation is part
          $validatedData = $request->validate([

        'name' => "required|unique:product_rate_profiles,name,$rate_profile_id",
        'description' => "required|unique:product_rate_profiles,description,$rate_profile_id",
    ]);
        	
        $rateProfile =	 Model::where(['id'=>$request->id])->first();
        $rateProfile->update(['name'=>$request->name,'description'=>$request->description]);
        $rateProfile->masterIds()->create([
          'updated_id' => Helper::getAdminId()
        ]);
                
              Session::flash("success"," Record Updated.");   
            	return back();
        }

 

          protected function store_price_history($rateProfileId)
           {
                  
               
                 $rateProfiles = ProfileWeightRelation::with('historyProductRateProfileWeightRange')->Select('id','rate_profile_id','from','to','rati_standard')->where(['rate_profile_id'=>$rateProfileId,'status'=>0])->latest()->get();
                 
          


          //  $data=ProfileWeightRelation::where(['rate_profile_id'=>$id, 'status'=>0])->select('updated_at')->latest()->get();  
          //      foreach ($data as $rati_id => $val) {
                    
          //              $data=ProfileWeightPrice::where(['updated_at'=>$val->updated_at,'status'=>0])->select('ratti_rate')->get();

          //         }
           
                    return view('admin.amaster.price_history.index',compact('rateProfiles'));

           }

         function get_price_history($id,$date)
         {
              $profile_weight_price=ProfileWeightPrice::where(['rate_profile_id' =>$id, 'status' => 0])->whereDate('updated_at', '=', date($date))->select('id','ratti_rate','updated_at')->get();
              return response()->json($profile_weight_price);
         }  



         protected function fetchPriceHistory(Request $request)
         {

        
          $fetch_price_history='';
           $flag=0;
            $updated_dates = ProfileWeightPrice::where(['id_rate_profiles'=>$request->profile_id, 'status'=>0])->pluck('updated_at','id');
                  

                      $updated_dates =  $updated_dates->map(function($item){
                             return Str::substr($item,0,10);
                             
                           });

                      $fetch_date=$request->date;
                    

                     
                     foreach ($updated_dates as $key => $value) {
                       
                             if($value==$fetch_date)
                             {
                                $flag=1;
                               
                          break;
                             }
                             else
                             {
                              $flag=0;
                                
                             }

                     }
              
              if($flag==1)
              {
                 $fetch_price_history=ProfileWeightPrice::where(['id_rate_profiles'=>$request->profile_id,'status'=>0])->select('id','ratti_rate','updated_at')->get();
              
             return response()->json($fetch_price_history);
              }
              else
              {
                 return response()->json($fetch_price_history);
              }
              
   
           }

}

