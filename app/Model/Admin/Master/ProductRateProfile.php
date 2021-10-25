<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductRateProfile extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['id','name', 'description','parent_sort','status'];
     public $table="product_rate_profiles";

     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }
 
     

    public function weight_ranges(){

    	return $this->belongsToMany('App\Model\Admin\Master\ProductMWeightRange');

    }


    public function grades(){

    	return $this->belongsToMany('App\Model\Admin\Master\ProductGrade');
    }

    public function ProfileWeightRange()
    {
        
      return $this->hasMany('App\Model\Admin\Master\ProductRateProfileWeightRange','rate_profile_id')->where('status',1);
    }

    
    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','rate_profile_id','id');
    }



    
}
