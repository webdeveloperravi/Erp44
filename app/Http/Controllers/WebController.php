<?php

namespace App\Http\Controllers;

use App\Item;
use App\Ifvalue;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Facades\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductGradeRateProfile;

class WebController extends Controller
{  
   public function checking()
   {
      $route = request()->route();
      $domain = $route->parameter('subdomain');
      dd($domain);
      dd("Saab Subdomain");
   }
   public function barcodeExport()
   {
    $items = InvoiceDetailGradeProduct::limit(5)->get();
    view()->share('items',$items);
    $pdf = PDF::loadView('barcode-export');
    // download PDF file with download method
    return $pdf->download('barcode-pdf.pdf');
   }

   public function clear()
   {
      Artisan::call('config:cache');
    Artisan::call('config:clear');
   //  Artisan::call('cache:clear');
   }

   public function convert_2()
   {
     InvoiceDetailGradeProduct::each(function ($product){
        $ratti = ProductMWeightRange::where('from','<=',$product->weight)->where('to','>=',$product->weight)->first();
        $product->update([ 'ratti_id' => $ratti->id ?? ""]);
     });
  
     
     // $products = InvoiceDetailGradeProduct::with('item')->get();
     // // $products = InvoiceDetailGradeProduct::with('item')->whereNotNull('ratti_id')->count();
     // // dd($products);
     // foreach($products as $product){
     //    // dump($product->itemid,$product->itemid);
     //    $ratti = ProductMWeightRange::where('from','<=',$product->weight)->where('to','>=',$product->weight)->first();
     //    $product->update([ 'ratti_id' => $ratti->id ?? "",'iname'=> $product->item->iname ]);
     // }
     // if($item->ifValue->count() > 0){
        //    $ratti = ProductMWeightRange::where('from','<=',$item->ifValue->weight)->where('to','>=',$item->ifValue->weight)->first();
        //    $item->update(['ratti_id'=> $ratti->id]);
        // }
     // return InvoiceDetailGradeProduct::count();
  //  $items = Item::all()->each(function ($item) {
        
  //       // $item->update([
  //       //    'iname'        => $ifvalue->item->iname ?? "", 
  //       //    'gin'            => $ifvalue->item->icode ?? "",
  //       // ]);
  //       // dd($ifvalue);
  //       $products = InvoiceDetailGradeProduct::create([
  //           'iname'        => $item->iname ?? "",
  //           'item_id'        => $item->itemid ?? "",
  //           'gin'            => $item->icode ?? "",

  //           'field19'            => $item->field19 ?? "",
  //           'product_id'     => $item->product_id ?? "",

  //           'length'         => $item->ifValue->field1 ?? "",
  //           'width'          => $item->ifValue->field2 ?? "",
  //           'depth'          => $item->ifValue->field3 ?? "",
  //           'weight'         => $item->ifValue->field4 ?? "",
  //           'primary_image'  => $item->ifValue->field11 ?? "",
  //           'product_category_id' =>  '2',             

  //           'color_id'     => $item->ifValue->color_id ?? "",
  //           'field7'       => $item->ifValue->field7 ?? "",

  //           'clarity_id'   => $item->ifValue->clarity_id ?? "",
  //           'field9'       => $item->ifValue->field9 ?? "",

  //           'treatment_id'   => $item->ifValue->treatment_id ?? "",
  //           'field10'       => $item->ifValue->field10 ?? "",
            
  //           'grade_id'     => $item->ifValue->grade_id ?? "", 
  //           'field19'      => $item->ifValue->field19 ?? "",
            
  //           'origin_id'    => $item->ifValue->origin_id ?? "",
  //           'field13'      => $item->ifValue->field13 ?? "",
            
  //           'shape_id'     => $item->ifValue->shape_id ?? "",
  //           'field8'       => $item->ifValue->field8 ?? "",

  //           'sg'  => $item->ifValue->length ?? "",
  //           'ri'  => $item->ifValue->length ?? "",
  //           'status'  => '1',
  //           'final'   => '1',
  //           //  'specie_id'    => $item->ifValue->specie ?? "",
  //          ]);
// });


//     $items = Ifvalue::each(function ($ifvalue) {
        
//          $products = InvoiceDetailGradeProduct::create([
//              'iname'        => $item->iname ?? "",
//              'item_id'        => $item->itemid ?? "",
//              'gin'            => $item->icode ?? "",

//              'field19'            => $item->field19 ?? "",
//              'product_id'     => $item->product_id ?? "",

//              'length'         => $item->ifValue->field1 ?? "",
//              'width'          => $item->ifValue->field2 ?? "",
//              'depth'          => $item->ifValue->field3 ?? "",
//              'weight'         => $item->ifValue->field4 ?? "",
//              'primary_image'  => $item->ifValue->field11 ?? "",
//              'product_category_id' =>  '2',             

//              'color_id'     => $item->ifValue->color_id ?? "",
//              'field7'       => $item->ifValue->field7 ?? "",

//              'clarity_id'   => $item->ifValue->clarity_id ?? "",
//              'field9'       => $item->ifValue->field9 ?? "",

//              'treatment_id'   => $item->ifValue->treatment_id ?? "",
//              'field10'       => $item->ifValue->field10 ?? "",
            
//              'grade_id'     => $item->ifValue->grade_id ?? "", 
//              'field19'      => $item->ifValue->field19 ?? "",
            
//              'origin_id'    => $item->ifValue->origin_id ?? "",
//              'field13'      => $item->ifValue->field13 ?? "",
            
//              'shape_id'     => $item->ifValue->shape_id ?? "",
//              'field8'       => $item->ifValue->field8 ?? "",

//              'sg'  => $item->ifValue->length ?? "",
//              'ri'  => $item->ifValue->length ?? "",
//              'status'  => '1',
//              'final'   => '1',
//              //  'specie_id'    => $item->ifValue->specie ?? "",
//             ]);
// });
   return "Success";
   }

   public function convert()
   {
    $items = InvoiceDetailGradeProduct::select('id','product_id','grade_id','rate_profile_id')->get();
    
    //Add Product ID in Items Table
      foreach($items as $item){
      //   $name =  explode('-',$item->iname); 
 
         // if($name[0] == "Coral"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '3' ]);
         // }

         // if($name[0] == "Emerald"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '4' ]);
         // }

         
         // if($name[0] == "Pearl"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '6' ]);
         // }
         
         // if($name[0] == "Blue Sapphire"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '1' ]);
         // }
         
         // if($name[0] == "Cats Eye"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '2' ]);
         // }
         
         // if($name[0] == "Hessonite"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '5' ]);
         // }

         // if($name[0] == "Ruby"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '7' ]);
         // }

         // if($name[0] == "Sapphire"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '11' ]);
         // }

         // if($name[0] == "White Sapphire"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '8' ]);
         // }

         // if($name[0] == "Yellow Sapphire"){ 
         //    // dump($item->product_id);
         //    $item->update(['product_id' => '9' ]);
         // }

         // Enter rate profile in tbl_item
         if($item->product_id > 0 && $item->grade_id > 0){
            $rateProfile = ProductGradeRateProfile::where(['product_id'=> $item->product_id,'grade_id'=> $item->grade_id])
                                                   ->select('rate_profile_id')
                                                   ->first();
            
             $item->update(['rate_profile_id'=>$rateProfile->id]);
         }


         //Enter Ratti Id in item Table
         // if($item->ifValue->count() > 0){
         //    $ratti = ProductMWeightRange::where('from','<=',$item->ifValue->weight)->where('to','>=',$item->ifValue->weight)->first();
         //    $item->update(['ratti_id'=> $ratti->id]);
         // }
      } 
 



     
  
         // $items = Item::with('ifValue')->get()->each(function ($item) {
         
         // $products = InvoiceDetailGradeProduct::create([
         //     'item_id'        => $item->item_id ?? "",
         //     'gin'            => $item->icode ?? "",
         //     'ratti_id'       => $item->ratti_id ?? "",
         //     'length'         => $item->ifValue->length ?? "",
         //     'width'          => $item->ifValue->width ?? "",
         //     'depth'          => $item->ifValue->depth ?? "",
         //     'weight'         => $item->ifValue->weight ?? "",
         //     'primary_image'  => $item->ifValue->picture ?? "",
         //     'product_id'     => $item->product_id?? "",
         //     'product_category_id' =>  '2' ?? "",             
         //     'color_id'     => $item->ifValue->color ?? "",
         //     'clarity_id'   => $item->ifValue->clarity ?? "",
         //     'grade_id'     => $item->ifValue->grade_code ?? "",
         //     'rate_profile_id'   => $item->rate_profile_id ?? "",
         //     'origin_id'    => $item->ifValue->origin ?? "",
         //     'shape_id'     => $item->ifValue->shape ?? "",
         //     'specie_id'    => $item->ifValue->specie ?? "",
         //     'sg'  => $item->ifValue->length ?? "",
         //     'ri'  => $item->ifValue->length ?? "",
         //     'status'  => '1',
         //     'final'   => '1',
         // ]);

         // DB::table('master_lookups')->insert([     
         //     'code'              =>  $akun->code,
         //     'name'             =>  $akun->name,
         //     'information'   =>  json_encode($akun->code_shopping),
         // ]);
   //   });

   //   $items = Item::all();
  
   //   foreach($items as $item){
   //    InvoiceDetailGradeProduct::create([
   //       'item_id'        => $item->item_id ?? "",
   //       'gin'            => $item->icode ?? "",
   //       'ratti_id'       => $item->ratti_id ?? "",
   //       'length'         => $item->ifValue->length ?? "",
   //       'width'          => $item->ifValue->width ?? "",
   //       'depth'          => $item->ifValue->depth ?? "",
   //       'weight'         => $item->ifValue->weight ?? "",
   //       'primary_image'  => $item->ifValue->picture ?? "",
   //       'product_id'     => $item->product_id?? "",
   //       'product_category_id' =>  '2' ?? "",             
   //       'color_id'     => $item->ifValue->color ?? "",
   //       'clarity_id'   => $item->ifValue->clarity ?? "",
   //       'grade_id'     => $item->ifValue->grade_code ?? "",
   //       'rate_profile_id'   => $item->rate_profile_id ?? "",
   //       'origin_id'    => $item->ifValue->origin ?? "",
   //       'shape_id'     => $item->ifValue->shape ?? "",
   //       'specie_id'    => $item->ifValue->specie ?? "",
   //       'sg'  => $item->ifValue->length ?? "",
   //       'ri'  => $item->ifValue->length ?? "",
   //       'status'  => '1',
   //       'final'   => '1',
   //    ]);
   //   }
     
      return "Success";
   }

   public function getIp()
   {
       // dd(request()->ip());
   dd(location::get('185.206.224.67')->countryName);
   $platform = Agent::platform();
    
  return Agent::device();
   dd( get_browser(null, true));
   // return $_SERVER['REMOTE_ADDR'];
   $ip = '106.78.53.213';
   $data = \Location::get($ip);
   dd($data);
   }
   public function yes()
   {
    $arrays = ['72:0','73:1','159:2','160:3','75:4','305:5','86:6','83:7']; 
    $newArrays = [];
    foreach($arrays as $array){
          $newArray[] = substr($array,0,strpos($array,':'));
    }
    dd($newArray);
   }

   public function saab()
   {  
      // Session::forget('data'); 
      $productId = '1';
      Session::push('data',$productId);
      return Session::get('data');
   }
}

