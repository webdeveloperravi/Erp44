<?php

namespace App\Model\Store;

use App\Model\Store\Ledger;
use App\Model\Store\Status;
use App\Model\Store\LedgerDetail;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\DiscountRate;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class LedgerDetail extends Model
{
    protected $guarded = [''];

    public function ledger(){
        return $this->belongsTo(Ledger::class,'ledger_id','id');
    }

    public function productStock(){
        return $this->belongsTo(InvoiceDetailGradeProduct::class,'product_stock_id','id');
    }

    public function saleOrder(){
        return $this->belongsTo(StorePurchaseOrder::class,'temp_number','id');
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable','statusable_id','statusable_type');
    }

    public function discount(){
        return $this->belongsTo(DiscountRate::class,'discount_id','id');
    }

    // public function challanSaved($tempNumber){

    //    $flag =  LedgerDetail::where('ledger_id','!=null'  ,'temp_number',$tempNumber)->exists();

    //    if($flag)
    //    {
    //     return true;
    //    }
    //    else
    //    {
    //     return false;
    //    }

    // }


    // public function checkLedgerIdExist($id){

    //    $flag =  LedgerDetail::where(['id'=>$id, 'ledger_id'=>'null'])->NotE();

    //    if($flag)
    //    {
    //     return true;
    //    }
    //    else
    //    {
    //     return false;
    //    }

    // }

  


    
}
