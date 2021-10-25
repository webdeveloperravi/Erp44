<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Master\ProductRateProfileWeightRange;

class ProductRateProfileWeightRangeUnit extends Model
{
      protected $fillable=['rate_profile_weight_range_id','rate_profile_id','ratti_rate','status'];
        protected $table='product_rate_profile_weight_range_unit_rate';

       public function weightRange(){
         return $this->belongsTo(ProductRateProfileWeightRange::class,'rate_profile_weight_range_id0','id');
       }

       public function masterIds()
       {
           return $this->morphMany(MasterCreateUpdate::class, 'masterable');
       }
   


}
