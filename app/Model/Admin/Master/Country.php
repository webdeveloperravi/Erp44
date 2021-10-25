<?php

namespace App\Model\Admin\Master;

use App\Model\Store\Lead;
use App\Model\Admin\Master\Area;
use App\Model\Admin\Master\Zone;
use Illuminate\Database\Eloquent\Model;



class Country extends Model
{
    
       protected $fillable=['name','status'];
       protected $table="countries";



       public function assigned_c(){
     
             return $this->hasOne('App\Model\Admin\Master\Country','country_id');

     }

      public function vendor(){

          return $this->hasOne('App\Model\Warehouse\Vendor','country_id','id');
      }
 
 
    public function storeAddress(){
        
        return $this->hasMany("app\Model\Admin\Organization\StoreAddress",'country_id','id');
    }

    public function zones(){
      return $this->hasMany(Zone::class,'country_id','id');
    }

    public function areas(){
      return $this->hasMany(Area::class,'country_id','id');
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function lead(){

      return hasMany(Lead::class,'country_id','id');
  }

}
