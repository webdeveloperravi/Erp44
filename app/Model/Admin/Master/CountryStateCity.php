<?php

namespace App\Model\Admin\Master;

use App\Model\Store\Lead;
use App\Model\Admin\Organization\Zone;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Organization\StoreAddress;

class CountryStateCity extends Model
{
       protected $fillable=['name','state_id','status'];
       protected $table="country_state_cities";

       
     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }

        public function vendor(){

          return $this->hasOne('App\Model\Warehouse\Vendor','country_id','id');
        }

        public function storeAddress(){
          
            return $this->hasMany("App\Model\Admin\Organization\StoreAddress",'city_id','id');
        }


         public function zones(){
     	
           return $this->belongsToMany(Zone::class, 'zone_city', 'zone_id', 'city_id');
      }

      public function getNameAttribute($value)
      {
          return ucwords($value);
      }
   
      public function lead(){

        return hasMany(Lead::class,'city_id','id');
      }
   
      public function townLeads(){

        return hasMany(Lead::class,'town_id','id');
      }

      public function accountTowns()
      {
        return $this->hasMany(StoreAddress::class,'town_id','id');
      }

      public function state()
      {
        return $this->belongsTo(CountryState::class,'state_id','id');
      }

      
      
      
         
 



    
}
