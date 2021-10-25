<?php

namespace App\Model\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ManagerChallan extends Model
{
    protected $table = "manager_challans";
    
    use SoftDeletes;

    // protected $fillable = ['invoice_detail_grade_id','challan_number','date','manager_id','super_id','status','created_at','updated_at'];
    protected $guarded = [''];

    public function invoiceDetailGrade(){
        return $this->belongsTo("App\Model\Warehouse\InvoiceDetailGrade",'invoice_detail_grade_id','id');
    }

    public function manager(){
        return $this->belongsTo("App\Model\Guard\UserWarehouse",'manager_id','id');
    }

    public function super(){
        return $this->belongsTo("App\Model\Guard\UserWarehouse",'super_id','id');
    }

    public function weightComplete($id){
         
        return InvoiceDetailGradeProduct::where(['weight'=>0,'invoice_detail_grade_id'=> $id])->exists(); 
 
    }

    public function packetsComplete($id){
       
        return  InvoiceDetailGradeProduct::where(['invoice_detail_grade_id'=>$id,'invoice_detail_grade_packet_id'=>0])
       
        ->exists();
    }

    public function returnedToSuper($challanGradeId)
    {
       return InvoiceDetailGradePacket::where(['invoice_detail_grade_id'=>$challanGradeId,'return_to_super'=>0])->doesntExist();
    }

     

    


}
