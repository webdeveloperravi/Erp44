<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Master\ProductRateProfile;
use App\Model\Admin\Master\ProductRateProfileWeightRangeUnit;

class ProductRateProfileWeightRange extends Model
{
    protected $fillable =['id','rate_profile_id', 'start_range', 'end_range', 'from', 'to', 'status','rati_standard'];

    protected $table="product_rate_profile_weight_ranges";
    public $timestamps=true;

   
    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

    public function profile_weight_price()
    {
        return $this->hasOne('App\Model\Admin\Master\ProductRateProfileWeightRangeUnit','rate_profile_weight_range_id')->where('status',1);

    }
    public function historyProductRateProfileWeightRange(){
        return $this->hasOne(ProductRateProfileWeightRangeUnit::class,'rate_profile_weight_range_id','id')->where('status',0);
  
    }


    public function rateProfile(){
        return $this->belongsTo(ProductRateProfile::class,'rate_profile_id','id');
    }

    public function unit(){
        return $this->hasOne(ProductRateProfileWeightRangeUnit::class,'rate_profile_weight_range_id','id');
    }

    
}
