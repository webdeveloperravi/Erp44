<?php

namespace App\Model\Admin\Master;

use App\Model\Store\Lead;
use App\Model\Admin\Master\Area;
use App\Model\Admin\Master\Zone;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\CountryStateCity;

class CountryState extends Model
{
    protected $fillable=['name','country_id','status'];
       protected $table="country_states";

        public function vendor(){

          return $this->hasOne('App\Model\Warehouse\Vendor','country_id','id');
        }
          public function storeAddress(){
        
            return $this->hasMany("app\Model\Admin\Organization\StoreAddress",'state_id','id');
        }

        public function zones(){
        	return $this->hasMany(Zone::class,'state_id','id');
        }

        public function areas(){
        	return $this->hasMany(Area::class,'state_id','id');
        }

        public function getNameAttribute($value)
        {
            return ucwords($value);
        }

        public function lead(){

          return hasMany(Lead::class,'state_id','id');
      }

      public function cities()
      {
        return $this->hasMany(CountryStateCity::class,'state_id','id');
      }
     
}
