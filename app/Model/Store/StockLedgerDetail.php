<?php

namespace App\Model\Store;

use App\Model\Store\StockLedger;
use App\Model\Store\PaymentLedger;
use App\Model\Warehouse\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StockLedgerDetail extends Model
{   
    protected $guarded = [''];
    protected $table = "stock_ledger_details";
  
    public function stockLedger(){
        return $this->belongsTo(StockLedger::class,'stock_ledger_id','id');
    }

    public function productStock(){
        return $this->belongsTo(InvoiceDetailGradeProduct::class,'product_stock_id','id');
    }
    
    
}
