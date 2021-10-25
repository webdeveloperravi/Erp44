<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Master\ProductRateProfile;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ProductGradeRateProfile extends Model
{
	use SoftDeletes;
    
    // protected $fillable=['product_id','grade_id', 'rate_profile_id', 'status'];
    protected $guarded = [''];

      protected $table='product_grade_rate_profiles';

      public function masterIds()
      {
          return $this->morphMany(MasterCreateUpdate::class, 'masterable');
      }
  

      
      public function category(){
	    	return $this->belongsTo('App\Model\Admin\Master\Product','product_id');
       }

       public function grade(){

      		return $this->belongsTo('App\Model\Admin\Master\ProductMGrade','grade_id')->where('status','=',1);

      }
       public function assignRateProfile(){

      		return $this->belongsTo('App\Model\Admin\Master\ProductRateProfile','rate_profile_id');

      }

      public function assignGrade()
      {
        return $this->hasMany('App\Model\Admin\Master\ProductMGradeGrade','grade_id','id');
      }

       public function getGrade($id){
        return ProductMGrade::find($id);
    }

    public function getRateProfile($id){
        return ProductRateProfile::find($id);
    }
    
     

}
