<?php

namespace App\Model\Warehouse;

use App\Model\Warehouse\ManagerChallan;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class InvoiceDetailGrade extends Model
{
    protected $table = "invoice_detail_grade";
    protected $guarded = [''];

    public function invoiceDetail(){
        
        return $this->belongsTo("App\Model\Warehouse\InvoiceDetail","invoice_detail_id","id");
    }
    
    public function grade()
    {
      return $this->belongsTo("App\Model\Admin\Master\ProductMGrade",'grade_id','id');    
    } 

    public function products()
    {
      return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','invoice_detail_grade_id','id');
    }

    public function gradeProdctsCount($id)
    {
      // $products =  InvoiceDetailGradeProduct::where('invoice_detail_grade_id',$id)->first();
      // if(empty($products)){
      //   return false;
      // }else{
      //   return true;
      // }

      return InvoiceDetailGradeProduct::where('invoice_detail_grade_id',$id)->exists();
       
    }

    public function managerChallan(){
      return $this->hasOne(ManagerChallan::class,'invoice_detail_grade_id','id');
    }

    public function managerChallanIssued($sort_id){
     return   $challan = ManagerChallan::where('invoice_detail_grade_id',$sort_id)->exists();
    }

    public function generateIdPossible($gradeSort,$leftCarat,$leftWeight){
        
      return  InvoiceDetailGrade::find($gradeSort);
    }

    public function packets()
    {
          return $this->hasMany("App\Model\Warehouse\InvoiceDetailGradePacket",'invoice_detail_grade_id','id');
    }

 
     
    

}
