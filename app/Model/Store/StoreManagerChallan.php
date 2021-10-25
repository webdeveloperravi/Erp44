<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use App\Model\Store\StoreSaleOrder;
use Illuminate\Database\Eloquent\Model;

class StoreManagerChallan extends Model
{
     protected $guarded =[''];
     
       public function storeSaleOrder(){
           return $this->belongsTo(StoreSaleOrder::class,'store_sale_order_id','id');

       }
       public function manager(){
           return $this->belongsTo(UserStore::class,'user_store_id','id');
       }

       public function saleOrderChallan(){
           return  $this->hasOne(StoreSaleOrderChallan::class,'store_manager_challan_id','id');
       }
}
