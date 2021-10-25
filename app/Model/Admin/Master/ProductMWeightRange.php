<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Store\StorePurchaseOrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Warehouse\InvoiceDetailGradePacket;

class ProductMWeightRange extends Model
{
	use SoftDeletes;
	
     protected $fillable=['from', 'to', 'rati_code', 'status'];
     protected $table="product_m_weight_ranges";

     // public function rate_profile(){
     // 	return $this->belongsToMany('App\Model\Admin\Master\RateProfile::class');
     // }

     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }
 

     public function invoiceDetailGradeProducts(){

          return $this->hasMany("App\Model\Warehouse\InvoiceDetailGradeProduct",'weight_range_id','id');
     }

    
     public function invoiceDetailGradeProduct(){
          return $this->hasMany("App\Model\Warehouse\InvoiceDetailGradeProduct",'ratti_id','id');
     }

     public function packets(){
          return $this->hasMany(InvoiceDetailGradePacket::class,'ratti_id','id');
     }

     public function purchaseOrderDetail(){
          return $this->hasMany(StorePurchaseOrderDetail::class,'ratti_id','id');
      }
   
}
