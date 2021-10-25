<?php

namespace App\Model\Store\Invoice;

use App\Model\Store\Ledger;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class InvoiceDetail extends Model
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
    
    public function countTotalDiscount($ledgerId)
    { 
         
            $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("discount_amount")->all();
            $countCarat = collect($countCarat);
            $countCarat = $countCarat->reduce(function ($carry, $item) {
                return $carry + $item;
             }); 
             return $countCarat; 
    }
  


    
}
