<?php

namespace App\Model\Store;
 
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StoreSaleOrderDetail;
use App\Model\Store\StoreSaleOrderPayment;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StoreSaleOrderPaymentDetail extends Model
{
    protected $table ='store_sale_order_payment_details';
    protected $guarded =[''];

    public function payment(){
        return $this->belongsTo(StoreSaleOrderPayment::class,'store_sale_order_payment_id','id');
    }

    public function productStock(){
        return $this->belongsTo(InvoiceDetailGradeProduct::class,'product_stock_id','id');
    }

    public function getProductPaymentAmount($detailId,$orderId){
        return StoreSaleOrderDetail::where(['store_sale_order_id'=>$orderId,'product_stock_id'=>$detailId])->first()->rate;
    }


}
