<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StoreSaleOrderChallanDetail extends Model
{
   protected $guarded = [''];

   public function challan(){
       return $this->belongsTo(StoreSaleOrderChallan::class,'store_sale_order_challan_id','id');
   }

   public function productStock(){
       return $this->belongsTo(InvoiceDetailGradeProduct::class,'product_stock_id','id');
   }
}
