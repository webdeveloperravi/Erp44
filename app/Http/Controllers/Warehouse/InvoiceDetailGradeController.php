<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Warehouse\InvoiceDetail;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Admin\Master\ProductMGrade;
use Validator;


class InvoiceDetailGradeController extends Controller
{


    public function index($id)
    {
        $invoiceDetail = InvoiceDetail::find($id);
        return view('warehouse.gradesort.index',compact('invoiceDetail'));  
    }


   public function gradesortcreate($id)
   {
      $invoiceDetail =  InvoiceDetail::find($id);
      $gradeList = ProductMGrade::all();
      $oldGrades = InvoiceDetailGrade::where('invoice_detail_id',$id)->get()->pluck('grade_id')->toArray();
      
      $leftCarat = $this->getLeftCarat($id);
      $leftPiece = $this->getLeftPiece($id);
      
      $data =  view('warehouse.gradesort.create',compact('invoiceDetail',"gradeList","leftCarat","leftPiece","oldGrades"))->render();
      return response()->json($data,200);
    
   }

   public function gradesortView($id)
   { 
    $gradeSort = InvoiceDetailGrade::where('invoice_detail_id',$id)->get(); 
    $invoiceDetail =  InvoiceDetail::find($id);
    $totalCarat = $this->totalCountCarat($id);
    $totalPiece = $this->totalCountPiece($id);
    
    if($totalCarat == $invoiceDetail->carat && $totalPiece == $invoiceDetail->piece){
      $generateIdPossible = true;
    }else{
      $generateIdPossible = false;
    }
    $data =  view('warehouse.gradesort.view',compact("gradeSort",'generateIdPossible'))->render();

    return response()->json($data,200);
   }

   public function store(Request $request)
   {

    $validator = Validator::make($request->all(), [
      'invoiceDetailId' => 'required',
      'gradeId' => 'required',
      'carat' => 'required',
      'piece' => 'required'
    ]);

    if ($validator->passes()) {
      $grade = InvoiceDetailGrade::create([
          'invoice_detail_id' => $request->invoiceDetailId,
          'grade_id' => $request->gradeId,
          'user_id' => 1,
          'carat' => $request->carat,
          'piece' => $request->piece
      ]); 
      
      $leftCarat = $this->getLeftCarat($request->invoiceDetailId);
      $leftPiece = $this->getLeftPiece($request->invoiceDetailId); 
      
      if($leftCarat == 0 && $leftPiece == 0){
        $grade->invoiceDetail->update(['complete'=>1]);
      }else{
        $grade->invoiceDetail->update(['complete'=>0]);
      }

      return response()->json([
          'success' => "Grade Added",
          'leftCarat' => $leftCarat,
          'leftPiece' => $leftPiece,
      ],200);
    }

  return response()->json(['errors'=>$validator->errors()->all()]);
    
   }

   public function edit($id){
    
    $gradeList = ProductMGrade::all();
    $gradeSort =  InvoiceDetailGrade::find($id);
    $invoiceId = $gradeSort->invoiceDetail->id;
    $gradeCarat = $gradeSort->carat;
    $gradePiece = $gradeSort->piece;
    $leftCarat = $this->getLeftCarat($invoiceId) + $gradeCarat;
    $leftPiece = $this->getLeftPiece($invoiceId) + $gradePiece;
    return view("warehouse.gradesort.edit",compact('gradeList','gradeSort','leftCarat','leftPiece'));

   }

  public function update(Request $request){
     
   $validator = Validator::make($request->all(), [ 
      'gradeId' => 'required',
      'carat' => 'required',
      'piece' => 'required'
   ]);

  if($validator->passes()){
    $invoiceGrade = InvoiceDetailGrade::find($request->gradeSortId);
    $invoiceGrade->update([
      'grade_id' => $request->gradeId,
      'carat' => $request->carat,
      'piece' => $request->piece
    ]);
       
      $invoiceDetail = InvoiceDetail::find($invoiceGrade->invoiceDetail->id); 
      $leftCarat = $this->getLeftCarat($invoiceDetail->id);
      $leftPiece = $this->getLeftPiece($invoiceDetail->id); 
      
      if($leftCarat == 0 && $leftPiece == 0){
        $invoiceDetail->update(['complete'=>1]);
      }else{
        $invoiceDetail->update(['complete'=>0]);
      }

    return response()->json("Success",200);
  }else{
    return response()->json(['errors'=>$validator->errors()->all()]);
  }
 }

   public function delete(Request $request){
     
     $gradeSort = InvoiceDetailGrade::find($request->gradeId);
     $invoiceDetail = InvoiceDetail::find($gradeSort->invoiceDetail->id); 
     $gradeSort->delete();
     $invoiceDetail = InvoiceDetail::find($gradeSort->invoiceDetail->id); 
     $leftCarat = $this->getLeftCarat($invoiceDetail->id);
     $leftPiece = $this->getLeftPiece($invoiceDetail->id); 
     
     if($leftCarat == 0 && $leftPiece == 0){
       $invoiceDetail->update(['complete'=>1]);
     }else{
       $invoiceDetail->update(['complete'=>0]);
     }
     $gradeSort->delete();
     return response()->json("Successfully Deleted",200);
       
   }

   public function getLeftCarat($invoiceDetailId){
    
    $totalCarat =  InvoiceDetail::find($invoiceDetailId)->carat;
    
        $countCarat = InvoiceDetailGrade::where("invoice_detail_id",$invoiceDetailId)->pluck("carat")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item){
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

   public function totalCountCarat($invoiceDetailId){
       
    $totalCarat =  InvoiceDetail::find($invoiceDetailId)->carat;
    
        $countCarat = InvoiceDetailGrade::where("invoice_detail_id",$invoiceDetailId)->pluck("carat")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
          return $carry + $item;
       });   
       return  $countCarat;
   }

   public function totalCountPiece($invoiceDetailId){
      
    $totalPiece =  InvoiceDetail::find($invoiceDetailId)->piece;
    $countPiece = InvoiceDetailGrade::where("invoice_detail_id",$invoiceDetailId)->pluck("piece")->all();
    $countPiece = collect($countPiece);
    $countPiece = $countPiece->reduce(function ($carry, $item) {
      return $carry + $item;
   }); 
   return $countPiece;
   }

   

}
