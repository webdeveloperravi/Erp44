<?php

namespace App\Model\Admin\Organization;

use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Country;
use App\Model\Admin\Organization\Zone;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Master\MasterCreateUpdate;

class Zone extends Model
{
     protected $fillable=['country_id','state_id','name','alias','description','created_by'];
     protected $table="zones";
     protected $guarded =[''];

     public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

    public function country(){

    	return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state()
    {
    	return $this->belongsTo(CountryState::class,'state_id','id'); 
    }

     public function cities(){

       return $this->belongsToMany(CountryStateCity::class,'zone_city','zone_id', 'city_id');

     }
     
     public function stores(){

      return $this->belongsToMany(UserStore::class,'store_zones','zone_id','store_id');
      }
      
       public function managers(){
          return $this->belongsToMany(Zone::class,'manager_zones','zone_id','manager_id');
      }
 
}    


