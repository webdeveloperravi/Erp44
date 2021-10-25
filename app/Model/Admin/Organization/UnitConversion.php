<?php

namespace App\Model\Admin\Organization;

use App\Model\Admin\Organization\Unit;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;

class UnitConversion extends Model
{
     protected $fillable=['name','unit_main_id','unit_sub_id','conversion','status'];
     protected $table="unit_conversion";


     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }  

     public function assigned_main_unit(){

     	return $this->belongsTo('App\Model\Admin\Organization\Unit','unit_main_id',);
     }
       public function assigned_sub_unit(){

     	return $this->belongsTo('App\Model\Admin\Organization\Unit','unit_sub_id',);
     }

     public function unit(){

      return $this->belongsTo(Unit::Class,'unit_main_id','id');
     }
}


