<?php

namespace App\Model\Store;

use App\Model\Store\StoreSaleOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StoreSaleOrderDetail;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StoreSaleOrderDetail extends Model
{
    protected $guarded =[''];

    public function storeSaleOrder(){
        return $this->belongsTo(StoreSaleOrder::class,'store_sale_order_id','id');
    }

    public function productStock(){
        return $this->belongsTo(InvoiceDetailGradeProduct::class,'product_stock_id','id');
    }

    public function getTotalPaymentAmount($orderId){
        
        $totalAmount = StoreSaleOrderDetail::where(['store_sale_order_id'=>$orderId,'delivered'=>'1'])->pluck('rate')->all();
        $totalAmount = collect($totalAmount);
        $totalAmount = $totalAmount->reduce(function ($carry, $item) {
          return $carry + $item;
       });  
        return $totalAmount;
    } 
}