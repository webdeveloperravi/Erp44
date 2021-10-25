<?php

namespace App\Http\Controllers\Warehouse;

use Auth; 
use Session;
use Validator;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Warehouse\Vendor;
use App\Model\Warehouse\Invoice;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Unit;
use App\Model\Warehouse\InvoiceDetail;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Admin\Master\ProductPurchase; 
use App\Model\Admin\Master\ProductCategory;  

class ProductPurchaseController extends Controller
{
    
      public function index()
      { 
         $products = ProductCategory::where(['status'=>1])->get();
         $vendors = Vendor::all(); 
        //  $invoice = "";
         return view('warehouse.product_purchase.index',compact('products','vendors'));
      }

      public function all_invoices(){
         
        $invoices =  Invoice::with('invoiceDetail')->get(); 
        return view('warehouse.product_purchase.all_invoices',compact('invoices'));
      }

      public function pro_purchase_form(){
        
  
        $product = ProductCategory::where(['status'=>1])->get();
        $invoice = null;
        if(!$invoice == null){
           $product_purchase = Invoice::with('invoiceDetail')->where('invoice_id',$invoice)->first();
            
        }else{
           $product_purchase = null;
           $units = Unit::all();
        }
        return view('warehouse.product_purchase.product_purchase',compact('product','product_purchase','units'));  
      }

      public function pro_purchase_list(){

        $pro_purchase_list = ProductPurchase::get();
        return view('warehouse.product_purchase.product_purchase_list',compact('pro_purchase_list'));
      }
     
      protected function invoice_view($vendor,$invoice)
      {   
        $invoice = Invoice::with('invoiceDetail')->where(['vendor_id' => $vendor,'invoice_number' => $invoice])->first();
        if(!empty($invoice)){
          if($invoice->user_id_receive != auth('warehouse')->user()->id && auth('warehouse')->user()->role->id != 1){
            return response()->json(['msg'=>'not_authorized']);
          }
          $invoiceDetail = InvoiceDetail::where('invoice_id',$invoice->id)->pluck('amount')->all();
        }
        if($invoice == null){
          return response()->json(['invoice'=> "NoData"],);  

        }elseif($invoiceDetail == null){
          
          return response()->json(['invoice'=> "NoData"],);
           
       }else{
          $invoiceDate = $invoice->date;
          $invoiceDetail = InvoiceDetail::where('invoice_id',$invoice->id)->pluck('amount')->all();
          $invoiceDetailId = InvoiceDetail::where('invoice_id',$invoice->id)->first()->id;
          $invoiceProduct = InvoiceDetail::where('invoice_id',$invoice->id)->first()->product_id;
          $invoiceComplete = Invoice::find($invoice->id)->complete; 
          $collection = collect($invoiceDetail);

          $total_amount = $collection->reduce(function ($carry, $item) {
            return $carry + $item;
          }); 
          $leftCarat = $this->getLeftCarat($invoiceDetailId);
          $leftPiece = $this->getLeftPiece($invoiceDetailId); 
          
          $data = view('warehouse.product_purchase.invoice_view',compact('invoice','total_amount','leftCarat','leftPiece'))->render();
          
          return response()->json(['invoice'=>$data,'invoiceDate' => $invoiceDate,'invoiceProduct'=>$invoiceProduct,'invoiceComplete'=>$invoiceComplete],200);
        }
     }

     public function invoiceDetailEdit($id)
     {

          $invoice = InvoiceDetail::find($id);
          $product_categories = Product::where('type_id',$invoice->product_id)->pluck('name','id'); 
          $units = Unit::all(); 

          $data =  view('warehouse.product_purchase.edit_invoice',compact('invoice','product_categories','units'))->render();
          return response()->json(['data'=>$data],200);
     }


    protected function get_product_category($productId,$vendorId,$invoiceNumber)
    {   
        $invoice = Invoice::where(['invoice_number'=> $invoiceNumber,'vendor_id'=>$vendorId])->first(); 
        $product_cat = Product::where('type_id',$productId)->pluck('name','id'); 
        $data = view('warehouse.product_purchase.product_cate',compact('product_cat'))->render(); 
        
        return response()->json(['options'=>$data]);
     }

     protected function store(Request $request)
     {    
            $validator = Validator::make($request->all(),[
            'vendor' => 'required', 
            'invoice' => 'required',
            'date' => 'required',
            'product' => 'required',
            'product_category' => 'required',
            'carat' => 'required',
            'piece' => 'required',
            'rate' => 'required',
            'amount' => 'required'
            ]);
            
          if($validator->passes()){
                    
                $unitConversion = $this->unitConversion($request->carat,$request->unit_id); 

                $invoice_check = Invoice::where(['invoice_number'=> $request->invoice,'vendor_id' => $request->vendor])->first();
                
                if(!$invoice_check == null){
        
                $invoice_detail = InvoiceDetail::create([
                    'invoice_id' => $invoice_check->id,
                    'vendor_id' => $request->vendor,
                    'product_id' => $request->product,
                    'product_cate_id' => $request->product_category,
                    'carat' => $unitConversion,
                    'unit_id' => $request->unit_id,
                    'piece' => $request->piece,
                    'rate' => $request->rate,
                    'amount' => $request->amount
                ]);
                $this->updateTotalAmount($invoice_check->id);
              }else{ 
                if(auth('warehouse')->user()->role->id ==  1){
                  $authorization = 1;
                  $authorized_by = auth('warehouse')->user()->id;
                 }else{
                    $authorization = 0;
                    $authorized_by = 0;
                 }
                $invoice = Invoice::create([
                  'invoice_number' => $request->invoice, 
                  'vendor_id' => $request->vendor,  
                  'dept_id_receive' => Auth::guard('warehouse')->user()->guard_id,
                  'user_id_receive' => Auth::guard('warehouse')->user()->id,
                  'date' => $request->date, 
                  'authorization' => $authorization,
                  'authorized_by' => $authorized_by 
                ]); 
      
                $invoice_detail = InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'vendor_id' => $request->vendor,
                    'product_id' => $request->product,
                    'product_cate_id' => $request->product_category,
                    'carat' => $unitConversion,
                    'unit_id' => $request->unit_id,
                    'piece' => $request->piece,
                    'rate' => $request->rate,
                    'amount' => $request->amount
                ]);
                $this->updateTotalAmount($invoice->id);
                
              }
              return response()->json(['invoice_id'=>$invoice->id ??    $invoice_check->id],200);
            }else{
                $keys = $validator->errors()->keys();
                $vals  = $validator->errors()->all();
                $errors = array_combine($keys,$vals);
                return response()->json(['errors'=>$errors]);
          }

          $validator = Validator::make($request->all(), [
            
        ]); 
       }

      public function unitConversion($carat,$unit_id)
      {
          if($unit_id == '1'){
            return $carat;
          }else{
            $unit = Unit::find($unit_id);
            return $carat * $unit->unitConversion->conversion;
          }
      }

      public function invoiceDetailUpdate(Request $request){
        //  dd($request->all());
      

      $validator = Validator::make($request->all(),[
        'productCategory' => 'required', 
          'piece' => 'required',
          'carat' => 'required',
          'rate' => 'required',
          'amount' => 'required'
        ]);

      if($validator->passes()){

        $invoice = InvoiceDetail::find($request->invoiceId);
        if($invoice->carat == $request->carat && $invoice->unit_id == $request->unit_id){
          // dd("saab");
          $invoice->update([
            'product_cate_id' => $request->productCategory, 
            'piece' => $request->piece,
            'rate' => $request->rate,
            'amount' => $request->amount
          ]); 
        }else{
          $unitConversion = $this->unitConversion($request->carat,$request->unit_id);
          //  dd($unitConversion);
          $invoice->update([
            'product_cate_id' => $request->productCategory, 
            'piece' => $request->piece,
            'rate' => $request->rate,
            'carat' => $unitConversion,
            'unit_id' => $request->unit_id,
            'amount' => $request->amount
          ]); 
        }
        
        return response()->json('success',200);

        $this->updateTotalAmount($request->invoiceId);
      }else{
        $keys = $validator->errors()->keys();
                $vals  = $validator->errors()->all();
                $errors = array_combine($keys,$vals);
                return response()->json(['errors'=>$errors]);
      }
      }

       public function invoiceDetailDelete(Request $request)
       {
         
         InvoiceDetail::destroy($request->invoiceId);
         return response()->json('Success',200); 

       }

       public function getLeftCarat($invoiceDetailId){
    
        $totalCarat =  InvoiceDetail::find($invoiceDetailId)->carat;
        
            $countCarat = InvoiceDetailGrade::where("invoice_detail_id",$invoiceDetailId)->pluck("carat")->all();
            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
              return $carry + $item;
           });   
           return  $leftCarat = $totalCarat - $countCarat;
       }
    
       public function getLeftPiece($invoiceDetailId){
        
        $totalPiece =  InvoiceDetail::find($invoiceDetailId)->piece;
        $countPiece = InvoiceDetailGrade::where("invoice_detail_id",$invoiceDetailId)->pluck("piece")->all();
        $countPiece = collect($countPiece);
        $countPiece = $countPiece->reduce(function ($carry, $item) {
          return $carry + $item;
       });
       return  $leftPiece = $totalPiece - $countPiece;
       }

       public function updateTotalAmount($invoice_id){

            $countAmount = InvoiceDetail::where('invoice_id',$invoice_id)->pluck("amount")->all();
      
            $countAmount = collect($countAmount);
            $countAmount = $countAmount->reduce(function ($carry, $item) {
              return $carry + $item;
           });  
           $invoice = invoice::find($invoice_id);
           $invoice->update([
               'total_amount' => $countAmount,
            ]);  
       }

       public function viewInvoice($id){

        $invoice = Invoice::find($id);

         return view('warehouse.product_purchase.view_invoice_detail',compact('invoice'));
       }

       public function complete($id,$type){
         
         if($type == 'complete'){
            $invoice = Invoice::find($id);
            $invoice->update(['complete'=>1]);
            return redirect()->route('warehouse.dashboard');
         }elseif($type == 'gradesort'){
          $invoice = Invoice::find($id);
          $invoice->update(['complete'=>1]);
           return redirect()->route('warehouse.dashboard.invoice',$id);
         }else{
          return redirect()->route('warehouse.dashboard');
         }
       }

       public function checkInvoiceAuthorization($id){
           
           if(auth('warehouse')->user()->role_id == '1'){
             return true;
           }else{
             $invoiceDetail = Invoice::find($id);
             return  $invoiceDetail->authorization == 1 ? true : false;
           }
       } 
}
