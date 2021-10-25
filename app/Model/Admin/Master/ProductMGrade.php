<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Store\StorePurchaseOrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductMGrade extends Model
{
	use SoftDeletes;
    protected $fillable = ['id','grade', 'alias','descr','parent_sort', 'status'];
     protected $table='product_m_grades';
     
      
    protected static function boot()
    {
        parent::boot();
    
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }


     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }
 

     
      public function rate_profile(){

    	   return $this->belongsToMany('App\Model\Admin\Master\RateProfile');
        
        }

     public function assignProfile(){

      return $this->hasMany('App\Model\Admin\Master\ProductGradeRateProfile','grade_id','id')->where('status',1);
    }

    public function assign_grade_profile(){

    	return $this->hasMany('App\Model\Admin\Master\ProductGradeRateProfile','grade_id','id')->where('status',1);
    }

     public function assignCategoryGrade()
    {
       return $this->hasMany('App\Model\Admin\Master\ProductGradeRateProfile','grade_id')->where('status',1);
    }

    public function purchaseOrderDetail(){
      return $this->hasMany(StorePurchaseOrderDetail::class,'grade_id','id');
  }

  public function productStocks(){
    return $this->hasMany(InvoiceDetailGradeProduct::class,'grade_id','id');
  }
    

}
