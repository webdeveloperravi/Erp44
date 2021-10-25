<?php

namespace App\Model\Store;

use App\Model\Store\StoreSaleOrder;
use Illuminate\Database\Eloquent\Model; 
use App\Model\Store\StoreSaleOrderPaymentDetail;

class StoreSaleOrderPayment extends Model
{
    protected $table ='store_sale_order_payments';
    protected $guarded =[''];

    public function paymentDetails(){
        return $this->hasMany(StoreSaleOrderPaymentDetail::class,'store_sale_order_payment_id','id');
    }

    public function storeSaleOrder(){
        return $this->belongsTo(StoreSaleOrder::class,'store_sale_order_id','id');
    }
}
