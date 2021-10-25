<?php

namespace App\Http\Controllers\Warehouse\Manager;

use Illuminate\Http\Request;
use App\Model\Guard\UserWarehouse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Warehouse\ManagerChallan;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ManagerWeightController extends Controller
{   
    
    // public function __construct(){
    //     // $this->middleware('check_manager_weight');
    // }
    
    public function index(Request $request)
    {
       $products = InvoiceDetailGradeProduct::where(['invoice_detail_grade_id'=>$request->gradeId])->where('weight','>','0')->get();
       $challan = ManagerChallan::where('invoice_detail_grade_id',$request->gradeId)->first();
       $gradeId = $request->gradeId; 
        $leftWeight = $this->leftWeight($request->gradeId);
        $leftPiece =  $this->leftPiece($request->gradeId);
       if($products){
           return view('warehouse.manager.weight.index',compact('products','challan','leftWeight','leftPiece','gradeId'));
       }else{
           return response()->json('no',200);
       }
    }

    
    public function create($id)
    {
        // $challan = ManagerChallan::find($id); 
        $challan = ManagerChallan::where('manager_id',auth('warehouse')->user()->id)->where('id',$id)->first();
        if(empty($challan)){
            return  abort(403);
        }
        $rattis =  $this->getRattis($challan->invoiceDetailGrade->id);
        if($challan->status == 'weight_complete'){

            return view('warehouse.manager.weight.create',compact('challan','rattis')); 
        }else{

            $challan->update([
                'status'=> 'in_progress'
            ]); 
            return view('warehouse.manager.weight.create',compact('challan','rattis'));
        }
    }

    public function getRattis($gradeId){
        $products = InvoiceDetailGradeProduct::where('invoice_detail_grade_id',$gradeId)->where('invoice_detail_grade_packet_id',0)->get()->pluck('ratti_id')->toArray();
        $products =  array_unique($products);
        return  $rattis = ProductMWeightRange::find($products); 
    }

    public function getProduct(Request $request){

        $product = InvoiceDetailGradeProduct::where(['invoice_detail_grade_id'=>$request->gradeId,'id'=>$request->productNumber])->first();
        if($product){
            if($product->weight > 0){ 
                return view('warehouse.manager.weight.not_exists',['message'=> "Product Weight Already Generated"]);
            }else{
                return view('warehouse.manager.weight.product_detail',compact('product'));
            }
        }else{
             return view('warehouse.manager.weight.not_exists',['message'=> "Product Not Found"]);
        }
    }
 
    public function store(Request $request)
    { 

     $ratti = ProductMWeightRange::where('from','<=',$request->weight)->where('to','>=',$request->weight)->first();
     $product =  InvoiceDetailGradeProduct::find($request->productId);
     $product->update(['weight'=>$request->weight,'ratti_id'=>$ratti->id]);

     
     return response()->json('success',200);
    }
 
    public function edit($id)
    {
        $product = InvoiceDetailGradeProduct::find($id);
        return view('warehouse.manager.weight.edit',compact('product'));
    }

    public function finish($id){
        
        $grade = ManagerChallan::where('invoice_detail_grade_id',$id)->first();
        $grade->update(['status'=> 'weight_complete']);
        return redirect()->route('manager.challan.packet.all',$id);
    }
  
    public function leftProducts($gradeId){
          
      $products =   InvoiceDetailGradeProduct::where('invoice_detail_grade_id',$gradeId)->where('weight','=','0')->get();
      $productsCount = $products->count();
      $leftWeight = $this->leftWeight($gradeId);
      $leftPiece =  $this->leftPiece($gradeId);
      $data =  view('warehouse.manager.weight.left_products',compact('products','leftWeight','leftPiece'))->render();
      return response()->json(['data'=>$data,'productsCount'=>$productsCount]);
      
    } 

    public function leftWeight($grade_id){
        
        $totalCarat =  InvoiceDetailGrade::find($grade_id)->carat;
        $totalPiece =  InvoiceDetailGrade::find($grade_id)->piece;

    
        $countWeight = InvoiceDetailGradeProduct::where("invoice_detail_grade_id",$grade_id)->pluck("weight")->all();
        $countWeight = collect($countWeight);
        $countWeight = $countWeight->reduce(function ($carry, $item) {
          return $carry + $item;
       });   
       return  $leftWeight = $totalCarat - $countWeight;

    }

    public function leftPiece($grade_id){
        
        // $totalCarat =  InvoiceDetailGrade::find($grade_id)->carat;
        $totalPiece =  InvoiceDetailGrade::find($grade_id)->piece;

    
        $countPiece = InvoiceDetailGradeProduct::where("invoice_detail_grade_id",$grade_id)->where('weight','=','0')->get();
         
         return count($countPiece);
    //     $countPiece = collect($countPiece);
    //     $countPiece = $countWeight->reduce(function ($carry, $item) {
    //       return $carry + $item;
    //    });   
    //    return  $leftWeight = $totalCarat - $countWeight;

    }
}
