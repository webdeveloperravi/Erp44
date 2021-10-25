<?php

namespace App\Http\Controllers\Warehouse\Manager;

use Auth;
use Session;
use Validator;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Exports\ItemExport; 
use Illuminate\Http\Request;
   
use App\Model\Warehouse\ManagerPacket;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Admin\Master\ProductMRi as Ri;
use App\Model\Admin\Master\ProductMSg as Sg;
use App\Model\Warehouse\InvoiceDetailGradeProduct as Item;
use App\Model\Warehouse\PacketProcessingChallan;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Admin\Master\ProductMShape as Shape;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductMGrade as Grade ;
use App\Model\Admin\Master\ProductMOrigin as Origin;
use App\Model\Admin\Master\ProductMSpecie as Specie;
use App\Model\Admin\Master\ProductMClarity as Clarity;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Model\Admin\Master\ProductGradeRateProfile as CGRP;
use App\Model\Admin\Master\ProductMTreatment as Treatment; 
use App\Model\Admin\Master\ProductRateProfile as RateProfile;
use App\Model\Admin\Master\ProductRateProfileWeightRange as RPWR;
use App\Model\Admin\Master\ProductRateProfileWeightRangeUnit as RPWRU;
use PDF;

class PacketProcessController extends Controller
{
    
    public function index()
    {
        // $packets = InvoiceDetailGradePacket::with(['managerPackets'=> function($packet){
        //     return $packet->where('manager_id',auth('warehouse')->user()->id);
        // }])->get();
        $challans = PacketProcessingChallan::with('packet','manager','super')->where('manager_id',auth('warehouse')->user()->id)
        // ->where('status','!=','return-to-super')
        ->latest()->get();
        $heading = "Packet Process Challans";
        return view('warehouse.manager.packet_process.index',compact('challans','heading')); 
    }

    
    public function preview($id)
    {
        $challan =  PacketProcessingChallan::with([
            'super:id,name',
            'super.role:id,name',
            // 'invoiceDetailGrade.invoiceDetail.invoice:id,invoice_number',
            // 'invoiceDetailGrade.invoiceDetail.product:id,name',
            // 'invoiceDetailGrade.invoiceDetail.assign_product:id,name',
            // 'invoiceDetailGrade.grade:id,alias', 
            ])->where(['manager_id'=>auth('warehouse')->user()->id,'id'=>$id])->first(); 
            // $heading = 'Weight Challans';
        return view('warehouse.manager.packet_process.preview',compact('challan'));
    }


    public function rejectPacketChallan($challanId){

      PacketProcessingChallan::find($challanId)->delete();
      return redirect()->back();

    }

    public function acceptPacketChallan($challanId)
    {
       return PacketProcessingChallan::where('id',$challanId)->update(['accept_challan'=>1]);
    }

    public function finish($challanId)
    {
      return PacketProcessingChallan::where('id',$challanId)->update(['finsh'=>1]);
    }

    public function create($packetId){
        
    $products = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>0])->get(); 
    $packet = InvoiceDetailGradePacket::find($packetId);

     return view('warehouse.manager.packet_process.create',compact('products','packet'));

    }

    public function productCreate(Request $request){
        $product = InvoiceDetailGradeProduct::where(['id'=>$request->productNumber,'invoice_detail_grade_packet_id'=>$request->packetId,'final'=>0])->first();
        if($product){
            $category=Product::where('parent_id','=',0)->get(); 
            return view('warehouse.manager.packet_process.product_create',compact('product','category'));
        }elseif($product = InvoiceDetailGradeProduct::where(['id'=>$request->productNumber,'invoice_detail_grade_packet_id'=>$request->packetId,'final'=>1])->first()){
            return view('warehouse.manager.packet_process.product_already_generated',['message'=>'Product Already Generated']);
        }else{
            return view('warehouse.manager.packet_process.product_already_generated',['message'=>'Product Not Exist']);   
        }
    }

    public function leftProducts($packetId){
        
        $products = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>0])->get();
        $finalProducts = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>1])->get();
        $challan = PacketProcessingChallan::where('packet_id',$packetId)->first();
        
        return view('warehouse.manager.packet_process.left_products',compact('products','challan'));

    }

    public function leftProductsView($packetId){
      $products = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>0])->get();
      $packet = InvoiceDetailGradePacket::find($packetId);
      return view('warehouse.manager.packet_process.left_product_widget',compact('products','packet'));
    }

    public function productsList($packetId){
      $products = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>1])->get();
      return view('warehouse.manager.packet_process.products_list',compact('products'));
    }

    public function printLabel($packetId){
      
      $products = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>1])->get(); 
      return view('warehouse.gradesort_product.printFinalProductLabel1',compact('products'));
    //   try{ 
    //  $data = InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>$packetId,'final'=>1])->get(); 
    //  view()->share('products',$data);
    //  $pdf = PDF::loadView('warehouse.gradesort_product.printFinalProductLabel1');
      
    //  return $pdf->download('pdf_file.pdf');
    //  }catch(DOMPDF_Exception $e){
    //      echo '<pre>',print_r($e),'</pre>';
    //  }
    }

    public function generateGin(){ 
      $ginOld = Item::orderByDesc('gin')->first()->gin ?? 122232; 
      return $ginOld+1;
    }
      protected  function allItem(){
       $items=Item::all();
       return  view('admin.amaster.item.fetch_items',compact('items'));
      }

    

    public function store(Request $request){
         
        

         $user_id=Helper::getGuardUser();
          
       
       $validator=Validator::make($request->all(),[
        'product_id'=>"required|not_in:Select Product",
        'grade_id'=>"required|not_in:Select Grade",
        'weight'=>"required",
        // 'rate_profile_id' => 'required',
        'specie_id'=>"required|",
        'sg'=>"required|not_in:Select SG",
        'ri'=>"required|not_in:Select RI",
        'length'=>"required",
        'width'=>"required",
        'depth'=>"required",
        'color_id'=>"required|not_in:Select Color",
        'clarity_id'=>"required|not_in:Select Clarity",
        'shape_id'=>"required|not_in:Select Shape",
        'origin_id'=>"required|not_in:Select Origin",
        'treatment_id'=>"required|not_in:0",
        'gin'=>"required|min:4|max:30|string",
        'grade_id' => 'required', 
        'rate_profile_id' => 'required', 

         ]
      );
        
     if($validator->fails())
     {
              
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);

           return response()->json(['errors'=> $errors],200);
     }
     else
     {   
         $product = Item::find($request->product);
         $product->update([ 
             'product_id'=>$request->product_id,
            'grade_id'=>$request->grade_id,
            'weight'=>$request->weight,
            'rate_profile_id' => $request->rate_profile_id,
            'specie_id'=>$request->specie_id,
            'sg'=>$request->sg,
            'ri'=>$request->ri,
            'length'=>$request->length,
            'width'=>$request->width,
            'depth'=>$request->depth,
            'color_id'=>$request->color_id,
            'clarity_id'=>$request->clarity_id,
            'shape_id'=>$request->shape_id,
            'origin_id'=>$request->origin_id,
            'treatment_id'=>$request->treatment_id,
            'gin'=>$request->gin,
            'final' => '1',
         ]);
         
 
          return response()->json(['success' => 'Your Data has been Successfully done.'],200);
     }

    }

    

    public function associate_data($id){

       $res= array();

        // to generate gin value 
       $gin_val= Item::pluck('gin')->last();
       if($gin_val==null || $gin_val==0)
       {
          $gin_val=11223301;
        
       }
       else{
        $gin_val=$gin_val+1; 
       }
       
       // to find product id from Product Table

      $data=Product::find($id);

      // to generate rand value of ri
      $sg_from_value=$data->SG->from;
      $sg_to_value=$data->SG->to;
      $generate_rand_sg=number_format(rand($sg_from_value,$sg_to_value),3);
  
      // to generate rand value of ri
      $ri_from_value=$data->RI->from;
      $ri_to_value=$data->RI->to;
      $generate_rand_ri=number_format(rand($ri_from_value,$ri_to_value),3);

       $ri=Ri::where(['status'=> 1])->select('id','from','to')->get();
       $res['c']= $data->colors->pluck('color','id')->sortBy('color');
       $res["clarity"] = $data->clarity->pluck('clarity','id');
       $res["grade"]  =  $data->grade->pluck('grade','id')->sortBy('parent_sort');
       $res["origin"] = $data->origin->pluck('origin','id')->sortBy('origin');
       $res["shape"] = $data->shape->pluck('shape','id')->sortBy('shape');
       $res["specie"] = $data->Specie->species;
       $res["specie_id"] = $data->specie;
       $res["sg"] = $generate_rand_sg;
       $res["ri"] = $generate_rand_ri;
       $res["gin"]= $gin_val;
       $res["treatment"] = $data->treatment->pluck('treatment','id')->sortBy('treatment');
        
        return response()->json($res);


    }


    public function status($id,$status){
        $user_id=Helper::getGuardUser();
       if($status==1)
       {
        $status=0;
       }
       else
       {
        $status=1;
       }
        Item::where(['id'=>$id])->update(['status'=>$status,'created_by'=>$user_id]);
        return response()->json(["success"=>'Status Changed']);

    }

   public function edit($id)
   {
       $categories=Product::all();
       $get_items=Item::find($id)->first();
       $data=Product::find($get_items->product_id);
       $res["color"] = $data->colors->pluck('color','id');
       $res["clarity"] = $data->clarity->pluck('clarity','id');
       $res["grade"] = $data->grade->pluck('grade','id');
       $res["origin"] = $data->origin->pluck('origin','id');
       $res["shape"] = $data->shape->pluck('shape','id');
       $res["specie"] =$data->Specie->species;
      $res["treatment"] = $data->treatment->pluck('treatment','id');
        // if($get_items->assignRateProfile()->exists())
        // {
        //          dd($get_items->assignRateProfile->name);
        // }

    return view('admin.amaster.item.edit_stock',compact('categories','get_items','res'));
   }


    public function update(Request $request){
     
      $user_id=Helper::getGuardUser();

     $messages=[
               'required'=> 'The :attribute field is required'
         ];
       
       $validation=Validator::make($request->all(),[
        
          'color_id'=>"required|not_in:Select Color",
          'clarity_id'=>"required|not_in:Select Clarity",
          'grade_id'=>"required|not_in:Select Grade",
          'origin_id'=>"required|not_in:Select Origin",
          'shape_id'=>"required|not_in:Select Shape",
          'specie_id'=>"required|not_in:Select Specie",
          'treatment_id'=>"required|not_in:Select Treatment",
          'length'=>"required",
          'width'=>"required",
          'depth'=>"required",
          'weight'=>"required",
         

        ], 
        $messages

      ); 

      if($validation->fails())
     {
         // $response=$validation->messages();
           return response()->json(array('success'=>false, 'errors'=>$validation->messages()),401);
     } 
     else{

           $item_update= Item::where(['id'=>$request->item_id])->update(['length'=>$request->length,'width'=>$request->width,'depth'=>$request->depth,'weight'=>$request->weight,'color_id'=>$request->color_id,'clarity_id'=>$request->clarity_id,'grade_id'=>$request->grade_id,'origin_id'=>$request->origin_id,'shape_id'=>$request->shape_id,'treatment_id'=>$request->treatment_id,'created_by'=>$user_id]);

         return response()->json(['success'=>"Record Updated"],200);
     } 
}

    public function destroy( $id)
    {
       
       Item::find($id)->delete();

      return response()->json(["success"=>'Record Deleted']);
      
    }


    public function getRateProfile($cid,$gid)  // to get Rate Profile from select grade
    {
        $rate_id = CGRP::where(['product_id'=>$cid,'grade_id'=>$gid,'status'=>1])->select('rate_profile_id','id')->first();
         if(empty($rate_id)) {
            return response()->json(['profile_name'=>'Not Set Grade']);
         }else{
            if($rate_id->assignRateProfile()->exists()){
              return  response()->json(['profile_id'=>$rate_id->assignRateProfile->id,
                                       'profile_name'=> $rate_id->assignRateProfile->name]);
           }  
        }
    }


  // calculate Weight

   public function getCalculateWeight($wei_val,$rate_id)
   {
        
        $res= RPWR::select('id','from')->where(['rate_profile_id'=>$rate_id,'status'=>1])->where('from','<=',$wei_val)->where('to','>=',$wei_val)->first();

        if(empty($res))
        {
             return response()->json(['notexist'=>'Rate Profile is not assigned Range']);
        }
        else
        {
         $unit_price= RPWRU::select('ratti_rate')->where(['rate_profile_weight_range_id'=>$res->id,'status'=>1])->first();
            
             $stan_rati=number_format($wei_val/120,2);
             $rati_rate=$unit_price->ratti_rate;
             $mrp=(float)$stan_rati*$unit_price->ratti_rate;
          
             
             $decimal_point=substr($stan_rati, -2);

             // dd('stand_Rati'+$stan_rati+"Rati Rate"+$rati_rate+"Mrp"+$mrp,$decimal_point);
                 
               
             
               if($decimal_point>=0 && $decimal_point<=67)
               {
                  $stan_rati=['true'=>$stan_rati];
               }
               else
               {
                 $stan_rati=['false'=>$stan_rati];
               }
 
                   return response()->json([$stan_rati,'rati'=>$rati_rate,'mrp'=>$mrp]);
                      // dd($stan_rati,$rati_rate,$mrp,$decimal_point);
         
        }
   }

   public function returnToSuper($challanId){
      
    // PacketProcessingChallan::where('packet_id',$packetId)->first()->update(['status'=>'']);
     $challan =  PacketProcessingChallan::where('id',$challanId)->first();
     $challan->status = 'return-to-super'; 
     $challan->save(); 
      return redirect()->route('packetProcess.index');
   }


 
}
