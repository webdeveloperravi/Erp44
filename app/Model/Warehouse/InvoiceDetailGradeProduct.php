<?php

namespace App\Model\Warehouse;

use App\Item;
use App\Model\Log;
use App\Model\Admin\Master\Product;
use App\Model\Store\LedgerDetailTemp;
use App\Model\Admin\Master\ProductMRi;
use App\Model\Admin\Master\ProductMSg;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMShape;
use App\Model\Store\StoreSaleOrderDetail;
use App\Model\Admin\Master\ProductMColour;
use App\Model\Admin\Master\ProductMOrigin;
use App\Model\Admin\Master\ProductMSpecie;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Admin\Master\ProductMClarity;
use App\Model\Admin\Master\ProductMTreatment;
use App\Model\Admin\Master\ProductRateProfile;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Store\StoreSaleOrderPaymentDetail;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductRateProfileWeightRange;

 

class InvoiceDetailGradeProduct extends Model
{
  //  protected $table = 'invoice_detail_grade_products';
   protected $table = 'product_stocks';
   // protected $fillable = ['id','invoice_detail_grade_id','invoice_detail_grade_packet_id','number','ratti_id','weight','alias'];
   protected $guarded = [''];

   public function grade()
   {
     return $this->belongsTo('App\Model\Warehouse\InvoiceDetailGrade','invoice_detail_grade_id','id');    
   }

   public function weightRange(){
     return $this->belongsTo("App\Model\Admin\Master\ProductMWeightRange",'weight_range_id','id');
   }
   public function ratti()
   {
      return $this->belongsTo(ProductMWeightRange::class,'ratti_id','id');
   }

   public function alreadyGenerated($gradeId,$rattiId){
      return   InvoiceDetailGradePacket::where(['invoice_detail_grade_id'=>$gradeId,'ratti_id'=>$rattiId])->exists();
   }

   public function packet(){
      return $this->belongsTo(InvoiceDetailGradePacket::class,'invoice_detail_grade_packet_id','id');
   }

   public function color(){
      return $this->belongsTo(ProductMColour::class,'color_id','id');
   }

   public function clarity(){
      return $this->belongsTo(ProductMClarity::class,'clarity_id','id');
   }

   public function rateProfile(){
      return $this->belongsTo(ProductRateProfile::class,'rate_profile_id','id');
   }

   public function origin(){
      return $this->belongsTo(ProductMOrigin::class,'origin_id','id');
   }

   public function shape(){
    return $this->belongsTo(ProductMShape::class,'shape_id','id');
 }
   public function specie(){
    return $this->belongsTo(ProductMSpecie::class,'specie_id','id');
 }
   public function sg(){
    return $this->belongsTo(ProductMSg::class,'sg','id');
 }
   public function ri(){
    return $this->belongsTo(ProductMRi::class,'ri','id');
 }
   public function treatment(){
    return $this->belongsTo(ProductMTreatment::class,'treatment_id','id');
 }
   public function saleOrderDetails(){
    return $this->hasMany(StoreSaleOrderDetail::class,'product_stock_id','id');
 }

 public function getProductPrice($productId){
    
   $product = InvoiceDetailGradeProduct::with('rateProfile')->where('id',$productId)->first();
   if($product->rateProfile > 0){
      return $weightRange = ProductRateProfileWeightRange::where('rate_profile_id',$product->rateProfile->id)->where('from','<',$product->weight)->where('to','>=',$product->weight)->first()->unit->ratti_rate;
   }

 }
 public function storeSaleOrderPaymentDetails(){
    return $this->hasmany(StoreSaleOrderPaymentDetail::class,'product_stock_id','id');
 }

 public function product(){
   
    return $this->belongsTo(Product::class,'product_id','id');

 }
 public function productCategory(){
   
    return $this->belongsTo(ProductCategory::class,'product_category_id','id');

 }

 public function productGrade(){
    return $this->belongsTo(ProductMGrade::class,'grade_id','id');
 }
 
 public function item()
 {
    return $this->hasOne(Item::class,'itemid','itemid');
 }

 public function getExactRattiWeight($productWeight)
 {
     return  $stan_rati=number_format($productWeight/120,2);
 }
  
 
 public function ledgerDetailTemps()
 {
     return $this->hasMany(LedgerDetailTemp::class,'product_stock_id','id');
 }
 
 

 public function logs()
 {
     return $this->morphMany(Log::class,'logable');
 }

}
