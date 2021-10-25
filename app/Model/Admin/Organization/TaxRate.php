<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;


class TaxRate extends Model
{
     use SoftDeletes;
     protected $guarded = [''];
     protected $table="org_tax_rates";

     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }  
     
     public function AssignTaxType(){

     	return $this->belongsTo(TaxType::class,'org_tax_type_id','id');
     }

     public function hsnCode(){
          
          return $this->belongsTo(HSNCode::class,'tax_rate_id','id');
          
     }

}
