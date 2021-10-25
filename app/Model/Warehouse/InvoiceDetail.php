<?php

namespace App\Model\Warehouse;
use App\Model\Admin\Organization\Unit;
use App\Model\Warehouse\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGrade;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
     use softDeletes;

     protected $table="invoice_product_detail";

     protected $fillable =['vendor_id','invoice_id','product_id','product_cate_id','carat','piece','amount','status','rate','unit_id','complete'];



     public function assign_product(){

        return $this->belongsTo('App\Model\Admin\Master\ProductCategory','product_id','id');

    } 

     public function product(){

        return $this->belongsTo('App\Model\Admin\Master\Product','product_cate_id','id');

    }

    public function invoice(){

        return $this->belongsTo('App\Model\Warehouse\Invoice','invoice_id','id');
    }

    public function gradesorts(){

        return $this->hasMany("App\Model\Warehouse\InvoiceDetailGrade",'invoice_detail_id','id');
    }
 
    public function unit(){
         return $this->belongsTo(Unit::class,'unit_id','id');       
    }


    public function checkGradeSortStatus($invoiceDetailId)
    { 
        $leftCarat = $this->getLeftCarat($invoiceDetailId);
        $leftPiece = $this->getLeftPiece($invoiceDetailId);
        
        if($leftCarat < 1 && $leftPiece < 1){

            return true;
        }else{
            return false;
        }
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

    //    public function setCaratAttribute($value)
    // {   
        
    //     $this->attributes['carat'] = $value * 200;
    // }

    public function weightUnit($weight,$unitId){
       if($unitId == "1"){
           return $weight . " mg";
       }else{
           $unit =  Unit::find($unitId);
           $unitF = $weight / $unit->unitConversion->conversion ?? "";
           return $unitF .' ' .$unit->name;
       }
    }

    public function getTotalWeight($invoice_detail_id)
    {
      
      $total_weight_from_grade_detail = InvoiceDetailGrade::where("invoice_detail_id",$invoice_detail_id)->pluck("carat")->all();
        $total_weight_from_grade_detail = collect($total_weight_from_grade_detail);
        $total_weight_from_grade_detail = $total_weight_from_grade_detail->reduce(function ($carry, $item) {
          return $carry + $item;
       });   
       return  $total_weight_from_grade_detail;
  
    }


    public function getTotalPieces($invoice_detail_id)
    {
      
      $total_pieces_from_grade_detail = InvoiceDetailGrade::where("invoice_detail_id",$invoice_detail_id)->pluck("piece")->all();
        $total_pieces_from_grade_detail = collect($total_pieces_from_grade_detail);
        $total_pieces_from_grade_detail = $total_pieces_from_grade_detail->reduce(function ($carry, $item) {
          return $carry + $item;
       });   
       return  $total_pieces_from_grade_detail;
  
    }

    public function getTotalPieces2($invoice_detail_id)
    {
      
      $total_pieces_from_grade_detail = InvoiceDetailGrade::where("invoice_detail_id",$invoice_detail_id)->pluck("piece");
        $total_pieces_from_grade_detail = collect($total_pieces_from_grade_detail);
        $total_pieces_from_grade_detail = $total_pieces_from_grade_detail->reduce(function ($carry, $item) {
          return $carry + $item;
       });   
       return  $total_pieces_from_grade_detail;
  
    }

    public function unitConversionBack($carat,$unit_id){
        if($unit_id == '1'){
          return $carat;
        }else{
          $unit = Unit::find($unit_id);
          return $carat / $unit->unitConversion->conversion;
        }
     }


     public function checkGenerateIdStatus($invoiceDetailId)
     {                 
                                                  // $q->with('products');
        $invoiceDetailIds = InvoiceDetail::find($invoiceDetailId)->gradesorts->pluck('id');
        $invoiceDetailGradeIds = InvoiceDetailGrade::whereIn('id',$invoiceDetailIds)->pluck('id');
         $productsCount = InvoiceDetailGradeProduct::whereIn('invoice_detail_grade_id',$invoiceDetailGradeIds)->count();
        //  return $this->getTotalPieces2($invoiceDetailId);
        if($productsCount == $this->getTotalPieces2($invoiceDetailId)){
          return true;
        }     else{
          return false;
        }

     }
     
     public function issuedToManager($invoiceDetailId)
     {
       return InvoiceDetail::where('id',$invoiceDetailId)->whereHas('gradesorts',function($q){
                             $q->where('issue_to_manager','0');
       })->doesntExist();
     }


}
